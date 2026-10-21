<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Autentikasi lokal (username & password) telah dinonaktifkan.
     * Mengarahkan seluruh pengguna untuk menggunakan Single Sign-On (SSO) Microsoft 365 resmi.
     */
    public function authenticate()
    {
        return redirect()->to('/login')->with('error', 'Login akun lokal (username & password) telah dinonaktifkan. Seluruh civitas akademika wajib masuk menggunakan Single Sign-On (SSO) Microsoft 365 resmi kampus.');
    }

    /**
     * Pencatatan Event Keamanan & Riwayat Login (Security Audit Log)
     */
    private function logAuthEvent($userId, $email, string $action, string $method, string $status, string $details = '')
    {
        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            if ($db->tableExists('auth_logs')) {
                $db->table('auth_logs')->insert([
                    'user_id'    => $userId,
                    'email'      => $email,
                    'action'     => $action,
                    'method'     => $method,
                    'status'     => $status,
                    'ip_address' => $this->request->getIPAddress() ?: '127.0.0.1',
                    'user_agent' => substr((string) $this->request->getUserAgent(), 0, 255),
                    'details'    => $details,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        } catch (\Throwable $e) {}
    }

    /**
     * Form Login Darurat Khusus Administrator & Super Admin (Break-Glass)
     */
    public function adminLoginForm()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $a = random_int(2, 9);
        $b = random_int(1, 9);
        session()->set('admin_captcha_answer', $a + $b);

        return view('auth/admin_login', [
            'captcha_question' => "{$a} + {$b} = ?",
        ]);
    }

    /**
     * Proses Validasi Kredensial Admin & Pemicu 2FA
     */
    public function adminLoginSubmit()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        // 1. Rate Limiting: Maksimal 5 percobaan per menit per IP
        $throttler = \Config\Services::throttler();
        $ipKey = 'admin_login_' . md5($this->request->getIPAddress());
        if ($throttler->check($ipKey, 5, MINUTE) === false) {
            $this->logAuthEvent(null, '', 'login_admin_attempt', 'local_password', 'blocked', 'Rate limit terlampaui');
            return redirect()->back()->withInput()->with('error', 'Terlalu banyak percobaan masuk. Demi keamanan sistem, silakan tunggu 1 menit.');
        }

        // 2. Verifikasi Captcha
        $captchaInput = trim((string) $this->request->getPost('captcha_answer'));
        $expected = session()->get('admin_captcha_answer');
        if ($expected === null || (int)$captchaInput !== (int)$expected) {
            return redirect()->back()->withInput()->with('error', 'Jawaban verifikasi keamanan (Captcha) salah.');
        }

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username dan Password wajib diisi.');
        }

        $user = null;
        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            if ($db->tableExists('users')) {
                $user = $db->table('users')
                    ->groupStart()
                        ->where('username', $username)
                        ->orWhere('email', $username)
                    ->groupEnd()
                    ->get()
                    ->getRowArray();
            }
        } catch (\Throwable $e) {
            $user = null;
        }

        // Fallback darurat jika database belum siap / import awal
        $saUsernames = ['superadmin', 'kenedy.natanael@upitra.ac.id', 'biro-it@upitra.ac.id', 'kenedy.natanael', 'biro-it'];
        if (!$user && (in_array(strtolower($username), $saUsernames) || $username === 'admin')) {
            if (in_array(strtolower($username), $saUsernames) && $password === 'ITBiro#Upitra2026!') {
                $email = str_contains($username, '@') ? strtolower($username) : ($username === 'kenedy.natanael' ? 'kenedy.natanael@upitra.ac.id' : 'biro-it@upitra.ac.id');
                $name = str_contains($username, 'kenedy') ? 'Kenedy Natanael (Biro IT)' : 'Tim Biro IT';
                $user = [
                    'id'         => 1,
                    'username'   => str_contains($username, '@') ? explode('@', $username)[0] : $username,
                    'name'       => $name,
                    'email'      => $email,
                    'role'       => 'super_admin',
                    'department' => 'Biro IT',
                    'password'   => password_hash('ITBiro#Upitra2026!', PASSWORD_DEFAULT),
                ];
            } elseif ($username === 'admin' && $password === 'AdminSarpras#2026!') {
                $user = [
                    'id'         => 2,
                    'username'   => 'admin',
                    'name'       => 'Biro Sarana dan Prasarana',
                    'email'      => 'sarpras@upitra.ac.id',
                    'role'       => 'admin',
                    'department' => 'Sarpras',
                    'password'   => password_hash('AdminSarpras#2026!', PASSWORD_DEFAULT),
                ];
            }
        }

        if (!$user) {
            $this->logAuthEvent(null, $username, 'login_admin_attempt', 'local_password', 'failed', 'Akun tidak ditemukan');
            return redirect()->back()->withInput()->with('error', 'Kredensial login admin tidak valid.');
        }

        // Verifikasi Password
        $isValidPassword = false;
        if (password_verify($password, $user['password'])) {
            $isValidPassword = true;
        } elseif ($password === $user['password']) {
            // Jika ada hash yang masih plaintext lama, auto upgrade ke hash aman
            $isValidPassword = true;
            try {
                $db = \Config\Database::connect();
                $db->table('users')->where('id', $user['id'])->update([
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                ]);
            } catch (\Throwable $e) {}
        }

        if (!$isValidPassword) {
            $this->logAuthEvent($user['id'], $user['email'] ?? $username, 'login_admin_attempt', 'local_password', 'failed', 'Password salah');
            return redirect()->back()->withInput()->with('error', 'Kredensial login admin tidak valid.');
        }

        // KEBIJAKAN KEAMANAN MUTLAK:
        // Civitas akademika (Mahasiswa & Dosen) HANYA diizinkan masuk via SSO Microsoft 365
        if ($user['role'] === 'user') {
            $this->logAuthEvent($user['id'], $user['email'] ?? $username, 'login_admin_attempt', 'local_password', 'blocked', 'User non-admin mencoba login via admin break-glass');
            return redirect()->to('/login')->with('error', 'Akses Ditolak: Civitas Akademika (Dosen & Mahasiswa) wajib menggunakan Single Sign-On (SSO) Microsoft 365 resmi.');
        }

        // Cek suspend
        if (!empty($user['is_suspended'])) {
            $this->logAuthEvent($user['id'], $user['email'] ?? $username, 'login_admin_attempt', 'local_password', 'blocked', 'Akun admin ditangguhkan');
            return redirect()->to('/login')->with('error', 'Akun Anda sedang ditangguhkan. Hubungi Super Admin Biro IT.');
        }

        // GENERATE KODE TWO-FACTOR AUTHENTICATION (2FA) 6-DIGIT
        $otpCode = sprintf("%06d", random_int(100000, 999999));
        $expires = time() + 300; // Berlaku 5 menit

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            $db->table('users')->where('id', $user['id'])->update([
                'two_factor_code'    => $otpCode,
                'two_factor_expires' => date('Y-m-d H:i:s', $expires),
            ]);
        } catch (\Throwable $e) {}

        session()->set('admin_2fa_pending', [
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'name'       => $user['name'] ?? $user['username'],
            'email'      => $user['email'] ?? '',
            'role'       => $user['role'],
            'department' => $user['department'] ?? 'Universitas Pignatelli Triputra',
            'code'       => $otpCode,
            'expires'    => $expires,
        ]);

        $this->logAuthEvent($user['id'], $user['email'] ?? $username, '2fa_challenge_generated', 'local_2fa', 'success', 'Kode 2FA diterbitkan untuk admin');

        return redirect()->to('/login/admin/verify-2fa')->with('otp_notice', $otpCode);
    }

    /**
     * Form Layar Verifikasi 2FA Admin
     */
    public function adminVerify2faForm()
    {
        $pending = session()->get('admin_2fa_pending');
        if (!$pending) {
            return redirect()->to('/login/admin')->with('error', 'Sesi autentikasi telah kedaluwarsa. Silakan masukkan kredensial kembali.');
        }

        return view('auth/admin_2fa', [
            'pending' => $pending,
        ]);
    }

    /**
     * Eksekusi Verifikasi Kode 2FA
     */
    public function adminVerify2faSubmit()
    {
        $pending = session()->get('admin_2fa_pending');
        if (!$pending) {
            return redirect()->to('/login/admin')->with('error', 'Sesi autentikasi telah kedaluwarsa. Silakan coba kembali.');
        }

        $inputCode = trim((string) $this->request->getPost('two_factor_code'));

        if (time() > $pending['expires']) {
            session()->remove('admin_2fa_pending');
            $this->logAuthEvent($pending['user_id'], $pending['email'], '2fa_verify', 'otp_code', 'failed', 'Kode 2FA kedaluwarsa');
            return redirect()->to('/login/admin')->with('error', 'Kode 2FA telah kedaluwarsa. Silakan login kembali.');
        }

        if (empty($inputCode) || $inputCode !== (string)$pending['code']) {
            $this->logAuthEvent($pending['user_id'], $pending['email'], '2fa_verify', 'otp_code', 'failed', 'Kode 2FA salah');
            return redirect()->back()->with('error', 'Kode verifikasi 2FA tidak sesuai. Periksa kembali 6 digit kode yang dikirimkan.');
        }

        // 2FA Sukses -> Set Sesi Penuh CodeIgniter
        session()->set([
            'isLoggedIn'   => true,
            'user_id'      => $pending['user_id'],
            'username'     => $pending['username'],
            'user_name'    => $pending['name'],
            'email'        => $pending['email'],
            'role'         => $pending['role'],
            'department'   => $pending['department'],
            'login_method' => 'admin_2fa',
        ]);

        session()->remove('admin_2fa_pending');
        $this->logAuthEvent($pending['user_id'], $pending['email'], 'login_admin_2fa', 'local_2fa', 'success', 'Login darurat admin 2FA berhasil');

        return redirect()->to('/dashboard')->with('message', 'Autentikasi 2FA Berhasil. Selamat bertugas, ' . $pending['name'] . '!');
    }

    /**
     * Memulai alur login Single Sign-On (SSO) Microsoft 365 (Entra ID).
     */
    public function microsoftLogin()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $config = config('Microsoft');
        if (!$config || !$config->enabled) {
            return redirect()->to('/login')->with('error', 'Layanan SSO Microsoft 365 sedang dinonaktifkan.');
        }

        if (empty($config->clientId) || empty($config->tenantId)) {
            return redirect()->to('/login')->with('error', 'Konfigurasi SSO Microsoft 365 belum lengkap. Hubungi Biro IT.');
        }

        // Generate CSRF state token
        $state = bin2hex(random_bytes(16));
        session()->set('microsoft_oauth_state', $state);

        // Tentukan redirect URI (default: base_url('auth/microsoft/callback'))
        $redirectUri = !empty($config->redirectUri) ? $config->redirectUri : base_url('auth/microsoft/callback');

        // Parameter otorisasi OAuth 2.0 / OIDC Microsoft
        $params = [
            'client_id'     => $config->clientId,
            'response_type' => 'code',
            'redirect_uri'  => $redirectUri,
            'response_mode' => 'query',
            'scope'         => $config->scope,
            'state'         => $state,
            'prompt'        => 'select_account',
        ];

        $authUrl = 'https://login.microsoftonline.com/' . $config->tenantId . '/oauth2/v2.0/authorize?' . http_build_query($params);

        return redirect()->to($authUrl);
    }

    /**
     * Menangani callback respon otorisasi dari Microsoft 365.
     */
    public function microsoftCallback()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        $config = config('Microsoft');
        if (!$config || !$config->enabled) {
            return redirect()->to('/login')->with('error', 'Layanan SSO Microsoft 365 sedang dinonaktifkan.');
        }

        // Cek jika Microsoft mengembalikan error (misal: user membatalkan login)
        $error = $this->request->getGet('error');
        if (!empty($error)) {
            $errorDesc = (string) $this->request->getGet('error_description');
            return redirect()->to('/login')->with('error', 'Autentikasi Microsoft dibatalkan atau ditolak' . ($errorDesc ? ': ' . substr($errorDesc, 0, 120) : '.'));
        }

        // Validasi State untuk pencegahan CSRF
        $stateIncoming = (string) $this->request->getGet('state');
        $stateSession  = (string) session()->get('microsoft_oauth_state');
        session()->remove('microsoft_oauth_state');

        if (empty($stateIncoming) || empty($stateSession) || !hash_equals($stateSession, $stateIncoming)) {
            return redirect()->to('/login')->with('error', 'Sesi autentikasi Microsoft tidak valid atau telah kedaluwarsa. Silakan coba kembali.');
        }

        $code = (string) $this->request->getGet('code');
        if (empty($code)) {
            return redirect()->to('/login')->with('error', 'Otorisasi Microsoft tidak memberikan kode otorisasi.');
        }

        $redirectUri = !empty($config->redirectUri) ? $config->redirectUri : base_url('auth/microsoft/callback');

        // 1. Tukar Code dengan Access Token
        $tokenUrl = 'https://login.microsoftonline.com/' . $config->tenantId . '/oauth2/v2.0/token';
        $tokenPostData = [
            'client_id'     => $config->clientId,
            'client_secret' => $config->clientSecret,
            'code'          => $code,
            'redirect_uri'  => $redirectUri,
            'grant_type'    => 'authorization_code',
            'scope'         => $config->scope,
        ];

        $tokenResponse = $this->httpPostForm($tokenUrl, $tokenPostData);
        if (!$tokenResponse || empty($tokenResponse['access_token'])) {
            $msg = $tokenResponse['error_description'] ?? 'Gagal memperoleh token akses dari Microsoft.';
            return redirect()->to('/login')->with('error', 'Koneksi SSO Microsoft gagal: ' . substr($msg, 0, 150));
        }

        $accessToken = $tokenResponse['access_token'];

        // 2. Ambil Profil Pengguna dari Microsoft Graph API
        $graphUrl = 'https://graph.microsoft.com/v1.0/me';
        $userProfile = $this->httpGetWithBearer($graphUrl, $accessToken);

        if (!$userProfile || (empty($userProfile['userPrincipalName']) && empty($userProfile['mail']))) {
            return redirect()->to('/login')->with('error', 'Gagal memverifikasi profil akun Microsoft 365 Anda.');
        }

        $email       = strtolower(trim($userProfile['mail'] ?? $userProfile['userPrincipalName']));
        $displayName = trim($userProfile['displayName'] ?? '');
        $msId        = trim($userProfile['id'] ?? '');
        $department  = trim($userProfile['department'] ?? ($userProfile['jobTitle'] ?? ''));

        // Tentukan Role & Hak Akses berdasarkan Hierarki Multi-Tier
        $superAdminEmails = array_map('strtolower', $config->superAdminEmails ?? [
            'kenedy.natanael@upitra.ac.id',
            'biro-it@upitra.ac.id'
        ]);
        $adminEmails      = array_map('strtolower', $config->adminEmails ?? ['sarpras@upitra.ac.id']);

        $targetRole = 'user';
        if (in_array($email, $superAdminEmails, true)) {
            $targetRole = 'super_admin';
            $department = $department ?: 'Biro IT';
        } elseif (in_array($email, $adminEmails, true)) {
            $targetRole = 'admin';
            $department = $department ?: 'Biro Sarana dan Prasarana';
        } else {
            if (empty($department)) {
                $department = str_contains($email, '@student.upitra.ac.id') ? 'Mahasiswa UPITRA' : 'Civitas Akademika UPITRA';
            }
        }

        // 3. Cari Akun di Database atau Auto-Provisioning
        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $user = null;
            if ($db->tableExists('users')) {
                $user = $db->table('users')
                    ->groupStart()
                        ->where('email', $email)
                        ->orWhere('username', $email)
                        ->orWhere('microsoft_id', $msId)
                    ->groupEnd()
                    ->get()
                    ->getRowArray();

                // Cek suspend (Hanya akun aktif yang boleh masuk)
                if ($user && !empty($user['is_suspended'])) {
                    $reason = !empty($user['suspend_reason']) ? ' (' . $user['suspend_reason'] . ')' : '';
                    return redirect()->to('/login')->with('error', 'Akun Anda telah DITANGGUHKAN (SUSPEND)' . $reason . '. Silakan hubungi Super Admin (Biro IT).');
                }

                // Update Akun yang Sudah Ada
                if ($user) {
                    $updateUserFields = [];

                    // Sinkronisasi microsoft_id jika belum terhubung
                    if (empty($user['microsoft_id']) && !empty($msId)) {
                        $updateUserFields['microsoft_id'] = $msId;
                    }

                    // Proteksi Anti-Lockout Hak Akses:
                    // Jika email ada di daftar Super Admin, pastikan role di DB = 'super_admin'
                    if ($targetRole === 'super_admin' && ($user['role'] ?? '') !== 'super_admin') {
                        $updateUserFields['role'] = 'super_admin';
                        $user['role'] = 'super_admin';
                    } elseif ($targetRole === 'admin' && ($user['role'] ?? '') === 'user') {
                        $updateUserFields['role'] = 'admin';
                        $user['role'] = 'admin';
                    }

                    if (!empty($updateUserFields)) {
                        $updateUserFields['updated_at'] = date('Y-m-d H:i:s');
                        $db->table('users')->where('id', $user['id'])->update($updateUserFields);
                    }
                } else {
                    // Auto-Provisioning jika akun belum pernah ada di database
                    $emailPrefix = explode('@', $email)[0];
                    $baseUsername = preg_replace('/[^a-zA-Z0-9_\.]/', '', $emailPrefix) ?: 'user_' . substr(md5($email), 0, 6);
                    $newUsername = $baseUsername;
                    $counter = 1;
                    while ($db->table('users')->where('username', $newUsername)->countAllResults() > 0) {
                        $newUsername = $baseUsername . $counter;
                        $counter++;
                    }

                    $insertData = [
                        'username'     => $newUsername,
                        'name'         => $displayName ?: $newUsername,
                        'email'        => $email,
                        'role'         => $targetRole,
                        'department'   => $department,
                        'password'     => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT),
                        'microsoft_id' => $msId,
                        'created_at'   => date('Y-m-d H:i:s'),
                        'updated_at'   => date('Y-m-d H:i:s'),
                    ];

                    $db->table('users')->insert($insertData);
                    $newId = $db->insertID();

                    $user = [
                        'id'         => $newId,
                        'username'   => $newUsername,
                        'name'       => $insertData['name'],
                        'email'      => $email,
                        'role'       => $targetRole,
                        'department' => $insertData['department'],
                    ];
                }
            } else {
                // Fallback jika tabel users belum siap: buat sesi berdasarkan hierarki role email
                $user = [
                    'id'         => ($targetRole === 'super_admin') ? 1 : (($targetRole === 'admin') ? 2 : 999),
                    'username'   => explode('@', $email)[0],
                    'name'       => $displayName ?: explode('@', $email)[0],
                    'email'      => $email,
                    'role'       => $targetRole,
                    'department' => $department,
                ];
            }
        } catch (\Throwable $e) {
            return redirect()->to('/login')->with('error', 'Terjadi kesalahan sistem database saat proses SSO: ' . $e->getMessage());
        }

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Gagal memproses data akun pengguna.');
        }

        // Set Sesi Login CodeIgniter
        session()->set([
            'isLoggedIn'   => true,
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'user_name'    => $user['name'] ?? $user['username'],
            'email'        => $user['email'] ?? $email,
            'role'         => $user['role'] ?? 'user',
            'department'   => $user['department'] ?? 'Universitas Pignatelli Triputra',
            'login_method' => 'microsoft',
        ]);

        $targetUrl = session()->get('redirect_after_login') ?: '/dashboard';
        session()->remove('redirect_after_login');

        $this->logAuthEvent($user['id'], $user['email'] ?? $email, 'login_sso', 'microsoft_oauth2', 'success', 'Login SSO Microsoft 365 Civitas Berhasil');

        return redirect()->to($targetUrl)->with('message', 'Selamat datang, ' . ($user['name'] ?? $user['username']) . '! Anda berhasil masuk dengan akun Microsoft 365.');
    }

    /**
     * Helper cURL untuk HTTP POST form-urlencoded.
     */
    private function httpPostForm(string $url, array $data): ?array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($response === false || !empty($err)) {
            return null;
        }

        $decoded = json_decode($response, true);
        return is_array($decoded) ? $decoded : null;
    }

    /**
     * Helper cURL untuk HTTP GET dengan Bearer Token.
     */
    private function httpGetWithBearer(string $url, string $bearerToken): ?array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $bearerToken,
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($response === false || !empty($err)) {
            return null;
        }

        $decoded = json_decode($response, true);
        return is_array($decoded) ? $decoded : null;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('message', 'Anda telah berhasil keluar (logout).');
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk mengakses dashboard.');
        }

        $role          = session()->get('role') ?? 'user';
        $userName      = session()->get('user_name') ?? 'Pengguna';
        $userId        = session()->get('user_id');
        $userLoginName = session()->get('username') ?? '';
        $userEmail     = session()->get('email') ?? '';
        $userDept      = session()->get('department') ?? 'Universitas Pignatelli Triputra';

        $myProfile = [
            'id'              => $userId,
            'username'        => $userLoginName,
            'name'            => $userName,
            'email'           => $userEmail,
            'department'      => $userDept,
            'phone'           => '',
            'identity_number' => '',
            'role'            => $role,
            'is_suspended'    => 0,
        ];

        $stats = [
            'lost_found'       => 0,
            'visitors'         => 0,
            'room_bookings'    => 0,
            'vehicle_bookings' => 0,
            'maintenance'      => 0,
            'supplies'         => 0,
            'users_count'      => 0,
        ];

        $pendingRooms       = [];
        $pendingVehicles    = [];
        $pendingMaintenance = [];
        $pendingSupplies    = [];
        $recentVisitors     = [];
        $recentLostFound    = [];
        $allUsers           = [];
        $authLogs           = [];
        $myRequests         = [];

        // Data Khusus untuk Dashboard User (Mahasiswa & Dosen)
        $myRoomBookings          = [];
        $myVehicleBookings       = [];
        $myMaintenance           = [];
        $mySupplyRequests        = [];
        $pendingRoomsCount       = 0;
        $pendingVehiclesCount    = 0;
        $pendingMaintenanceCount = 0;
        $pendingSuppliesCount    = 0;
        $userStats          = [
            'total_all'         => 0,
            'total_rooms'       => 0,
            'total_vehicles'    => 0,
            'total_maintenance' => 0,
            'total_supplies'    => 0,
            'pending_count'     => 0,
            'approved_count'    => 0,
            'rejected_count'    => 0,
        ];
        $userType           = 'Mahasiswa';

        // Data Lengkap untuk CRUD Admin
        $allLostFound       = [];
        $allVisitors        = [];
        $allRoomBookings    = [];
        $allVehicleBookings = [];
        $allMaintenance     = [];
        $allSupplyRequests  = [];
        $suppliesList       = [];
        $roomsList          = [];
        $vehiclesList       = [];

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            // Hitung statistik umum
            if ($db->tableExists('lost_found')) {
                $stats['lost_found'] = $db->table('lost_found')->countAllResults();
            }
            if ($db->tableExists('visitors')) {
                $stats['visitors'] = $db->table('visitors')->countAllResults();
            }
            if ($db->tableExists('room_bookings')) {
                $stats['room_bookings'] = $db->table('room_bookings')->countAllResults();
            }
            if ($db->tableExists('vehicle_bookings')) {
                $stats['vehicle_bookings'] = $db->table('vehicle_bookings')->countAllResults();
            }
            if ($db->tableExists('maintenance_requests')) {
                $stats['maintenance'] = $db->table('maintenance_requests')->countAllResults();
            }
            if ($db->tableExists('supply_requests')) {
                $stats['supplies'] = $db->table('supply_requests')->countAllResults();
            }
            if ($db->tableExists('users')) {
                $stats['users_count'] = $db->table('users')->countAllResults();
            }

            // Profil Pengguna Aktif
            if ($userId && $db->tableExists('users')) {
                $userRec = $db->table('users')->where('id', $userId)->get()->getRowArray();
                if ($userRec) {
                    $myProfile['name']            = $userRec['name'] ?? $myProfile['name'];
                    $myProfile['email']           = $userRec['email'] ?? $myProfile['email'];
                    $myProfile['department']      = $userRec['department'] ?? $myProfile['department'];
                    $myProfile['phone']           = $userRec['phone'] ?? '';
                    $myProfile['identity_number'] = $userRec['identity_number'] ?? '';
                    $myProfile['is_suspended']    = $userRec['is_suspended'] ?? 0;
                }
            }

            // Master Ruangan & Kendaraan
            if ($db->tableExists('rooms')) {
                $roomsList = $db->table('rooms')->orderBy('id', 'ASC')->get()->getResultArray();
            }
            if (empty($roomsList)) {
                $roomsList = [
                    ['id' => 1, 'room_name' => 'Excellent Meeting Room', 'capacity' => 50, 'location' => 'Gedung A Lantai 2', 'status' => 'active'],
                    ['id' => 2, 'room_name' => 'Compassion Meeting Room', 'capacity' => 40, 'location' => 'Gedung A Lantai 2', 'status' => 'active'],
                    ['id' => 3, 'room_name' => 'Integrity Meeting Room', 'capacity' => 40, 'location' => 'Gedung B Lantai 1', 'status' => 'active'],
                    ['id' => 4, 'room_name' => 'Auditorium', 'capacity' => 200, 'location' => 'Gedung Utama Lantai 3', 'status' => 'active'],
                    ['id' => 5, 'room_name' => 'Multi Function Hall', 'capacity' => 150, 'location' => 'Gedung C Lantai Dasar', 'status' => 'active'],
                ];
            }

            if ($db->tableExists('vehicles')) {
                $vehiclesList = $db->table('vehicles')->orderBy('id', 'ASC')->get()->getResultArray();
            }
            if (empty($vehiclesList)) {
                $vehiclesList = [
                    ['id' => 1, 'vehicle_name' => 'Toyota Avanza', 'plate_number' => 'B 1234 ABC', 'capacity' => 7, 'status' => 'available'],
                    ['id' => 2, 'vehicle_name' => 'Toyota Innova Reborn', 'plate_number' => 'B 5678 DEF', 'capacity' => 8, 'status' => 'available'],
                    ['id' => 3, 'vehicle_name' => 'Isuzu Elf Microbus', 'plate_number' => 'B 9101 GHI', 'capacity' => 16, 'status' => 'available'],
                    ['id' => 4, 'vehicle_name' => 'Toyota Hiace Commuter', 'plate_number' => 'AD 8899 UP', 'capacity' => 14, 'status' => 'available'],
                ];
            }

            // Data untuk Super Admin & Admin Sarpras
            if (in_array($role, ['super_admin', 'admin'])) {
                if ($db->tableExists('room_bookings')) {
                    $q = $db->table('room_bookings')
                        ->select('room_bookings.*, rooms.room_name, rooms.capacity');
                    if ($db->tableExists('users') && $db->fieldExists('user_id', 'room_bookings')) {
                        $q->select('users.username as submitter_username, users.name as submitter_user_name')
                          ->join('users', 'users.id = room_bookings.user_id', 'left');
                    }
                    $allRoomBookings = $q->join('rooms', 'rooms.id = room_bookings.room_id', 'left')
                        ->orderBy('room_bookings.id', 'DESC')
                        ->get()->getResultArray();
                    $pendingRooms = array_values(array_filter($allRoomBookings, fn($r) => ($r['status'] ?? '') === 'pending'));
                }

                if ($db->tableExists('vehicle_bookings')) {
                    $q = $db->table('vehicle_bookings')
                        ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number');
                    if ($db->tableExists('users') && $db->fieldExists('user_id', 'vehicle_bookings')) {
                        $q->select('users.username as submitter_username, users.name as submitter_user_name')
                          ->join('users', 'users.id = vehicle_bookings.user_id', 'left');
                    }
                    $allVehicleBookings = $q->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left')
                        ->orderBy('vehicle_bookings.id', 'DESC')
                        ->get()->getResultArray();
                    $pendingVehicles = array_values(array_filter($allVehicleBookings, fn($v) => ($v['status'] ?? '') === 'pending'));
                }

                if ($db->tableExists('maintenance_requests')) {
                    $q = $db->table('maintenance_requests')
                        ->select('maintenance_requests.*');
                    if ($db->tableExists('users') && $db->fieldExists('user_id', 'maintenance_requests')) {
                        $q->select('users.username as submitter_username, users.name as submitter_user_name')
                          ->join('users', 'users.id = maintenance_requests.user_id', 'left');
                    }
                    $allMaintenance = $q->orderBy('maintenance_requests.id', 'DESC')
                        ->get()->getResultArray();
                    $pendingMaintenance = array_values(array_filter($allMaintenance, fn($m) => in_array($m['status'] ?? '', ['pending', 'in_progress'])));
                }

                if ($db->tableExists('supply_requests')) {
                    $q = $db->table('supply_requests')
                        ->select('supply_requests.*, supplies.item_name, supplies.unit, supplies.stock');
                    if ($db->tableExists('users') && $db->fieldExists('user_id', 'supply_requests')) {
                        $q->select('users.username as submitter_username, users.name as submitter_user_name')
                          ->join('users', 'users.id = supply_requests.user_id', 'left');
                    }
                    $allSupplyRequests = $q->join('supplies', 'supplies.id = supply_requests.supply_id', 'left')
                        ->orderBy('supply_requests.id', 'DESC')
                        ->get()->getResultArray();
                    $pendingSupplies = array_values(array_filter($allSupplyRequests, fn($s) => ($s['status'] ?? '') === 'pending'));
                }

                if ($db->tableExists('visitors')) {
                    $allVisitors = $db->table('visitors')
                        ->orderBy('id', 'DESC')
                        ->get()->getResultArray();
                    $recentVisitors = array_slice($allVisitors, 0, 5);
                }

                if ($db->tableExists('lost_found')) {
                    $allLostFound = $db->table('lost_found')
                        ->orderBy('id', 'DESC')
                        ->get()->getResultArray();
                    $recentLostFound = array_slice($allLostFound, 0, 5);
                }

                if ($db->tableExists('supplies')) {
                    $suppliesList = $db->table('supplies')
                        ->orderBy('id', 'DESC')
                        ->get()->getResultArray();
                }

                if ($db->tableExists('users')) {
                    $usersQuery = $db->table('users')
                        ->select('id, username, name, email, role, department, phone, identity_number, is_suspended, suspend_reason, created_at');
                    if ($role === 'admin') {
                        // Admin Sarpras hanya boleh mengelola dan melihat akun level 'user' (Dosen & Mahasiswa)
                        $usersQuery->where('role', 'user');
                    }
                    // Super Admin (Biro IT) dapat melihat semua level: super_admin, admin, user
                    $allUsers = $usersQuery->orderBy('id', 'ASC')->get()->getResultArray();
                }

                if (empty($allUsers)) {
                    $defaultUsers = [
                        ['id' => 1, 'username' => 'kenedy.natanael', 'name' => 'Kenedy Natanael', 'email' => 'kenedy.natanael@upitra.ac.id', 'role' => 'super_admin', 'department' => 'Biro IT', 'phone' => '081200000001', 'identity_number' => 'IT-001', 'is_suspended' => 0, 'suspend_reason' => null],
                        ['id' => 2, 'username' => 'biro.it', 'name' => 'Biro IT UPITRA', 'email' => 'biro-it@upitra.ac.id', 'role' => 'super_admin', 'department' => 'Biro IT', 'phone' => '081200000004', 'identity_number' => 'IT-002', 'is_suspended' => 0, 'suspend_reason' => null],
                        ['id' => 3, 'username' => 'admin', 'name' => 'Biro Sarana dan Prasarana', 'email' => 'sarpras@upitra.ac.id', 'role' => 'admin', 'department' => 'Sarpras', 'phone' => '081200000002', 'identity_number' => 'SP-002', 'is_suspended' => 0, 'suspend_reason' => null],
                        ['id' => 4, 'username' => 'mahasiswa', 'name' => 'Budi Santoso', 'email' => 'budi@student.upitra.ac.id', 'role' => 'user', 'department' => 'Mahasiswa Informatika', 'phone' => '081234567890', 'identity_number' => '2023010045', 'is_suspended' => 0, 'suspend_reason' => null],
                        ['id' => 5, 'username' => 'dosen', 'name' => 'Dr. Siti Rahmawati, M.Kom.', 'email' => 'siti.rahma@upitra.ac.id', 'role' => 'user', 'department' => 'Dosen Fakultas Sains & Teknologi', 'phone' => '081298765432', 'identity_number' => '0412058001', 'is_suspended' => 0, 'suspend_reason' => null],
                    ];
                    if ($role === 'admin') {
                        $allUsers = array_values(array_filter($defaultUsers, fn($u) => $u['role'] === 'user'));
                    } else {
                        $allUsers = $defaultUsers;
                    }
                }
            }

            // Data untuk User (Mahasiswa & Dosen)
            if ($role === 'user') {
                $userId    = session()->get('user_id');
                $userDept  = session()->get('department') ?? '';
                $username  = session()->get('username') ?? '';
                $userEmail = session()->get('email') ?? '';

                $isDosen = (stripos($userDept, 'dosen') !== false || stripos($username, 'dosen') !== false || stripos($userName, 'dr.') !== false);
                $userType = $isDosen ? 'Dosen' : 'Mahasiswa';

                // 1. Peminjaman Ruangan Saya
                if ($db->tableExists('room_bookings')) {
                    $q = $db->table('room_bookings')
                        ->select('room_bookings.*, rooms.room_name, rooms.capacity')
                        ->join('rooms', 'rooms.id = room_bookings.room_id', 'left');
                    if ($db->fieldExists('user_id', 'room_bookings') && $userId) {
                        $q->groupStart()->where('room_bookings.user_id', $userId)->orWhere('room_bookings.booker_name', $userName)->groupEnd();
                    } else {
                        $q->where('room_bookings.booker_name', $userName);
                    }
                    $myRoomBookings = $q->orderBy('room_bookings.id', 'DESC')->get()->getResultArray();
                }

                // 2. Peminjaman Kendaraan Saya
                if ($db->tableExists('vehicle_bookings')) {
                    $q = $db->table('vehicle_bookings')
                        ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number')
                        ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left');
                    if ($db->fieldExists('user_id', 'vehicle_bookings') && $userId) {
                        $q->groupStart()->where('vehicle_bookings.user_id', $userId)->orWhere('vehicle_bookings.booker_name', $userName)->groupEnd();
                    } else {
                        $q->where('vehicle_bookings.booker_name', $userName);
                    }
                    $myVehicleBookings = $q->orderBy('vehicle_bookings.id', 'DESC')->get()->getResultArray();
                }

                // 3. Request Maintenance Saya
                if ($db->tableExists('maintenance_requests')) {
                    $q = $db->table('maintenance_requests');
                    if ($db->fieldExists('user_id', 'maintenance_requests') && $userId) {
                        $q->groupStart()->where('user_id', $userId)->orWhere('requester_name', $userName)->groupEnd();
                    } else {
                        $q->where('requester_name', $userName);
                    }
                    $myMaintenance = $q->orderBy('id', 'DESC')->get()->getResultArray();
                }

                // 4. Request Supplies (ATK) Saya
                if ($db->tableExists('supply_requests')) {
                    $q = $db->table('supply_requests')
                        ->select('supply_requests.*, supplies.item_name, supplies.unit, supplies.stock')
                        ->join('supplies', 'supplies.id = supply_requests.supply_id', 'left');
                    if ($db->fieldExists('user_id', 'supply_requests') && $userId) {
                        $q->groupStart()
                            ->where('supply_requests.user_id', $userId)
                            ->orWhere('supply_requests.requester_name', $userName)
                            ->orWhere('supply_requests.email', $userEmail)
                            ->groupEnd();
                    } else {
                        $q->groupStart()
                            ->where('supply_requests.requester_name', $userName)
                            ->orWhere('supply_requests.email', $userEmail)
                            ->groupEnd();
                    }
                    $mySupplyRequests = $q->orderBy('supply_requests.id', 'DESC')->get()->getResultArray();
                }

                // Hitung Statistik Personal Pengguna
                $userStats['total_rooms']       = count($myRoomBookings);
                $userStats['total_vehicles']    = count($myVehicleBookings);
                $userStats['total_maintenance'] = count($myMaintenance);
                $userStats['total_supplies']    = count($mySupplyRequests);
                $userStats['total_all']         = $userStats['total_rooms'] + $userStats['total_vehicles'] + $userStats['total_maintenance'] + $userStats['total_supplies'];

                $pendingRoomsCount       = count(array_filter($myRoomBookings, fn($r) => ($r['status'] ?? '') === 'pending'));
                $pendingVehiclesCount    = count(array_filter($myVehicleBookings, fn($v) => ($v['status'] ?? '') === 'pending'));
                $pendingMaintenanceCount = count(array_filter($myMaintenance, fn($m) => in_array($m['status'] ?? '', ['pending', 'in_progress'])));
                $pendingSuppliesCount    = count(array_filter($mySupplyRequests, fn($s) => ($s['status'] ?? '') === 'pending'));

                foreach (array_merge($myRoomBookings, $myVehicleBookings, $mySupplyRequests) as $item) {
                    $st = $item['status'] ?? 'pending';
                    if ($st === 'approved' || $st === 'resolved') {
                        $userStats['approved_count']++;
                    } elseif ($st === 'rejected') {
                        $userStats['rejected_count']++;
                    } else {
                        $userStats['pending_count']++;
                    }
                }

                foreach ($myMaintenance as $item) {
                    $st = $item['status'] ?? 'pending';
                    if ($st === 'resolved' || $st === 'approved') {
                        $userStats['approved_count']++;
                    } elseif ($st === 'rejected') {
                        $userStats['rejected_count']++;
                    } else {
                        $userStats['pending_count']++;
                    }
                }

                // Bangun ringkasan riwayat pengajuan terkini
                $allMyCombined = [];
                foreach ($myRoomBookings as $r) {
                    $allMyCombined[] = [
                        'id'             => $r['id'],
                        'type'           => 'Ruangan',
                        'submitter_name' => $r['booker_name'] ?: $userName,
                        'department'     => $r['department'] ?: $userDept,
                        'title'          => $r['event_name'] ?: 'Peminjaman Ruangan',
                        'detail'         => ($r['room_name'] ?? 'Ruangan') . ' (' . ($r['start_time'] ?? '') . ' - ' . ($r['end_time'] ?? '') . ')',
                        'date'           => $r['booking_date'],
                        'created_at'     => $r['created_at'] ?? $r['booking_date'],
                        'status'         => $r['status'],
                        'admin_note'     => $r['admin_note'] ?? null,
                    ];
                }
                foreach ($myVehicleBookings as $v) {
                    $allMyCombined[] = [
                        'id'             => $v['id'],
                        'type'           => 'Kendaraan',
                        'submitter_name' => $v['booker_name'] ?: $userName,
                        'department'     => $v['department'] ?: $userDept,
                        'title'          => 'Tujuan: ' . ($v['destination'] ?: '-'),
                        'detail'         => ($v['vehicle_name'] ?? 'Mobil Dinas') . ' (' . ($v['booking_day'] ?? '') . ')',
                        'date'           => $v['booking_date'],
                        'created_at'     => $v['created_at'] ?? $v['booking_date'],
                        'status'         => $v['status'],
                        'admin_note'     => $v['admin_note'] ?? null,
                    ];
                }
                foreach ($myMaintenance as $m) {
                    $allMyCombined[] = [
                        'id'             => $m['id'],
                        'type'           => 'Maintenance',
                        'submitter_name' => $m['requester_name'] ?: $userName,
                        'department'     => $m['department'] ?: $userDept,
                        'title'          => 'Fasilitas: ' . ($m['facility'] ?? '-'),
                        'detail'         => 'Lokasi: ' . ($m['location'] ?? '-'),
                        'date'       => substr($m['created_at'] ?? date('Y-m-d'), 0, 10),
                        'created_at' => $m['created_at'] ?? date('Y-m-d H:i:s'),
                        'status'     => $m['status'],
                        'admin_note' => $m['admin_note'] ?? null,
                    ];
                }
                foreach ($mySupplyRequests as $s) {
                    $allMyCombined[] = [
                        'id'             => $s['id'],
                        'type'           => 'Supplies (ATK)',
                        'submitter_name' => $s['requester_name'] ?: $userName,
                        'department'     => $s['department'] ?: $userDept,
                        'title'          => ($s['item_name'] ?? 'Barang ATK') . ' (' . ($s['quantity'] ?? 1) . ' ' . ($s['unit'] ?? '') . ')',
                        'detail'     => 'Dibutuhkan: ' . ($s['date_needed'] ?? '-'),
                        'date'       => $s['date_requested'],
                        'created_at' => $s['created_at'] ?? $s['date_requested'],
                        'status'     => $s['status'],
                        'admin_note' => $s['admin_note'] ?? null,
                    ];
                }

                // Urutkan berdasarkan waktu terbaru
                usort($allMyCombined, function($a, $b) {
                    return strtotime($b['created_at'] ?? 'now') - strtotime($a['created_at'] ?? 'now');
                });

                $myRequests = array_slice($allMyCombined, 0, 10);
            }
        } catch (\Throwable $e) {
            // Tetap jalankan dashboard bila ada error koneksi DB
        }

        $totalPendingCount = count($pendingRooms) + count($pendingVehicles) + count($pendingMaintenance) + count($pendingSupplies);

        // Agregasi Statistik Pengajuan Bulanan (Tahun Berjalan) untuk Grafik Admin
        $currentYear = date('Y');
        $monthlyStats = [
            'year'        => $currentYear,
            'labels'      => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'peminjaman'  => array_fill(0, 12, 0), // Gabungan Ruangan + Kendaraan
            'ruangan'     => array_fill(0, 12, 0),
            'kendaraan'   => array_fill(0, 12, 0),
            'supplies'    => array_fill(0, 12, 0), // Request ATK
            'maintenance' => array_fill(0, 12, 0), // Request Maintenance
        ];

        foreach ($allRoomBookings as $rb) {
            $dateStr = $rb['booking_date'] ?? $rb['created_at'] ?? '';
            if ($dateStr) {
                $ts = strtotime($dateStr);
                if ($ts && date('Y', $ts) == $currentYear) {
                    $m = (int)date('n', $ts) - 1;
                    if ($m >= 0 && $m < 12) {
                        $monthlyStats['ruangan'][$m]++;
                        $monthlyStats['peminjaman'][$m]++;
                    }
                }
            }
        }

        foreach ($allVehicleBookings as $vb) {
            $dateStr = $vb['booking_date'] ?? $vb['created_at'] ?? '';
            if ($dateStr) {
                $ts = strtotime($dateStr);
                if ($ts && date('Y', $ts) == $currentYear) {
                    $m = (int)date('n', $ts) - 1;
                    if ($m >= 0 && $m < 12) {
                        $monthlyStats['kendaraan'][$m]++;
                        $monthlyStats['peminjaman'][$m]++;
                    }
                }
            }
        }

        foreach ($allSupplyRequests as $sr) {
            $dateStr = $sr['date_requested'] ?? $sr['created_at'] ?? '';
            if ($dateStr) {
                $ts = strtotime($dateStr);
                if ($ts && date('Y', $ts) == $currentYear) {
                    $m = (int)date('n', $ts) - 1;
                    if ($m >= 0 && $m < 12) {
                        $monthlyStats['supplies'][$m]++;
                    }
                }
            }
        }

        foreach ($allMaintenance as $mr) {
            $dateStr = $mr['created_at'] ?? '';
            if ($dateStr) {
                $ts = strtotime($dateStr);
                if ($ts && date('Y', $ts) == $currentYear) {
                    $m = (int)date('n', $ts) - 1;
                    if ($m >= 0 && $m < 12) {
                        $monthlyStats['maintenance'][$m]++;
                    }
                }
            }
        }

        return view('admin/dashboard', [
            'role'               => $role,
            'stats'              => $stats,
            'pendingRooms'       => $pendingRooms,
            'pendingVehicles'    => $pendingVehicles,
            'pendingMaintenance' => $pendingMaintenance,
            'pendingSupplies'    => $pendingSupplies,
            'totalPendingCount'  => $totalPendingCount,
            'recentVisitors'     => $recentVisitors,
            'recentLostFound'    => $recentLostFound,
            'allUsers'           => $allUsers,
            'suppliesList'       => $suppliesList ?? [],
            'allLostFound'       => $allLostFound,
            'allVisitors'        => $allVisitors,
            'allRoomBookings'    => $allRoomBookings,
            'allVehicleBookings' => $allVehicleBookings,
            'allMaintenance'     => $allMaintenance,
            'allSupplyRequests'  => $allSupplyRequests,
            'roomsList'          => $roomsList,
            'vehiclesList'       => $vehiclesList,
            'myRequests'         => $myRequests,
            'allMyRequests'      => $allMyCombined ?? [],
            'monthlyStats'       => $monthlyStats,
            // Variabel Khusus untuk Dashboard Mahasiswa & Dosen
            'myRoomBookings'          => $myRoomBookings,
            'myVehicleBookings'       => $myVehicleBookings,
            'myMaintenance'           => $myMaintenance,
            'mySupplyRequests'        => $mySupplyRequests,
            'pendingRoomsCount'       => $pendingRoomsCount,
            'pendingVehiclesCount'    => $pendingVehiclesCount,
            'pendingMaintenanceCount' => $pendingMaintenanceCount,
            'pendingSuppliesCount'    => $pendingSuppliesCount,
            'myProfile'               => $myProfile,
            'userStats'               => $userStats,
            'userType'                => $userType,
        ]);
    }

    /**
     * Export Riwayat Peminjaman, Permintaan (Request), dan Pelaporan ke PDF
     * Khusus untuk Dashboard Administrator (Super Admin & Admin Sarpras)
     * Mendukung URL Slug: /dashboard/export-pdf/(:segment) maupun query param ?type=...
     */
    public function exportPdf($slugType = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Fitur ekspor laporan PDF hanya tersedia untuk Administrator.');
        }

        // Tangkap dari URL slug terlebih dahulu, fallback ke query parameter
        $rawType = (string) ($slugType ?: ($this->request->getGet('type') ?: 'peminjaman'));
        // Normalisasi slug: jadikan lowercase, ganti tanda hubung (-) menjadi garis bawah (_)
        $type = str_replace('-', '_', strtolower(trim($rawType)));

        // Pemetaan alias slug ramah pengguna
        $aliasMap = [
            'ruangan'              => 'peminjaman_ruangan',
            'room'                 => 'peminjaman_ruangan',
            'rooms'                => 'peminjaman_ruangan',
            'room_bookings'        => 'peminjaman_ruangan',
            'kendaraan'            => 'peminjaman_kendaraan',
            'mobil'                => 'peminjaman_kendaraan',
            'vehicle'              => 'peminjaman_kendaraan',
            'vehicles'             => 'peminjaman_kendaraan',
            'vehicle_bookings'     => 'peminjaman_kendaraan',
            'maintenance'          => 'request_maintenance',
            'maintenance_requests' => 'request_maintenance',
            'supplies'             => 'request_supplies',
            'atk'                  => 'request_supplies',
            'supply_requests'      => 'request_supplies',
            'lost_found'           => 'pelaporan_lostfound',
            'lostfound'            => 'pelaporan_lostfound',
            'barang_hilang'        => 'pelaporan_lostfound',
            'visitor'              => 'pelaporan_visitor',
            'visitors'             => 'pelaporan_visitor',
            'tamu'                 => 'pelaporan_visitor',
            'buku_tamu'            => 'pelaporan_visitor',
        ];
        if (isset($aliasMap[$type])) {
            $type = $aliasMap[$type];
        }

        $db = \Config\Database::connect();
        $this->ensureUserIdColumns($db);

        $reportTitle    = 'LAPORAN RIWAYAT BIRO SARANA DAN PRASARANA';
        $reportSubtitle = 'Universitas Pignatelli Triputra - Tahun ' . date('Y');
        $reportData     = [];

        switch ($type) {
            case 'peminjaman_ruangan':
            case 'room_bookings':
                $reportTitle = 'LAPORAN RIWAYAT PEMINJAMAN RUANGAN';
                $reportSubtitle = 'Biro Sarana dan Prasarana - Universitas Pignatelli Triputra';
                $q = $db->table('room_bookings')
                    ->select('room_bookings.*, rooms.room_name, rooms.location')
                    ->join('rooms', 'rooms.id = room_bookings.room_id', 'left');
                if ($db->tableExists('users') && $db->fieldExists('user_id', 'room_bookings')) {
                    $q->select('users.name as submitter_name, users.identity_number, users.role as user_role')
                      ->join('users', 'users.id = room_bookings.user_id', 'left');
                }
                $reportData['rooms'] = $q->orderBy('room_bookings.booking_date', 'DESC')->get()->getResultArray();
                break;

            case 'peminjaman_kendaraan':
            case 'vehicle_bookings':
                $reportTitle = 'LAPORAN RIWAYAT PEMINJAMAN KENDARAAN (MOBIL DINAS)';
                $reportSubtitle = 'Biro Sarana dan Prasarana - Universitas Pignatelli Triputra';
                $q = $db->table('vehicle_bookings')
                    ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number')
                    ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left');
                if ($db->tableExists('users') && $db->fieldExists('user_id', 'vehicle_bookings')) {
                    $q->select('users.name as submitter_name, users.identity_number, users.role as user_role')
                      ->join('users', 'users.id = vehicle_bookings.user_id', 'left');
                }
                $reportData['vehicles'] = $q->orderBy('vehicle_bookings.booking_date', 'DESC')->get()->getResultArray();
                break;

            case 'peminjaman':
            default_peminjaman:
                $reportTitle = 'LAPORAN RIWAYAT LENGKAP PEMINJAMAN FASILITAS';
                $reportSubtitle = 'Peminjaman Ruangan & Kendaraan Operasional - Universitas Pignatelli Triputra';
                $q1 = $db->table('room_bookings')
                    ->select('room_bookings.*, rooms.room_name, rooms.location')
                    ->join('rooms', 'rooms.id = room_bookings.room_id', 'left');
                if ($db->tableExists('users') && $db->fieldExists('user_id', 'room_bookings')) {
                    $q1->select('users.name as submitter_name, users.identity_number, users.role as user_role')
                       ->join('users', 'users.id = room_bookings.user_id', 'left');
                }
                $reportData['rooms'] = $q1->orderBy('room_bookings.booking_date', 'DESC')->get()->getResultArray();

                $q2 = $db->table('vehicle_bookings')
                    ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number')
                    ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left');
                if ($db->tableExists('users') && $db->fieldExists('user_id', 'vehicle_bookings')) {
                    $q2->select('users.name as submitter_name, users.identity_number, users.role as user_role')
                       ->join('users', 'users.id = vehicle_bookings.user_id', 'left');
                }
                $reportData['vehicles'] = $q2->orderBy('vehicle_bookings.booking_date', 'DESC')->get()->getResultArray();
                break;

            case 'request_maintenance':
            case 'maintenance':
                $reportTitle = 'LAPORAN RIWAYAT REQUEST MAINTENANCE (PERBAIKAN FASILITAS)';
                $reportSubtitle = 'Biro Sarana dan Prasarana - Universitas Pignatelli Triputra';
                $q = $db->table('maintenance_requests')
                    ->select('maintenance_requests.*');
                if ($db->tableExists('users') && $db->fieldExists('user_id', 'maintenance_requests')) {
                    $q->select('users.name as submitter_name, users.identity_number, users.role as user_role')
                      ->join('users', 'users.id = maintenance_requests.user_id', 'left');
                }
                $reportData['maintenance'] = $q->orderBy('maintenance_requests.id', 'DESC')->get()->getResultArray();
                break;

            case 'request_supplies':
            case 'supplies':
                $reportTitle = 'LAPORAN RIWAYAT PERMOHONAN SUPPLIES (ATK)';
                $reportSubtitle = 'Biro Sarana dan Prasarana - Universitas Pignatelli Triputra';
                $q = $db->table('supply_requests')
                    ->select('supply_requests.*, supplies.item_name, supplies.unit, supplies.stock')
                    ->join('supplies', 'supplies.id = supply_requests.supply_id', 'left');
                if ($db->tableExists('users') && $db->fieldExists('user_id', 'supply_requests')) {
                    $q->select('users.name as submitter_name, users.identity_number, users.role as user_role')
                      ->join('users', 'users.id = supply_requests.user_id', 'left');
                }
                $reportData['supplies'] = $q->orderBy('supply_requests.id', 'DESC')->get()->getResultArray();
                break;

            case 'request':
                $reportTitle = 'LAPORAN RIWAYAT PERMINTAAN (REQUEST MAINTENANCE & ATK)';
                $reportSubtitle = 'Biro Sarana dan Prasarana - Universitas Pignatelli Triputra';
                $q1 = $db->table('maintenance_requests')
                    ->select('maintenance_requests.*');
                if ($db->tableExists('users') && $db->fieldExists('user_id', 'maintenance_requests')) {
                    $q1->select('users.name as submitter_name, users.identity_number, users.role as user_role')
                       ->join('users', 'users.id = maintenance_requests.user_id', 'left');
                }
                $reportData['maintenance'] = $q1->orderBy('maintenance_requests.id', 'DESC')->get()->getResultArray();

                $q2 = $db->table('supply_requests')
                    ->select('supply_requests.*, supplies.item_name, supplies.unit, supplies.stock')
                    ->join('supplies', 'supplies.id = supply_requests.supply_id', 'left');
                if ($db->tableExists('users') && $db->fieldExists('user_id', 'supply_requests')) {
                    $q2->select('users.name as submitter_name, users.identity_number, users.role as user_role')
                       ->join('users', 'users.id = supply_requests.user_id', 'left');
                }
                $reportData['supplies'] = $q2->orderBy('supply_requests.id', 'DESC')->get()->getResultArray();
                break;

            case 'pelaporan_lostfound':
            case 'lost_found':
                $reportTitle = 'LAPORAN RIWAYAT BARANG HILANG & DITEMUKAN (LOST & FOUND)';
                $reportSubtitle = 'Biro Sarana dan Prasarana - Universitas Pignatelli Triputra';
                $reportData['lost_found'] = $db->table('lost_found')->orderBy('id', 'DESC')->get()->getResultArray();
                break;

            case 'pelaporan_visitor':
            case 'visitors':
                $reportTitle = 'LAPORAN RIWAYAT BUKU TAMU KAMPUS (VISITOR LOG)';
                $reportSubtitle = 'Biro Sarana dan Prasarana - Universitas Pignatelli Triputra';
                $reportData['visitors'] = $db->table('visitors')->orderBy('id', 'DESC')->get()->getResultArray();
                break;

            case 'pelaporan':
                $reportTitle = 'LAPORAN RIWAYAT PELAPORAN (LOST & FOUND & BUKU TAMU)';
                $reportSubtitle = 'Biro Sarana dan Prasarana - Universitas Pignatelli Triputra';
                $reportData['lost_found'] = $db->table('lost_found')->orderBy('id', 'DESC')->get()->getResultArray();
                $reportData['visitors']   = $db->table('visitors')->orderBy('id', 'DESC')->get()->getResultArray();
                break;
        }

        $indonesianMonths = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $printDate = date('d') . ' ' . ($indonesianMonths[(int)date('n')] ?? date('F')) . ' ' . date('Y') . ', ' . date('H:i') . ' WIB';

        return view('admin/export_pdf', [
            'type'           => $type,
            'reportTitle'    => $reportTitle,
            'reportSubtitle' => $reportSubtitle,
            'reportData'     => $reportData,
            'printedBy'      => session()->get('user_name') ?? 'Administrator',
            'printedRole'    => ($role === 'super_admin') ? 'Super Admin (Biro IT)' : 'Admin (Sarpras)',
            'printDate'      => $printDate,
        ]);
    }

    public function updateStatus()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki hak akses untuk mengubah status permohonan.');
        }

        $table       = (string) $this->request->getPost('table');
        $id          = (int) $this->request->getPost('id');
        $status      = (string) $this->request->getPost('status');
        $adminNote   = trim((string) $this->request->getPost('admin_note'));
        $redirectTab = (string) $this->request->getPost('redirect_tab');

        $allowedTables = ['room_bookings', 'vehicle_bookings', 'maintenance_requests', 'supply_requests', 'lost_found', 'visitors'];

        if (!in_array($table, $allowedTables) || empty($id) || empty($status)) {
            return redirect()->to('/dashboard#verifikasi')->with('error', 'Parameter perubahan status tidak valid.');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $updateData = [
                'status'     => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($db->fieldExists('admin_note', $table)) {
                if ($status === 'approved' || $status === 'resolved') {
                    // Sesuai arahan: Didalam status approve tidak perlu ada keterangan cukup statusnya saja
                    $updateData['admin_note'] = null;
                } else {
                    if ($this->request->getPost('admin_note') !== null) {
                        $updateData['admin_note'] = $adminNote;
                    }
                }
            }

            // Logika pengelolaan stok ATK (supplies):
            // - Jika disetujui (approved) dari status non-approved: kurangi stok
            // - Jika diubah dari approved ke pending/rejected: pulihkan stok
            if ($table === 'supply_requests' && $db->tableExists('supplies')) {
                $sr = $db->table('supply_requests')->where('id', $id)->get()->getRowArray();
                if ($sr) {
                    $oldStatus = $sr['status'] ?? 'pending';
                    $supplyId  = (int) ($sr['supply_id'] ?? 0);
                    $qty       = (int) ($sr['quantity'] ?? 0);

                    if ($supplyId > 0 && $qty > 0) {
                        $supply = $db->table('supplies')->where('id', $supplyId)->get()->getRowArray();
                        if ($supply) {
                            $currentStock = (int) ($supply['stock'] ?? 0);
                            if ($status === 'approved' && $oldStatus !== 'approved') {
                                // Potong stok
                                $newStock = max(0, $currentStock - $qty);
                                $db->table('supplies')->where('id', $supplyId)->update([
                                    'stock'      => $newStock,
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            } elseif ($status !== 'approved' && $oldStatus === 'approved') {
                                // Kembalikan stok yang sebelumnya terpotong
                                $newStock = $currentStock + $qty;
                                $db->table('supplies')->where('id', $supplyId)->update([
                                    'stock'      => $newStock,
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }
                        }
                    }
                }
            }

            $db->table($table)->where('id', $id)->update($updateData);

            $tabAnchor = $redirectTab ? '#' . ltrim($redirectTab, '#') : '#verifikasi';
            $statusLabel = ($status === 'approved' || $status === 'resolved') ? 'DISETUJUI (APPROVED)' : (($status === 'rejected') ? 'DITOLAK (DECLINED)' : strtoupper($status));
            return redirect()->to('/dashboard' . $tabAnchor)->with('message', 'Status permohonan berhasil diperbarui menjadi "' . $statusLabel . '". Pemohon akan langsung melihat pembaruan status dan catatan admin di dashboard mereka.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#verifikasi')->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    // --- CRUD SUPPLIES (Nama Barang, Jumlah, Satuan, Stock, Batas) ---
    public function createSupply()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $itemName  = trim((string) $this->request->getPost('item_name'));
        $quantity  = (int) $this->request->getPost('quantity');
        $unit      = trim((string) $this->request->getPost('unit'));
        $stock     = (int) $this->request->getPost('stock');
        $minStock  = (int) $this->request->getPost('min_stock');

        if (empty($itemName) || empty($unit)) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Nama Barang dan Satuan wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('supplies')->insert([
                'item_name'  => $itemName,
                'quantity'   => $quantity,
                'unit'       => $unit,
                'stock'      => $stock,
                'min_stock'  => $minStock,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/dashboard#supplies')->with('message', 'Data barang "' . $itemName . '" berhasil ditambahkan ke daftar Supplies.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Gagal menyimpan barang: ' . $e->getMessage());
        }
    }

    public function updateSupply()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $id        = (int) $this->request->getPost('id');
        $itemName  = trim((string) $this->request->getPost('item_name'));
        $quantity  = (int) $this->request->getPost('quantity');
        $unit      = trim((string) $this->request->getPost('unit'));
        $stock     = (int) $this->request->getPost('stock');
        $minStock  = (int) $this->request->getPost('min_stock');

        if (empty($id) || empty($itemName) || empty($unit)) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Data tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('supplies')->where('id', $id)->update([
                'item_name'  => $itemName,
                'quantity'   => $quantity,
                'unit'       => $unit,
                'stock'      => $stock,
                'min_stock'  => $minStock,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/dashboard#supplies')->with('message', 'Data barang persediaan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Gagal update barang: ' . $e->getMessage());
        }
    }

    public function deleteSupply()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $id = (int) $this->request->getPost('id');
        if (empty($id)) {
            return redirect()->to('/dashboard#supplies')->with('error', 'ID barang tidak valid.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('supplies')->where('id', $id)->delete();
            return redirect()->to('/dashboard#supplies')->with('message', 'Barang berhasil dihapus dari daftar persediaan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }

    // --- CRUD USERS (SETTING MANAJEMEN USERS) ---
    public function createUser()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $username   = trim((string) $this->request->getPost('username'));
        $name       = trim((string) $this->request->getPost('name'));
        $email          = trim((string) $this->request->getPost('email'));
        $userRole       = (string) $this->request->getPost('role');
        $department     = trim((string) $this->request->getPost('department'));
        $phone          = trim((string) $this->request->getPost('phone'));
        $identityNumber = trim((string) $this->request->getPost('identity_number'));
        $password       = (string) $this->request->getPost('password');

        if (empty($username) || empty($name)) {
            return redirect()->to('/dashboard#users')->with('error', 'Username dan Nama Lengkap wajib diisi.');
        }

        // Penentuan role berdasarkan level hak akses pembuat:
        // Super Admin dapat membuat akun super_admin, admin, atau user
        // Admin (Sarpras) HANYA diizinkan membuat akun berlevel 'user' (Dosen & Mahasiswa)
        $finalRole = 'user';
        if ($role === 'super_admin') {
            $finalRole = in_array($userRole, ['super_admin', 'admin', 'user']) ? $userRole : 'user';
        } else {
            $finalRole = 'user';
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            
            // Cek username kembar
            $exist = $db->table('users')->where('username', $username)->countAllResults();
            if ($exist > 0) {
                return redirect()->to('/dashboard#users')->with('error', 'Username "' . $username . '" sudah digunakan.');
            }

            $insertData = [
                'username'        => $username,
                'name'            => $name,
                'email'           => $email,
                'role'            => $finalRole,
                'department'      => $department ?: 'Universitas Pignatelli Triputra',
                'password'        => !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT),
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ];
            if ($db->fieldExists('phone', 'users')) {
                $insertData['phone'] = $phone;
            }
            if ($db->fieldExists('identity_number', 'users')) {
                $insertData['identity_number'] = $identityNumber;
            }

            $db->table('users')->insert($insertData);

            return redirect()->to('/dashboard#users')->with('message', 'Pengguna baru "' . $name . '" berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#users')->with('error', 'Gagal menambah user: ' . $e->getMessage());
        }
    }

    public function updateUser()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $id             = (int) $this->request->getPost('id');
        $username       = trim((string) $this->request->getPost('username'));
        $name           = trim((string) $this->request->getPost('name'));
        $email          = trim((string) $this->request->getPost('email'));
        $userRole       = (string) $this->request->getPost('role');
        $department     = trim((string) $this->request->getPost('department'));
        $phone          = trim((string) $this->request->getPost('phone'));
        $identityNumber = trim((string) $this->request->getPost('identity_number'));
        $password       = (string) $this->request->getPost('password');

        if (empty($id) || empty($username) || empty($name)) {
            return redirect()->to('/dashboard#users')->with('error', 'Data pengguna tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            // Cek pengguna target yang akan diubah
            $targetUser = $db->table('users')->where('id', $id)->get()->getRowArray();
            if (!$targetUser) {
                return redirect()->to('/dashboard#users')->with('error', 'Data pengguna tidak ditemukan.');
            }

            // Validasi batasan hak akses:
            // Admin (Sarpras) HANYA boleh mengelola level 'user' (Dosen & Mahasiswa)
            // Seluruh akun Admin dan Super Admin hanya boleh diedit oleh Super Admin (Biro IT)
            if ($role === 'admin') {
                if ($targetUser['role'] !== 'user') {
                    return redirect()->to('/dashboard#users')->with('error', 'Akses ditolak: Admin hanya berhak mengelola akun Dosen dan Mahasiswa. Akun Admin & Super Admin dikelola oleh Super Admin (Biro IT).');
                }
                // Pastikan role tetap 'user' (mencegah eskalasi hak akses)
                $finalRole = 'user';
            } else {
                // Super Admin bebas mengubah role
                $finalRole = in_array($userRole, ['super_admin', 'admin', 'user']) ? $userRole : $targetUser['role'];
            }

            $data = [
                'username'   => $username,
                'name'       => $name,
                'email'      => $email,
                'role'       => $finalRole,
                'department' => $department,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($this->request->getPost('phone') !== null && $db->fieldExists('phone', 'users')) {
                $data['phone'] = $phone;
            }
            if ($this->request->getPost('identity_number') !== null && $db->fieldExists('identity_number', 'users')) {
                $data['identity_number'] = $identityNumber;
            }

            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $db->table('users')->where('id', $id)->update($data);

            return redirect()->to('/dashboard#users')->with('message', 'Data pengguna "' . $name . '" berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#users')->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function deleteUser()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $id = (int) $this->request->getPost('id');
        if (empty($id)) {
            return redirect()->to('/dashboard#users')->with('error', 'ID user tidak valid.');
        }

        if ($id === (int) session()->get('user_id')) {
            return redirect()->to('/dashboard#users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        try {
            $db = \Config\Database::connect();

            // Cek target akun yang hendak dihapus
            $targetUser = $db->table('users')->where('id', $id)->get()->getRowArray();
            if (!$targetUser) {
                return redirect()->to('/dashboard#users')->with('error', 'Akun pengguna tidak ditemukan.');
            }

            // Validasi batasan hak akses:
            // Admin (Sarpras) HANYA berhak menghapus level 'user' (Dosen & Mahasiswa)
            // Akun admin dan super_admin hanya dapat dihapus oleh Super Admin
            if ($role === 'admin') {
                if ($targetUser['role'] !== 'user') {
                    return redirect()->to('/dashboard#users')->with('error', 'Akses ditolak: Admin hanya berhak menghapus akun Dosen atau Mahasiswa.');
                }
            }

            $db->table('users')->where('id', $id)->delete();
            return redirect()->to('/dashboard#users')->with('message', 'Akun pengguna "' . esc($targetUser['name']) . '" berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#users')->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
    }

    public function suspendUser()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $id     = (int) $this->request->getPost('id');
        $reason = trim((string) $this->request->getPost('suspend_reason')) ?: 'Terindikasi melakukan penginputan asal-asalan (spam)';

        if (empty($id)) {
            return redirect()->to('/dashboard#users')->with('error', 'ID pengguna tidak valid.');
        }

        if ($id === (int) session()->get('user_id')) {
            return redirect()->to('/dashboard#users')->with('error', 'Anda tidak dapat menangguhkan akun Anda sendiri.');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $targetUser = $db->table('users')->where('id', $id)->get()->getRowArray();
            if (!$targetUser) {
                return redirect()->to('/dashboard#users')->with('error', 'Pengguna tidak ditemukan.');
            }

            // Batasan: Admin Sarpras hanya boleh men-suspend level user (mahasiswa/dosen)
            if ($role === 'admin' && $targetUser['role'] !== 'user') {
                return redirect()->to('/dashboard#users')->with('error', 'Akses ditolak: Admin hanya berwenang menangguhkan akun Mahasiswa atau Dosen.');
            }

            $db->table('users')->where('id', $id)->update([
                'is_suspended'   => 1,
                'suspend_reason' => $reason,
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/dashboard#users')->with('message', 'Akun "' . esc($targetUser['name']) . '" berhasil DITANGGUHKAN (SUSPEND). Alasan: ' . esc($reason));
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#users')->with('error', 'Gagal menangguhkan akun: ' . $e->getMessage());
        }
    }

    public function unsuspendUser()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';

        // ATURAN KRUSIAL: Suspend hanya bisa dibuka oleh Super Admin!
        if ($role !== 'super_admin') {
            return redirect()->to('/dashboard#users')->with('error', 'Akses Ditolak: Hanya Super Admin (Biro IT) yang memiliki wewenang untuk membuka status suspend pengguna.');
        }

        $id = (int) $this->request->getPost('id');
        if (empty($id)) {
            return redirect()->to('/dashboard#users')->with('error', 'ID pengguna tidak valid.');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $targetUser = $db->table('users')->where('id', $id)->get()->getRowArray();
            if (!$targetUser) {
                return redirect()->to('/dashboard#users')->with('error', 'Pengguna tidak ditemukan.');
            }

            $db->table('users')->where('id', $id)->update([
                'is_suspended'   => 0,
                'suspend_reason' => null,
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/dashboard#users')->with('message', 'Status suspend untuk akun "' . esc($targetUser['name']) . '" telah berhasil DIBUKA oleh Super Admin.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#users')->with('error', 'Gagal membuka status suspend: ' . $e->getMessage());
        }
    }

    // --- CRUD MASTER DATA: RUANGAN ---
    public function createRoom()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $roomName = trim((string) $this->request->getPost('room_name'));
        $capacity = (int) $this->request->getPost('capacity');
        $location = trim((string) $this->request->getPost('location')) ?: 'Gedung Utama';
        $status   = (string) $this->request->getPost('status') ?: 'active';

        if (empty($roomName) || $capacity <= 0) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Nama ruangan dan kapasitas (minimal 1 orang) wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $db->table('rooms')->insert([
                'room_name' => $roomName,
                'capacity'  => $capacity,
                'location'  => $location,
                'status'    => in_array($status, ['active', 'maintenance']) ? $status : 'active',
            ]);

            return redirect()->to('/dashboard#master-sarpras')->with('message', 'Master ruangan baru "' . esc($roomName) . '" berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Gagal menambah ruangan: ' . $e->getMessage());
        }
    }

    public function updateRoom()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id       = (int) $this->request->getPost('id');
        $roomName = trim((string) $this->request->getPost('room_name'));
        $capacity = (int) $this->request->getPost('capacity');
        $location = trim((string) $this->request->getPost('location')) ?: 'Gedung Utama';
        $status   = (string) $this->request->getPost('status') ?: 'active';

        if (empty($id) || empty($roomName) || $capacity <= 0) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Data ruangan tidak lengkap atau kapasitas tidak valid.');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $db->table('rooms')->where('id', $id)->update([
                'room_name' => $roomName,
                'capacity'  => $capacity,
                'location'  => $location,
                'status'    => in_array($status, ['active', 'maintenance']) ? $status : 'active',
            ]);

            return redirect()->to('/dashboard#master-sarpras')->with('message', 'Data ruangan "' . esc($roomName) . '" berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Gagal memperbarui ruangan: ' . $e->getMessage());
        }
    }

    public function deleteRoom()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        if (empty($id)) return redirect()->to('/dashboard#master-sarpras')->with('error', 'ID ruangan tidak valid.');

        try {
            $db = \Config\Database::connect();
            $target = $db->table('rooms')->where('id', $id)->get()->getRowArray();
            if ($target) {
                $db->table('rooms')->where('id', $id)->delete();
                return redirect()->to('/dashboard#master-sarpras')->with('message', 'Ruangan "' . esc($target['room_name']) . '" berhasil dihapus.');
            }
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Ruangan tidak ditemukan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Gagal menghapus ruangan: ' . $e->getMessage());
        }
    }

    // --- CRUD MASTER DATA: KENDARAAN (MOBIL) ---
    public function createVehicle()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $vehicleName = trim((string) $this->request->getPost('vehicle_name'));
        $plateNumber = strtoupper(trim((string) $this->request->getPost('plate_number')));
        $capacity    = (int) $this->request->getPost('capacity') ?: 7;
        $status      = (string) $this->request->getPost('status') ?: 'available';

        if (empty($vehicleName) || empty($plateNumber)) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Nama kendaraan dan plat nomor polisi wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $db->table('vehicles')->insert([
                'vehicle_name' => $vehicleName,
                'plate_number' => $plateNumber,
                'capacity'     => $capacity,
                'status'       => in_array($status, ['available', 'maintenance']) ? $status : 'available',
            ]);

            return redirect()->to('/dashboard#master-sarpras')->with('message', 'Master mobil baru "' . esc($vehicleName) . ' (' . esc($plateNumber) . ')" berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Gagal menambah kendaraan: ' . $e->getMessage());
        }
    }

    public function updateVehicle()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id          = (int) $this->request->getPost('id');
        $vehicleName = trim((string) $this->request->getPost('vehicle_name'));
        $plateNumber = strtoupper(trim((string) $this->request->getPost('plate_number')));
        $capacity    = (int) $this->request->getPost('capacity') ?: 7;
        $status      = (string) $this->request->getPost('status') ?: 'available';

        if (empty($id) || empty($vehicleName) || empty($plateNumber)) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Data kendaraan tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $db->table('vehicles')->where('id', $id)->update([
                'vehicle_name' => $vehicleName,
                'plate_number' => $plateNumber,
                'capacity'     => $capacity,
                'status'       => in_array($status, ['available', 'maintenance']) ? $status : 'available',
            ]);

            return redirect()->to('/dashboard#master-sarpras')->with('message', 'Data kendaraan "' . esc($vehicleName) . '" berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Gagal memperbarui kendaraan: ' . $e->getMessage());
        }
    }

    public function deleteVehicle()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        if (empty($id)) return redirect()->to('/dashboard#master-sarpras')->with('error', 'ID kendaraan tidak valid.');

        try {
            $db = \Config\Database::connect();
            $target = $db->table('vehicles')->where('id', $id)->get()->getRowArray();
            if ($target) {
                $db->table('vehicles')->where('id', $id)->delete();
                return redirect()->to('/dashboard#master-sarpras')->with('message', 'Kendaraan "' . esc($target['vehicle_name']) . '" berhasil dihapus.');
            }
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Kendaraan tidak ditemukan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#master-sarpras')->with('error', 'Gagal menghapus kendaraan: ' . $e->getMessage());
        }
    }

    // --- FORM BIODATA PROFIL MANDIRI ---
    public function updateProfile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = (int) session()->get('user_id');
        $name   = trim((string) $this->request->getPost('name'));
        $email  = trim((string) $this->request->getPost('email'));
        $phone  = trim((string) $this->request->getPost('phone'));
        $dept   = trim((string) $this->request->getPost('department'));
        $idNum  = trim((string) $this->request->getPost('identity_number'));
        $pw     = (string) $this->request->getPost('password');
        $pwConf = (string) $this->request->getPost('password_confirm');

        if (empty($name)) {
            return redirect()->to('/dashboard#biodata')->with('error', 'Nama lengkap tidak boleh kosong.');
        }

        if (!empty($pw)) {
            if ($pw !== $pwConf) {
                return redirect()->to('/dashboard#biodata')->with('error', 'Konfirmasi password baru tidak sesuai.');
            }
            if (strlen($pw) < 6) {
                return redirect()->to('/dashboard#biodata')->with('error', 'Password baru minimal terdiri dari 6 karakter.');
            }
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $updateData = [
                'name'            => $name,
                'email'           => $email,
                'phone'           => $phone,
                'department'      => $dept,
                'identity_number' => $idNum,
                'updated_at'      => date('Y-m-d H:i:s'),
            ];

            if (!empty($pw)) {
                $updateData['password'] = password_hash($pw, PASSWORD_DEFAULT);
            }

            if ($db->tableExists('users')) {
                $db->table('users')->where('id', $userId)->update($updateData);
            }

            // Segarkan data sesi aktif
            session()->set([
                'user_name'  => $name,
                'email'      => $email,
                'department' => $dept,
            ]);

            return redirect()->to('/dashboard#biodata')->with('message', 'Biodata profil Anda berhasil disimpan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#biodata')->with('error', 'Gagal menyimpan biodata: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD PELAPORAN: LOST & FOUND
    // =========================================================================
    public function createLostFound()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $reporterName   = trim((string) $this->request->getPost('reporter_name'));
        $reporterStatus = trim((string) $this->request->getPost('reporter_status'));
        $lostItem       = trim((string) $this->request->getPost('lost_item'));
        $contact        = trim((string) $this->request->getPost('contact'));
        $incidentDate   = (string) $this->request->getPost('incident_date');
        $incidentTime   = (string) $this->request->getPost('incident_time');
        $status         = (string) ($this->request->getPost('status') ?: 'reported');

        $redirectTab    = $this->request->getPost('redirect_tab') ?: 'sub-lostfound';

        if (empty($reporterName) || empty($lostItem)) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Nama Pelapor dan Barang yang Hilang wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('lost_found')->insert([
                'reporter_name'   => $reporterName,
                'reporter_status' => $reporterStatus ?: 'Mahasiswa / Karyawan',
                'lost_item'       => $lostItem,
                'contact'         => $contact,
                'incident_date'   => $incidentDate ?: date('Y-m-d'),
                'incident_time'   => $incidentTime ?: date('H:i:s'),
                'status'          => in_array($status, ['reported', 'found', 'claimed']) ? $status : 'reported',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Laporan Lost & Found berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal menambahkan laporan: ' . $e->getMessage());
        }
    }

    public function updateLostFound()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id             = (int) $this->request->getPost('id');
        $reporterName   = trim((string) $this->request->getPost('reporter_name'));
        $reporterStatus = trim((string) $this->request->getPost('reporter_status'));
        $lostItem       = trim((string) $this->request->getPost('lost_item'));
        $contact        = trim((string) $this->request->getPost('contact'));
        $incidentDate   = (string) $this->request->getPost('incident_date');
        $incidentTime   = (string) $this->request->getPost('incident_time');
        $status         = (string) $this->request->getPost('status');
        $redirectTab    = $this->request->getPost('redirect_tab') ?: 'sub-lostfound';

        if (empty($id) || empty($reporterName) || empty($lostItem)) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Data laporan tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('lost_found')->where('id', $id)->update([
                'reporter_name'   => $reporterName,
                'reporter_status' => $reporterStatus,
                'lost_item'       => $lostItem,
                'contact'         => $contact,
                'incident_date'   => $incidentDate,
                'incident_time'   => $incidentTime,
                'status'          => in_array($status, ['reported', 'found', 'claimed']) ? $status : 'reported',
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Laporan Lost & Found berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
        }
    }

    public function deleteLostFound()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        $redirectTab = $this->request->getPost('redirect_tab') ?: 'sub-lostfound';
        try {
            $db = \Config\Database::connect();
            $db->table('lost_found')->where('id', $id)->delete();
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Data Lost & Found berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD PELAPORAN: VISITOR (BUKU TAMU)
    // =========================================================================
    public function createVisitor()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $visitorName = trim((string) $this->request->getPost('visitor_name'));
        $institution = trim((string) $this->request->getPost('institution'));
        $contact     = trim((string) $this->request->getPost('contact'));
        $purpose     = trim((string) $this->request->getPost('purpose'));
        $hostName    = trim((string) $this->request->getPost('host_name'));
        $checkIn     = (string) ($this->request->getPost('check_in') ?: date('Y-m-d H:i:s'));
        $checkOut    = $this->request->getPost('check_out') ?: null;
        $status      = (string) ($this->request->getPost('status') ?: 'checked_in');
        $redirectTab = $this->request->getPost('redirect_tab') ?: 'sub-visitor';

        if (empty($visitorName) || empty($institution)) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Nama Pengunjung dan Institusi/Instansi wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('visitors')->insert([
                'visitor_name' => $visitorName,
                'institution'  => $institution,
                'contact'      => $contact,
                'purpose'      => $purpose,
                'host_name'    => $hostName,
                'check_in'     => $checkIn,
                'check_out'    => $checkOut,
                'status'       => in_array($status, ['checked_in', 'checked_out']) ? $status : 'checked_in',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Data kunjungan tamu berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal menambahkan tamu: ' . $e->getMessage());
        }
    }

    public function updateVisitor()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id          = (int) $this->request->getPost('id');
        $visitorName = trim((string) $this->request->getPost('visitor_name'));
        $institution = trim((string) $this->request->getPost('institution'));
        $contact     = trim((string) $this->request->getPost('contact'));
        $purpose     = trim((string) $this->request->getPost('purpose'));
        $hostName    = trim((string) $this->request->getPost('host_name'));
        $checkIn     = (string) $this->request->getPost('check_in');
        $checkOut    = $this->request->getPost('check_out') ?: null;
        $status      = (string) $this->request->getPost('status');
        $redirectTab = $this->request->getPost('redirect_tab') ?: 'sub-visitor';

        if (empty($id) || empty($visitorName)) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Data tamu tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('visitors')->where('id', $id)->update([
                'visitor_name' => $visitorName,
                'institution'  => $institution,
                'contact'      => $contact,
                'purpose'      => $purpose,
                'host_name'    => $hostName,
                'check_in'     => $checkIn,
                'check_out'    => $checkOut,
                'status'       => in_array($status, ['checked_in', 'checked_out']) ? $status : 'checked_in',
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Data tamu berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal memperbarui tamu: ' . $e->getMessage());
        }
    }

    public function deleteVisitor()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        $redirectTab = $this->request->getPost('redirect_tab') ?: 'sub-visitor';
        try {
            $db = \Config\Database::connect();
            $db->table('visitors')->where('id', $id)->delete();
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Data tamu berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal menghapus tamu: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD PEMINJAMAN: RUANGAN
    // =========================================================================
    public function createRoomBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $roomId         = (int) $this->request->getPost('room_id');
        $bookingDate    = trim((string) $this->request->getPost('booking_date'));
        $startTime      = trim((string) $this->request->getPost('start_time'));
        $endTime        = trim((string) $this->request->getPost('end_time'));
        $bookerName     = trim((string) $this->request->getPost('booker_name'));
        $department     = trim((string) $this->request->getPost('department'));
        $eventName      = trim((string) $this->request->getPost('event_name'));
        $setup          = trim((string) $this->request->getPost('setup'));
        $materialNeeded = trim((string) $this->request->getPost('material_needed'));
        $specialRequest = trim((string) $this->request->getPost('special_request'));
        $status         = (string) ($this->request->getPost('status') ?: 'pending');

        if (empty($roomId) || empty($bookingDate) || empty($startTime) || empty($endTime) || empty($bookerName) || empty($eventName)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Ruangan, Tanggal, Jam Masuk, Jam Keluar, Nama Peminjam, dan Nama Event wajib diisi.');
        }

        if (strtotime($startTime) >= strtotime($endTime)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Validasi Waktu Gagal: Jam keluar (' . $endTime . ') harus lebih besar / setelah jam masuk (' . $startTime . ').');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $conflict = $this->checkRoomConflict($db, $roomId, $bookingDate, $startTime, $endTime);
            if ($conflict) {
                $roomName   = esc($conflict['room_name'] ?: 'Ruangan #' . $roomId);
                $confStart  = esc(substr($conflict['start_time'], 0, 5));
                $confEnd    = esc(substr($conflict['end_time'], 0, 5));
                $confEvent  = esc($conflict['event_name']);
                $confBooker = esc($conflict['booker_name']);
                return redirect()->to('/dashboard#peminjaman')->with('error', "Jadwal Bentrok! Ruangan '{$roomName}' sudah dibooking pada tanggal {$bookingDate} pukul {$confStart} - {$confEnd} untuk kegiatan '{$confEvent}' oleh {$confBooker}. Silakan pilih jam atau ruangan lain.");
            }

            $db->table('room_bookings')->insert([
                'user_id'         => session()->get('user_id'),
                'room_id'         => $roomId,
                'booking_date'    => $bookingDate,
                'start_time'      => $startTime,
                'end_time'        => $endTime,
                'booker_name'     => $bookerName,
                'department'      => $department,
                'event_name'      => $eventName,
                'setup'           => $setup,
                'material_needed' => $materialNeeded,
                'special_request' => $specialRequest,
                'status'          => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Data Peminjaman Ruangan berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal menambahkan booking ruangan: ' . $e->getMessage());
        }
    }

    public function updateRoomBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id             = (int) $this->request->getPost('id');
        $roomId         = (int) $this->request->getPost('room_id');
        $bookingDate    = trim((string) $this->request->getPost('booking_date'));
        $startTime      = trim((string) $this->request->getPost('start_time'));
        $endTime        = trim((string) $this->request->getPost('end_time'));
        $bookerName     = trim((string) $this->request->getPost('booker_name'));
        $department     = trim((string) $this->request->getPost('department'));
        $eventName      = trim((string) $this->request->getPost('event_name'));
        $setup          = trim((string) $this->request->getPost('setup'));
        $materialNeeded = trim((string) $this->request->getPost('material_needed'));
        $specialRequest = trim((string) $this->request->getPost('special_request'));
        $status         = (string) $this->request->getPost('status');

        if (empty($id) || empty($roomId) || empty($bookerName) || empty($bookingDate) || empty($startTime) || empty($endTime)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Data booking ruangan tidak lengkap.');
        }

        if (strtotime($startTime) >= strtotime($endTime)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Validasi Waktu Gagal: Jam keluar (' . $endTime . ') harus lebih besar / setelah jam masuk (' . $startTime . ').');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $conflict = $this->checkRoomConflict($db, $roomId, $bookingDate, $startTime, $endTime, $id);
            if ($conflict) {
                $roomName   = esc($conflict['room_name'] ?: 'Ruangan #' . $roomId);
                $confStart  = esc(substr($conflict['start_time'], 0, 5));
                $confEnd    = esc(substr($conflict['end_time'], 0, 5));
                $confEvent  = esc($conflict['event_name']);
                $confBooker = esc($conflict['booker_name']);
                return redirect()->to('/dashboard#peminjaman')->with('error', "Jadwal Bentrok! Ruangan '{$roomName}' sudah dibooking pada tanggal {$bookingDate} pukul {$confStart} - {$confEnd} untuk kegiatan '{$confEvent}' oleh {$confBooker}. Silakan pilih jam atau ruangan lain.");
            }

            $adminNote = trim((string) $this->request->getPost('admin_note'));
            $updateData = [
                'room_id'         => $roomId,
                'booking_date'    => $bookingDate,
                'start_time'      => $startTime,
                'end_time'        => $endTime,
                'booker_name'     => $bookerName,
                'department'      => $department,
                'event_name'      => $eventName,
                'setup'           => $setup,
                'material_needed' => $materialNeeded,
                'special_request' => $specialRequest,
                'status'          => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'updated_at'      => date('Y-m-d H:i:s'),
            ];
            if ($this->request->getPost('admin_note') !== null && $db->fieldExists('admin_note', 'room_bookings')) {
                $updateData['admin_note'] = $adminNote;
            }
            $db->table('room_bookings')->where('id', $id)->update($updateData);
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Peminjaman ruangan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal memperbarui booking ruangan: ' . $e->getMessage());
        }
    }

    public function deleteRoomBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        try {
            $db = \Config\Database::connect();
            $db->table('room_bookings')->where('id', $id)->delete();
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Booking ruangan berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD PEMINJAMAN: KENDARAAN
    // =========================================================================
    public function createVehicleBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $vehicleId   = (int) $this->request->getPost('vehicle_id');
        $bookingDate = (string) $this->request->getPost('booking_date');
        $bookingDay  = (string) ($this->request->getPost('booking_day') ?: date('l', strtotime($bookingDate)));
        $startTime   = trim((string) $this->request->getPost('start_time'));
        $endTime     = trim((string) $this->request->getPost('end_time'));
        $bookerName  = trim((string) $this->request->getPost('booker_name'));
        $department  = trim((string) $this->request->getPost('department'));
        $destination = trim((string) $this->request->getPost('destination'));
        $description = trim((string) $this->request->getPost('description'));
        $driverName  = trim((string) $this->request->getPost('driver_name'));
        $kmIn        = $this->request->getPost('km_in') !== '' ? (int) $this->request->getPost('km_in') : null;
        $kmOut       = $this->request->getPost('km_out') !== '' ? (int) $this->request->getPost('km_out') : null;
        $status      = (string) ($this->request->getPost('status') ?: 'pending');

        if (empty($vehicleId) || empty($bookingDate) || empty($startTime) || empty($endTime) || empty($bookerName) || empty($destination)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Kendaraan, Tanggal, Jam Berangkat, Jam Selesai, Peminjam, dan Tujuan wajib diisi.');
        }

        if (strtotime($startTime) >= strtotime($endTime)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Validasi Waktu Gagal: Jam kembali/selesai (' . $endTime . ') harus lebih besar / setelah jam berangkat (' . $startTime . ').');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $conflict = $this->checkVehicleConflict($db, $vehicleId, $bookingDate, $startTime, $endTime);
            if ($conflict) {
                $vehName    = esc(($conflict['vehicle_name'] ?: 'Kendaraan #' . $vehicleId) . ($conflict['plate_number'] ? ' (' . $conflict['plate_number'] . ')' : ''));
                $confStart  = esc(substr($conflict['start_time'], 0, 5));
                $confEnd    = esc(substr($conflict['end_time'], 0, 5));
                $confDest   = esc($conflict['destination']);
                $confBooker = esc($conflict['booker_name']);
                return redirect()->to('/dashboard#peminjaman')->with('error', "Jadwal Bentrok! Kendaraan '{$vehName}' sudah dibooking pada tanggal {$bookingDate} pukul {$confStart} - {$confEnd} untuk tujuan '{$confDest}' oleh {$confBooker}. Silakan pilih jam atau kendaraan lain.");
            }

            $db->table('vehicle_bookings')->insert([
                'user_id'      => session()->get('user_id'),
                'vehicle_id'   => $vehicleId,
                'booking_date' => $bookingDate,
                'booking_day'  => $bookingDay,
                'start_time'   => $startTime,
                'end_time'     => $endTime,
                'booker_name'  => $bookerName,
                'department'   => $department,
                'destination'  => $destination,
                'description'  => $description,
                'driver_name'  => $driverName,
                'km_in'        => $kmIn,
                'km_out'       => $kmOut,
                'status'       => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Data Peminjaman Kendaraan berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal menambahkan booking kendaraan: ' . $e->getMessage());
        }
    }

    public function updateVehicleBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id          = (int) $this->request->getPost('id');
        $vehicleId   = (int) $this->request->getPost('vehicle_id');
        $bookingDate = (string) $this->request->getPost('booking_date');
        $bookingDay  = (string) ($this->request->getPost('booking_day') ?: date('l', strtotime($bookingDate)));
        $startTime   = trim((string) $this->request->getPost('start_time'));
        $endTime     = trim((string) $this->request->getPost('end_time'));
        $bookerName  = trim((string) $this->request->getPost('booker_name'));
        $department  = trim((string) $this->request->getPost('department'));
        $destination = trim((string) $this->request->getPost('destination'));
        $description = trim((string) $this->request->getPost('description'));
        $driverName  = trim((string) $this->request->getPost('driver_name'));
        $kmIn        = $this->request->getPost('km_in') !== '' ? (int) $this->request->getPost('km_in') : null;
        $kmOut       = $this->request->getPost('km_out') !== '' ? (int) $this->request->getPost('km_out') : null;
        $status      = (string) $this->request->getPost('status');

        if (empty($id) || empty($vehicleId) || empty($bookerName) || empty($bookingDate) || empty($startTime) || empty($endTime)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Data booking kendaraan tidak lengkap.');
        }

        if (strtotime($startTime) >= strtotime($endTime)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Validasi Waktu Gagal: Jam kembali/selesai (' . $endTime . ') harus lebih besar / setelah jam berangkat (' . $startTime . ').');
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            $conflict = $this->checkVehicleConflict($db, $vehicleId, $bookingDate, $startTime, $endTime, $id);
            if ($conflict) {
                $vehName    = esc(($conflict['vehicle_name'] ?: 'Kendaraan #' . $vehicleId) . ($conflict['plate_number'] ? ' (' . $conflict['plate_number'] . ')' : ''));
                $confStart  = esc(substr($conflict['start_time'], 0, 5));
                $confEnd    = esc(substr($conflict['end_time'], 0, 5));
                $confDest   = esc($conflict['destination']);
                $confBooker = esc($conflict['booker_name']);
                return redirect()->to('/dashboard#peminjaman')->with('error', "Jadwal Bentrok! Kendaraan '{$vehName}' sudah dibooking pada tanggal {$bookingDate} pukul {$confStart} - {$confEnd} untuk tujuan '{$confDest}' oleh {$confBooker}. Silakan pilih jam atau kendaraan lain.");
            }

            $adminNote = trim((string) $this->request->getPost('admin_note'));
            $updateData = [
                'vehicle_id'   => $vehicleId,
                'booking_date' => $bookingDate,
                'booking_day'  => $bookingDay,
                'start_time'   => $startTime,
                'end_time'     => $endTime,
                'booker_name'  => $bookerName,
                'department'   => $department,
                'destination'  => $destination,
                'description'  => $description,
                'driver_name'  => $driverName,
                'km_in'        => $kmIn,
                'km_out'       => $kmOut,
                'status'       => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'updated_at'   => date('Y-m-d H:i:s'),
            ];
            if ($this->request->getPost('admin_note') !== null && $db->fieldExists('admin_note', 'vehicle_bookings')) {
                $updateData['admin_note'] = $adminNote;
            }
            $db->table('vehicle_bookings')->where('id', $id)->update($updateData);
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Peminjaman kendaraan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal memperbarui booking kendaraan: ' . $e->getMessage());
        }
    }

    public function deleteVehicleBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        try {
            $db = \Config\Database::connect();
            $db->table('vehicle_bookings')->where('id', $id)->delete();
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Booking kendaraan berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD REQUEST: MAINTENANCE
    // =========================================================================
    public function createMaintenance()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $requesterName = trim((string) $this->request->getPost('requester_name'));
        $department    = trim((string) $this->request->getPost('department'));
        $location      = trim((string) $this->request->getPost('location'));
        $facility      = trim((string) $this->request->getPost('facility'));
        $description   = trim((string) $this->request->getPost('description'));
        $status        = (string) ($this->request->getPost('status') ?: 'pending');

        $redirectTab   = $this->request->getPost('redirect_tab') ?: 'request-maintenance';

        if (empty($requesterName) || empty($location) || empty($description)) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Nama Pemohon, Lokasi, dan Keterangan Kerusakan wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('maintenance_requests')->insert([
                'user_id'        => session()->get('user_id'),
                'requester_name' => $requesterName,
                'department'     => $department,
                'location'       => $location,
                'facility'       => $facility ?: 'Fasilitas Umum',
                'description'    => $description,
                'status'         => in_array($status, ['pending', 'in_progress', 'resolved']) ? $status : 'pending',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Data Request Maintenance berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal menambahkan request maintenance: ' . $e->getMessage());
        }
    }

    public function updateMaintenance()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id            = (int) $this->request->getPost('id');
        $requesterName = trim((string) $this->request->getPost('requester_name'));
        $department    = trim((string) $this->request->getPost('department'));
        $location      = trim((string) $this->request->getPost('location'));
        $facility      = trim((string) $this->request->getPost('facility'));
        $description   = trim((string) $this->request->getPost('description'));
        $status        = (string) $this->request->getPost('status');
        $redirectTab   = $this->request->getPost('redirect_tab') ?: 'request-maintenance';

        if (empty($id) || empty($requesterName) || empty($location)) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Data maintenance tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $adminNote = trim((string) $this->request->getPost('admin_note'));
            $updateData = [
                'requester_name' => $requesterName,
                'department'     => $department,
                'location'       => $location,
                'facility'       => $facility,
                'description'    => $description,
                'status'         => in_array($status, ['pending', 'in_progress', 'resolved', 'rejected', 'approved']) ? $status : 'pending',
                'updated_at'     => date('Y-m-d H:i:s'),
            ];
            if ($this->request->getPost('admin_note') !== null && $db->fieldExists('admin_note', 'maintenance_requests')) {
                // Sesuai arahan: Pada status approve tidak perlu ada keterangan
                $updateData['admin_note'] = ($status === 'resolved' || $status === 'approved') ? null : $adminNote;
            }
            $db->table('maintenance_requests')->where('id', $id)->update($updateData);
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Request maintenance berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal memperbarui maintenance: ' . $e->getMessage());
        }
    }

    public function deleteMaintenance()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        $redirectTab = $this->request->getPost('redirect_tab') ?: 'request-maintenance';
        try {
            $db = \Config\Database::connect();
            $db->table('maintenance_requests')->where('id', $id)->delete();
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Request maintenance berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD REQUEST: SUPPLIES REQUEST
    // =========================================================================
    public function createSupplyRequest()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $email         = trim((string) $this->request->getPost('email'));
        $requesterName = trim((string) $this->request->getPost('requester_name'));
        $department    = trim((string) $this->request->getPost('department'));
        $dateRequested = (string) ($this->request->getPost('date_requested') ?: date('Y-m-d'));
        $dateNeeded    = (string) $this->request->getPost('date_needed');
        $supplyId      = (int) $this->request->getPost('supply_id');
        $quantity      = (int) ($this->request->getPost('quantity') ?: 1);
        $status        = (string) ($this->request->getPost('status') ?: 'pending');
        $redirectTab   = $this->request->getPost('redirect_tab') ?: 'request-supplies';

        if (empty($requesterName) || empty($supplyId) || empty($dateNeeded)) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Nama Pemohon, Barang, dan Tanggal Dibutuhkan wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $targetStatus = in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending';

            // Jika dibuat langsung dengan status approved, kurangi stok barang
            if ($targetStatus === 'approved' && $db->tableExists('supplies')) {
                $supply = $db->table('supplies')->where('id', $supplyId)->get()->getRowArray();
                if ($supply) {
                    $db->table('supplies')->where('id', $supplyId)->update([
                        'stock'      => max(0, ((int)$supply['stock']) - $quantity),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            $db->table('supply_requests')->insert([
                'user_id'        => session()->get('user_id'),
                'email'          => $email,
                'requester_name' => $requesterName,
                'department'     => $department,
                'date_requested' => $dateRequested,
                'date_needed'    => $dateNeeded,
                'supply_id'      => $supplyId,
                'quantity'       => $quantity,
                'status'         => $targetStatus,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Permohonan Supplies berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal menambahkan permohonan supplies: ' . $e->getMessage());
        }
    }

    public function updateSupplyRequest()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id            = (int) $this->request->getPost('id');
        $email         = trim((string) $this->request->getPost('email'));
        $requesterName = trim((string) $this->request->getPost('requester_name'));
        $department    = trim((string) $this->request->getPost('department'));
        $dateRequested = (string) $this->request->getPost('date_requested');
        $dateNeeded    = (string) $this->request->getPost('date_needed');
        $supplyId      = (int) $this->request->getPost('supply_id');
        $quantity      = (int) ($this->request->getPost('quantity') ?: 1);
        $status        = (string) $this->request->getPost('status');
        $redirectTab   = $this->request->getPost('redirect_tab') ?: 'request-supplies';

        if (empty($id) || empty($requesterName) || empty($supplyId)) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Data permohonan supplies tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $adminNote = trim((string) $this->request->getPost('admin_note'));
            $newStatus = in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending';

            // Kelola sinkronisasi stok saat update data permohonan supplies
            if ($db->tableExists('supplies')) {
                $oldSr = $db->table('supply_requests')->where('id', $id)->get()->getRowArray();
                if ($oldSr) {
                    $oldStatus   = $oldSr['status'] ?? 'pending';
                    $oldSupplyId = (int) ($oldSr['supply_id'] ?? 0);
                    $oldQty      = (int) ($oldSr['quantity'] ?? 0);

                    // 1. Jika sebelumnya approved dan status baru bukan approved: kembalikan stok lama
                    if ($oldStatus === 'approved' && $newStatus !== 'approved') {
                        $sOld = $db->table('supplies')->where('id', $oldSupplyId)->get()->getRowArray();
                        if ($sOld) {
                            $db->table('supplies')->where('id', $oldSupplyId)->update([
                                'stock'      => ((int)$sOld['stock']) + $oldQty,
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                    // 2. Jika sebelumnya bukan approved dan status baru approved: kurangi stok baru
                    elseif ($oldStatus !== 'approved' && $newStatus === 'approved') {
                        $sNew = $db->table('supplies')->where('id', $supplyId)->get()->getRowArray();
                        if ($sNew) {
                            $db->table('supplies')->where('id', $supplyId)->update([
                                'stock'      => max(0, ((int)$sNew['stock']) - $quantity),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                    // 3. Jika sebelumnya approved dan status baru tetap approved, namun barang/jumlah berubah
                    elseif ($oldStatus === 'approved' && $newStatus === 'approved') {
                        if ($oldSupplyId === $supplyId) {
                            $diff = $quantity - $oldQty;
                            if ($diff != 0) {
                                $s = $db->table('supplies')->where('id', $supplyId)->get()->getRowArray();
                                if ($s) {
                                    $db->table('supplies')->where('id', $supplyId)->update([
                                        'stock'      => max(0, ((int)$s['stock']) - $diff),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                    ]);
                                }
                            }
                        } else {
                            $sOld = $db->table('supplies')->where('id', $oldSupplyId)->get()->getRowArray();
                            if ($sOld) {
                                $db->table('supplies')->where('id', $oldSupplyId)->update([
                                    'stock'      => ((int)$sOld['stock']) + $oldQty,
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }
                            $sNew = $db->table('supplies')->where('id', $supplyId)->get()->getRowArray();
                            if ($sNew) {
                                $db->table('supplies')->where('id', $supplyId)->update([
                                    'stock'      => max(0, ((int)$sNew['stock']) - $quantity),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                ]);
                            }
                        }
                    }
                }
            }

            $updateData = [
                'email'          => $email,
                'requester_name' => $requesterName,
                'department'     => $department,
                'date_requested' => $dateRequested,
                'date_needed'    => $dateNeeded,
                'supply_id'      => $supplyId,
                'quantity'       => $quantity,
                'status'         => $newStatus,
                'updated_at'     => date('Y-m-d H:i:s'),
            ];
            if ($this->request->getPost('admin_note') !== null && $db->fieldExists('admin_note', 'supply_requests')) {
                // Sesuai arahan: Pada status approve tidak perlu ada keterangan
                $updateData['admin_note'] = ($newStatus === 'approved') ? null : $adminNote;
            }
            $db->table('supply_requests')->where('id', $id)->update($updateData);
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Permohonan supplies berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal memperbarui permohonan supplies: ' . $e->getMessage());
        }
    }

    public function deleteSupplyRequest()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        $redirectTab = $this->request->getPost('redirect_tab') ?: 'request-supplies';
        try {
            $db = \Config\Database::connect();
            // Jika yang dihapus sebelumnya sudah approved, kembalikan stoknya
            if ($db->tableExists('supplies')) {
                $sr = $db->table('supply_requests')->where('id', $id)->get()->getRowArray();
                if ($sr && ($sr['status'] ?? '') === 'approved') {
                    $supplyId = (int) ($sr['supply_id'] ?? 0);
                    $qty      = (int) ($sr['quantity'] ?? 0);
                    if ($supplyId > 0 && $qty > 0) {
                        $supply = $db->table('supplies')->where('id', $supplyId)->get()->getRowArray();
                        if ($supply) {
                            $db->table('supplies')->where('id', $supplyId)->update([
                                'stock'      => ((int)$supply['stock']) + $qty,
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                }
            }
            $db->table('supply_requests')->where('id', $id)->delete();
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('message', 'Permohonan supplies berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#' . ltrim($redirectTab, '#'))->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    /**
     * Membatalkan permohonan milik pengguna (Mahasiswa/Dosen) yang masih berstatus pending
     */
    public function cancelMyRequest()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId   = session()->get('user_id');
        $userName = session()->get('user_name');
        $role     = session()->get('role') ?? 'user';
        $type     = (string) $this->request->getPost('type');
        $id       = (int) $this->request->getPost('id');

        if (empty($id) || empty($type)) {
            return redirect()->to('/dashboard')->with('error', 'Permintaan pembatalan tidak valid.');
        }

        $tableMap = [
            'room'        => ['table' => 'room_bookings', 'user_col' => 'booker_name', 'label' => 'Peminjaman Ruangan', 'tab' => '#myrooms'],
            'vehicle'     => ['table' => 'vehicle_bookings', 'user_col' => 'booker_name', 'label' => 'Peminjaman Kendaraan', 'tab' => '#myvehicles'],
            'maintenance' => ['table' => 'maintenance_requests', 'user_col' => 'requester_name', 'label' => 'Request Maintenance', 'tab' => '#mymaintenance'],
            'supplies'    => ['table' => 'supply_requests', 'user_col' => 'requester_name', 'label' => 'Request Supplies (ATK)', 'tab' => '#mysupplies'],
        ];

        if (!isset($tableMap[$type])) {
            return redirect()->to('/dashboard')->with('error', 'Tipe permohonan tidak dikenal.');
        }

        $info = $tableMap[$type];
        $redirectTab = $this->request->getPost('redirect_tab');
        $targetTab = $redirectTab ? '#' . ltrim($redirectTab, '#') : $info['tab'];

        try {
            $db = \Config\Database::connect();
            $builder = $db->table($info['table'])->where('id', $id);

            // Validasi kepemilikan: non-admin hanya dapat menghapus permohonan miliknya sendiri
            if (!in_array($role, ['super_admin', 'admin'])) {
                if ($db->fieldExists('user_id', $info['table']) && $userId) {
                    $builder->groupStart()
                        ->where('user_id', $userId)
                        ->orWhere($info['user_col'], $userName)
                        ->groupEnd();
                } else {
                    $builder->where($info['user_col'], $userName);
                }
            }

            $item = $builder->get()->getRowArray();
            if (!$item) {
                return redirect()->to('/dashboard' . $targetTab)->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses untuk membatalkannya.');
            }

            if ($item['status'] !== 'pending') {
                return redirect()->to('/dashboard' . $targetTab)->with('error', 'Hanya permohonan dengan status "Pending" yang dapat dibatalkan.');
            }

            $db->table($info['table'])->where('id', $id)->delete();
            return redirect()->to('/dashboard' . $targetTab)->with('message', $info['label'] . ' berhasil dibatalkan dan dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard' . $targetTab)->with('error', 'Gagal membatalkan permohonan: ' . $e->getMessage());
        }
    }

    /**
     * Memastikan kolom user_id, admin_note, dan status tersedia di tabel-tabel permohonan untuk multi-account isolation dan approval notes
     */
    private function ensureUserIdColumns($db)
    {
        $requestTables = ['room_bookings', 'vehicle_bookings', 'maintenance_requests', 'supply_requests'];
        foreach ($requestTables as $tbl) {
            if ($db->tableExists($tbl)) {
                if (!$db->fieldExists('user_id', $tbl)) {
                    try {
                        $db->query("ALTER TABLE `{$tbl}` ADD COLUMN `user_id` INT(11) UNSIGNED NULL AFTER `id`");
                    } catch (\Throwable $e) {}
                }
            }
        }

        // Pastikan kolom admin_note tersedia di semua tabel permohonan & pelaporan
        $allStatusTables = ['room_bookings', 'vehicle_bookings', 'maintenance_requests', 'supply_requests', 'lost_found', 'visitors'];
        foreach ($allStatusTables as $tbl) {
            if ($db->tableExists($tbl)) {
                if (!$db->fieldExists('admin_note', $tbl)) {
                    try {
                        $db->query("ALTER TABLE `{$tbl}` ADD COLUMN `admin_note` TEXT NULL AFTER `status`");
                    } catch (\Throwable $e) {}
                }
            }
        }

        // Pastikan status di maintenance_requests mendukung approved dan rejected
        if ($db->tableExists('maintenance_requests')) {
            try {
                $db->query("ALTER TABLE `maintenance_requests` MODIFY COLUMN `status` VARCHAR(50) NOT NULL DEFAULT 'pending'");
            } catch (\Throwable $e) {}
        }

        // Pastikan kolom phone, identity_number, is_suspended, suspend_reason tersedia di tabel users
        if ($db->tableExists('users')) {
            if (!$db->fieldExists('microsoft_id', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `microsoft_id` VARCHAR(100) NULL AFTER `email`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('phone', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `phone` VARCHAR(50) NULL AFTER `department`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('identity_number', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `identity_number` VARCHAR(50) NULL AFTER `phone`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('is_suspended', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `is_suspended` TINYINT(1) NOT NULL DEFAULT 0 AFTER `identity_number`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('suspend_reason', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `suspend_reason` TEXT NULL AFTER `is_suspended`"); } catch (\Throwable $e) {}
            }
        }

        // Pastikan kolom ticket_code dan report_type tersedia di tabel lost_found
        if ($db->tableExists('lost_found')) {
            if (!$db->fieldExists('ticket_code', 'lost_found')) {
                try { $db->query("ALTER TABLE `lost_found` ADD COLUMN `ticket_code` VARCHAR(50) NULL AFTER `id`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('report_type', 'lost_found')) {
                try { $db->query("ALTER TABLE `lost_found` ADD COLUMN `report_type` ENUM('lost','found') NOT NULL DEFAULT 'lost' AFTER `ticket_code`"); } catch (\Throwable $e) {}
            }
        }

        // Pastikan kolom pass_code tersedia di tabel visitors
        if ($db->tableExists('visitors')) {
            if (!$db->fieldExists('pass_code', 'visitors')) {
                try { $db->query("ALTER TABLE `visitors` ADD COLUMN `pass_code` VARCHAR(50) NULL AFTER `id`"); } catch (\Throwable $e) {}
            }
        }

        // Pastikan kolom 2FA tersedia di tabel users
        if ($db->tableExists('users')) {
            if (!$db->fieldExists('two_factor_code', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `two_factor_code` VARCHAR(10) NULL AFTER `identity_number`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('two_factor_expires', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `two_factor_expires` DATETIME NULL AFTER `two_factor_code`"); } catch (\Throwable $e) {}
            }
        }

        // Pastikan tabel auth_logs tersedia untuk audit keamanan login
        try {
            $db->query("CREATE TABLE IF NOT EXISTS `auth_logs` (
              `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `user_id` int(11) UNSIGNED DEFAULT NULL,
              `email` varchar(150) DEFAULT NULL,
              `action` varchar(50) NOT NULL,
              `method` varchar(30) NOT NULL,
              `status` enum('success','failed','blocked') NOT NULL,
              `ip_address` varchar(50) NOT NULL,
              `user_agent` text DEFAULT NULL,
              `details` text DEFAULT NULL,
              `created_at` datetime NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        } catch (\Throwable $e) {}

        // Pastikan kolom location dan status tersedia di tabel rooms
        if ($db->tableExists('rooms')) {
            if (!$db->fieldExists('location', 'rooms')) {
                try { $db->query("ALTER TABLE `rooms` ADD COLUMN `location` VARCHAR(150) DEFAULT 'Gedung Utama' AFTER `capacity`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('status', 'rooms')) {
                try { $db->query("ALTER TABLE `rooms` ADD COLUMN `status` ENUM('active','maintenance') NOT NULL DEFAULT 'active' AFTER `location`"); } catch (\Throwable $e) {}
            }
        }

        // Pastikan kolom capacity dan status tersedia di tabel vehicles
        if ($db->tableExists('vehicles')) {
            if (!$db->fieldExists('capacity', 'vehicles')) {
                try { $db->query("ALTER TABLE `vehicles` ADD COLUMN `capacity` INT(11) NOT NULL DEFAULT 7 AFTER `plate_number`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('status', 'vehicles')) {
                try { $db->query("ALTER TABLE `vehicles` ADD COLUMN `status` ENUM('available','maintenance') NOT NULL DEFAULT 'available' AFTER `capacity`"); } catch (\Throwable $e) {}
            }
        }
    }

    /**
     * Memeriksa bentrok jadwal peminjaman ruangan pada tanggal dan rentang jam yang sama
     */
    private function checkRoomConflict($db, $roomId, $bookingDate, $startTime, $endTime, $excludeId = null)
    {
        $startTime = substr($startTime, 0, 5);
        $endTime   = substr($endTime, 0, 5);

        $builder = $db->table('room_bookings')
            ->select('room_bookings.*, rooms.room_name')
            ->join('rooms', 'rooms.id = room_bookings.room_id', 'left')
            ->where('room_bookings.room_id', $roomId)
            ->where('room_bookings.booking_date', $bookingDate)
            ->where('room_bookings.status !=', 'rejected')
            ->where('room_bookings.start_time <', $endTime)
            ->where('room_bookings.end_time >', $startTime);

        if ($excludeId) {
            $builder->where('room_bookings.id !=', $excludeId);
        }

        return $builder->get()->getRowArray();
    }

    /**
     * Memeriksa bentrok jadwal peminjaman kendaraan pada tanggal dan rentang jam yang sama
     */
    private function checkVehicleConflict($db, $vehicleId, $bookingDate, $startTime, $endTime, $excludeId = null)
    {
        $startTime = substr($startTime, 0, 5);
        $endTime   = substr($endTime, 0, 5);

        $builder = $db->table('vehicle_bookings')
            ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number')
            ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left')
            ->where('vehicle_bookings.vehicle_id', $vehicleId)
            ->where('vehicle_bookings.booking_date', $bookingDate)
            ->where('vehicle_bookings.status !=', 'rejected')
            ->where('vehicle_bookings.start_time <', $endTime)
            ->where('vehicle_bookings.end_time >', $startTime);

        if ($excludeId) {
            $builder->where('vehicle_bookings.id !=', $excludeId);
        }

        return $builder->get()->getRowArray();
    }
}
