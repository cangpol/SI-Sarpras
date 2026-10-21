<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Microsoft extends BaseConfig
{
    /**
     * Apakah fitur Microsoft 365 SSO aktif.
     */
    public bool $enabled = true;

    /**
     * Application (Client) ID dari Microsoft Entra ID (Azure Portal).
     */
    public string $clientId = '894f13d5-ce40-4019-95d6-8486c504d86d';

    /**
     * Client Secret Value dari Certificates & secrets.
     */
    public string $clientSecret = '';

    /**
     * Directory (Tenant) ID dari Microsoft Entra ID.
     */
    public string $tenantId = 'd9a2c984-5dc2-4d26-947a-894383245af3';

    /**
     * Redirect URI terdaftar (bisa override jika perlu).
     * Jika kosong, akan otomatis menggunakan base_url('auth/microsoft/callback').
     */
    public string $redirectUri = '';

    /**
     * Scope izin OpenID & Microsoft Graph.
     */
    public string $scope = 'openid profile email User.Read';

    /**
     * Daftar email institusi yang otomatis mendapatkan hak akses Super Admin (Biro IT).
     */
    public array $superAdminEmails = [
        'it@upitra.ac.id',
    ];

    /**
     * Daftar email institusi yang otomatis mendapatkan hak akses Admin (Biro Sarpras).
     */
    public array $adminEmails = [
        'sarpras@upitra.ac.id',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->enabled      = filter_var(env('MICROSOFT_SSO_ENABLED', $this->enabled), FILTER_VALIDATE_BOOLEAN);
        $this->clientId     = (string) env('MICROSOFT_CLIENT_ID', $this->clientId);
        $this->tenantId     = (string) env('MICROSOFT_TENANT_ID', $this->tenantId);
        $this->redirectUri  = (string) env('MICROSOFT_REDIRECT_URI', $this->redirectUri);

        // Ambil secret dari environment atau berkas rahasia lokal yang diabaikan git
        $secret = (string) env('MICROSOFT_CLIENT_SECRET', '');
        if (empty($secret) || $secret === 'your_azure_client_secret_here') {
            $secretFile = APPPATH . 'Config/microsoft_secret.php';
            if (is_file($secretFile)) {
                $localSecret = include $secretFile;
                if (!empty($localSecret) && is_string($localSecret)) {
                    $secret = $localSecret;
                }
            }
        }
        $this->clientSecret = $secret;
    }
}
