<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.item-card {
    transition: all 0.2s ease;
    border: 1px solid #e2e8f0;
}
.item-card:hover {
    border-color: #93c5fd;
    box-shadow: 0 4px 12px rgba(10, 58, 102, 0.06);
}

/* Combobox Autocomplete Styling */
.combobox-wrapper {
    position: relative;
}
.combobox-wrapper .input-group {
    border-radius: 0.375rem;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.combobox-wrapper .form-control:focus {
    box-shadow: none;
    border-color: #86b7fe;
}
.combobox-wrapper .input-group:focus-within {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.18);
    border-radius: 0.375rem;
}

/* Floating Suggestions Dropdown */
.supply-dropdown-menu {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    z-index: 1060;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 0.5rem;
    box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
    max-height: 250px;
    overflow-y: auto;
    display: none;
    padding: 4px 0;
}
.supply-dropdown-item {
    padding: 10px 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    border-bottom: 1px solid #f1f5f9;
    transition: background-color 0.15s ease;
    font-size: 0.92rem;
}
.supply-dropdown-item:last-child {
    border-bottom: none;
}
.supply-dropdown-item:hover,
.supply-dropdown-item.active {
    background-color: #eff6ff;
    color: #1e40af;
}
.supply-dropdown-item .item-match-hl {
    font-weight: 700;
    color: #0d6efd;
    background-color: #e0f2fe;
    padding: 1px 3px;
    border-radius: 3px;
}
.supply-dropdown-empty {
    padding: 14px;
    text-align: center;
    color: #64748b;
    font-size: 0.88rem;
}
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--primary-blue);">Permohonan Supplies (ATK)</h2>
        <p class="text-muted mb-0">Formulir pengajuan permintaan alat tulis kantor dan barang operasional unit/bagian.</p>
    </div>
    <a href="/" class="btn btn-outline-secondary rounded-pill px-3">
        &larr; Kembali ke Beranda
    </a>
</div>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle-fill me-2 flex-shrink-0" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <div><?= session()->getFlashdata('message') ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2 flex-shrink-0" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            <div><?= session()->getFlashdata('error') ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
        <form method="post" action="/request/supplies" id="formSupplies">
            <?= csrf_field() ?>
            
            <h5 class="fw-bold mb-3 text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-lines-fill me-2" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
                </svg>
                Informasi Pemohon
            </h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email Pemohon <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="nama@pignatelli.ac.id" value="<?= old('email') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="requester_name" class="form-control" placeholder="Nama Lengkap Peminta" value="<?= old('requester_name') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Unit Kerja / Department <span class="text-danger">*</span></label>
                    <input type="text" name="department" class="form-control" placeholder="Contoh: IT, SDM, LPPM, Dosen" value="<?= old('department') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Date Requested (Tanggal Pengajuan) <span class="text-danger">*</span></label>
                    <input type="date" name="date_requested" class="form-control" required value="<?= old('date_requested') ?: date('Y-m-d') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Date Needed (Dibutuhkan Tanggal) <span class="text-danger">*</span></label>
                    <input type="date" name="date_needed" class="form-control" required value="<?= old('date_needed') ?>">
                </div>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <!-- BAGIAN DAFTAR MULTI-ITEM -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div>
                    <h5 class="fw-bold mb-1 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-boxes me-2" viewBox="0 0 16 16">
                            <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434zM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567zM7.5 9.933l-2.75 1.571v3.134l2.75-1.571zm1 3.134 2.75 1.571v-3.134L8.5 9.933zm4.75-2.429 2.742-1.567-2.742-1.567-2.742 1.567zM8 1.732 5.258 3.299 8 4.866l2.742-1.567zm0 4.134L5.258 4.299v3.134L8 8.999zm1 3.133 2.742-1.566V4.299L9 5.866z"/>
                        </svg>
                        Daftar Barang (Bisa Lebih dari 1 Item)
                    </h5>
                    <small class="text-muted">Ketik langsung di kolom nama barang untuk mencari (misal ketik <strong>Ker</strong> untuk memilih Kertas), lalu masukkan jumlah yang dibutuhkan.</small>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold" id="btnAddRowTop">
                    + Tambah Barang Lagi
                </button>
            </div>

            <!-- CONTAINER LIST ITEM -->
            <div id="itemsList">
                <!-- Baris 1 (Default) -->
                <div class="card p-3 mb-3 rounded-3 item-card bg-light bg-opacity-25" id="itemRow_0" data-row-id="0">
                    <div class="row align-items-start g-3">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold small mb-1">
                                <span class="badge bg-primary me-1 item-badge">Item #1</span> Pilih Barang <span class="text-danger">*</span>
                            </label>
                            
                            <!-- Combobox Autocomplete -->
                            <div class="combobox-wrapper">
                                <div class="input-group">
                                    <span class="input-group-text bg-white text-muted border-end-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                    </span>
                                    <input type="text" 
                                           class="form-control supply-search-input border-start-0" 
                                           placeholder="Ketik nama barang... (contoh: Ker, Kertas, Spidol)" 
                                           autocomplete="off"
                                           required>
                                    <button class="btn btn-outline-secondary border-start-0 supply-clear-btn" type="button" title="Bersihkan pilihan" style="display: none;">
                                        &times;
                                    </button>
                                    <button class="btn btn-outline-secondary supply-toggle-btn" type="button" title="Tampilkan semua barang">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </button>
                                </div>
                                <!-- Hidden input for supply_id -->
                                <input type="hidden" name="items[0][supply_id]" class="supply-id-input" required>
                                
                                <!-- Stock info badge under input -->
                                <div class="supply-stock-info mt-1" style="display: none;"></div>

                                <!-- Floating suggestions menu -->
                                <div class="supply-dropdown-menu"></div>
                            </div>
                        </div>

                        <div class="col-md-3 col-8">
                            <label class="form-label fw-semibold small mb-1">Jumlah (Qty) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="items[0][quantity]" class="form-control quantity-input" min="1" value="1" required placeholder="Jml">
                                <span class="input-group-text bg-light text-muted small unit-label">Unit</span>
                            </div>
                        </div>

                        <div class="col-md-2 col-4 text-end">
                            <label class="form-label small mb-1 d-block text-white opacity-0">&nbsp;</label>
                            <button type="button" class="btn btn-outline-danger w-100 btn-remove-row disabled" onclick="removeRow(0)" title="Hapus baris ini">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Tambah Barang Baris Bawah -->
            <div class="mb-4">
                <button type="button" class="btn btn-outline-primary rounded-pill px-4 fw-semibold" id="btnAddRowBottom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus-circle me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    + Tambah Item Barang Lain
                </button>
            </div>

            <hr class="my-4 text-muted opacity-25">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <span class="text-muted small">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle me-1" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>
                    Pastikan seluruh barang dan jumlah kebutuhan telah sesuai sebelum mengirim permohonan.
                </span>
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm rounded-pill" style="font-size: 1.05rem;">
                    Kirim Permohonan Supplies
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DATA SUPPLIES DARI SERVER (OFFLINE & INSTANT SEARCH) -->
<script>
// Data Master Supplies yang tersedia dari database
var allSupplies = <?= json_encode(array_map(function($s) {
    return [
        'id'        => (int) $s['id'],
        'item_name' => (string) $s['item_name'],
        'stock'     => (int) $s['stock'],
        'unit'      => (string) $s['unit']
    ];
}, $supplies)) ?>;

var rowIndex = 1;

/**
 * Escape string untuk regex safe
 */
function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

/**
 * Inisialisasi Autocomplete Combobox pada sebuah row
 */
function initSupplyCombobox(rowEl) {
    var wrapper = rowEl.querySelector('.combobox-wrapper');
    if (!wrapper) return;

    var searchInput   = wrapper.querySelector('.supply-search-input');
    var idInput       = wrapper.querySelector('.supply-id-input');
    var clearBtn      = wrapper.querySelector('.supply-clear-btn');
    var toggleBtn     = wrapper.querySelector('.supply-toggle-btn');
    var dropdownMenu  = wrapper.querySelector('.supply-dropdown-menu');
    var stockInfo     = wrapper.querySelector('.supply-stock-info');
    var unitLabel     = rowEl.querySelector('.unit-label');

    var highlightedIndex = -1;
    var currentFilteredList = [];

    // Fungsi Render Daftar Pilihan Dropdown
    function renderDropdown(items, query) {
        currentFilteredList = items;
        highlightedIndex = items.length > 0 ? 0 : -1;
        dropdownMenu.innerHTML = '';

        if (items.length === 0) {
            dropdownMenu.innerHTML = `
                <div class="supply-dropdown-empty">
                    <div class="fw-semibold text-danger mb-1">Barang tidak ditemukan</div>
                    <small>Tidak ada nama barang yang cocok dengan "${query || ''}".</small>
                </div>
            `;
            dropdownMenu.style.display = 'block';
            return;
        }

        items.forEach(function(item, idx) {
            var itemEl = document.createElement('div');
            itemEl.className = 'supply-dropdown-item' + (idx === 0 ? ' active' : '');
            itemEl.setAttribute('data-id', item.id);
            itemEl.setAttribute('data-index', idx);

            // Highlight huruf yang cocok (misal: "Ker" pada "Kertas")
            var displayName = item.item_name;
            if (query && query.trim() !== '') {
                var regex = new RegExp('(' + escapeRegExp(query.trim()) + ')', 'gi');
                displayName = displayName.replace(regex, '<span class="item-match-hl">$1</span>');
            }

            var stockBadgeClass = item.stock > 0 ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle';
            var stockText = item.stock > 0 ? `Stok: ${item.stock} ${item.unit}` : 'Stok Habis';

            itemEl.innerHTML = `
                <div>
                    <span class="item-title">${displayName}</span>
                </div>
                <span class="badge ${stockBadgeClass} rounded-pill px-2 py-1" style="font-size: 0.75rem; white-space: nowrap;">
                    ${stockText}
                </span>
            `;

            // Hover event
            itemEl.addEventListener('mouseenter', function() {
                updateHighlighted(idx);
            });

            // Click event untuk memilih barang
            itemEl.addEventListener('mousedown', function(e) {
                e.preventDefault(); // Mencegah blur sebelum klik selesai
                selectItem(item);
            });

            dropdownMenu.appendChild(itemEl);
        });

        dropdownMenu.style.display = 'block';
    }

    // Fungsi update highlight keyboard / hover
    function updateHighlighted(index) {
        var items = dropdownMenu.querySelectorAll('.supply-dropdown-item');
        items.forEach(function(el, i) {
            if (i === index) {
                el.classList.add('active');
                el.scrollIntoView({ block: 'nearest' });
            } else {
                el.classList.remove('active');
            }
        });
        highlightedIndex = index;
    }

    // Filter barang berdasarkan input teks
    function filterItems(keyword) {
        var term = (keyword || '').trim().toLowerCase();
        if (term === '') {
            return allSupplies;
        }
        return allSupplies.filter(function(item) {
            return item.item_name.toLowerCase().indexOf(term) !== -1;
        });
    }

    // Memilih barang
    function selectItem(item) {
        searchInput.value = item.item_name;
        idInput.value = item.id;
        searchInput.classList.remove('is-invalid');

        // Tampilkan stock info & sesuaikan satuan
        if (unitLabel) {
            unitLabel.textContent = item.unit || 'Unit';
        }

        if (stockInfo) {
            if (item.stock > 0) {
                stockInfo.innerHTML = `
                    <span class="text-success small fw-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        Tersedia di Sarpras: <strong>${item.stock} ${item.unit}</strong>
                    </span>
                `;
            } else {
                stockInfo.innerHTML = `
                    <span class="text-danger small fw-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-exclamation-circle-fill me-1" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
                        </svg>
                        Stok di gudang habis (permintaan tetap akan diproses pengadaannya)
                    </span>
                `;
            }
            stockInfo.style.display = 'block';
        }

        if (clearBtn) clearBtn.style.display = 'block';
        closeDropdown();
    }

    // Bersihkan pilihan
    function clearSelection() {
        searchInput.value = '';
        idInput.value = '';
        if (unitLabel) unitLabel.textContent = 'Unit';
        if (stockInfo) {
            stockInfo.innerHTML = '';
            stockInfo.style.display = 'none';
        }
        if (clearBtn) clearBtn.style.display = 'none';
        searchInput.focus();
        renderDropdown(allSupplies, '');
    }

    function closeDropdown() {
        dropdownMenu.style.display = 'none';
        highlightedIndex = -1;
    }

    // EVENT: Ketik langsung di input (Contoh: nulis "Ker" langsung keluar "Kertas")
    searchInput.addEventListener('input', function() {
        var query = searchInput.value;
        if (query.trim().length > 0) {
            if (clearBtn) clearBtn.style.display = 'block';
        } else {
            if (clearBtn) clearBtn.style.display = 'none';
        }

        // Reset idInput saat user mengubah teks hingga user memilih item
        idInput.value = '';
        if (stockInfo) stockInfo.style.display = 'none';

        var filtered = filterItems(query);
        renderDropdown(filtered, query);
    });

    // EVENT: Fokus pada input
    searchInput.addEventListener('focus', function() {
        var query = searchInput.value;
        var filtered = filterItems(query);
        renderDropdown(filtered, query);
    });

    // EVENT: Navigasi Keyboard (Arrow Up, Arrow Down, Enter, Tab, Escape)
    searchInput.addEventListener('keydown', function(e) {
        if (dropdownMenu.style.display === 'block') {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (currentFilteredList.length > 0) {
                    var nextIndex = (highlightedIndex + 1) % currentFilteredList.length;
                    updateHighlighted(nextIndex);
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (currentFilteredList.length > 0) {
                    var prevIndex = (highlightedIndex - 1 + currentFilteredList.length) % currentFilteredList.length;
                    updateHighlighted(prevIndex);
                }
            } else if (e.key === 'Enter') {
                e.preventDefault(); // Jangan submit form saat memilih di dropdown
                if (highlightedIndex >= 0 && currentFilteredList[highlightedIndex]) {
                    selectItem(currentFilteredList[highlightedIndex]);
                } else if (currentFilteredList.length === 1) {
                    selectItem(currentFilteredList[0]);
                }
            } else if (e.key === 'Tab') {
                // Tab otomatis memilih item pertama jika ada yang cocok
                if (highlightedIndex >= 0 && currentFilteredList[highlightedIndex]) {
                    selectItem(currentFilteredList[highlightedIndex]);
                }
            } else if (e.key === 'Escape') {
                closeDropdown();
            }
        }
    });

    // EVENT: Blur/Keluar fokus
    searchInput.addEventListener('blur', function() {
        setTimeout(function() {
            // Jika teks cocok persis dengan salah satu barang dan ID belum terisi, otomatis pilihkan
            if (!idInput.value && searchInput.value.trim() !== '') {
                var exact = allSupplies.find(function(it) {
                    return it.item_name.toLowerCase() === searchInput.value.trim().toLowerCase();
                });
                if (exact) {
                    selectItem(exact);
                }
            }
            closeDropdown();
        }, 200);
    });

    // EVENT: Tombol Clear (x)
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearSelection();
        });
    }

    // EVENT: Tombol Toggle (Chevron)
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (dropdownMenu.style.display === 'block') {
                closeDropdown();
            } else {
                searchInput.focus();
                renderDropdown(allSupplies, searchInput.value);
            }
        });
    }

    // Klik di luar dropdown untuk menutup
    document.addEventListener('click', function(e) {
        if (!wrapper.contains(e.target)) {
            closeDropdown();
        }
    });
}

/**
 * Update penomoran item dan tombol hapus
 */
function updateBadgesAndButtons() {
    var rows = document.querySelectorAll('#itemsList .item-card');
    rows.forEach(function(row, idx) {
        var badge = row.querySelector('.item-badge');
        if (badge) {
            badge.textContent = 'Item #' + (idx + 1);
        }
        var removeBtn = row.querySelector('.btn-remove-row');
        if (removeBtn) {
            if (rows.length === 1) {
                removeBtn.classList.add('disabled');
                removeBtn.style.opacity = '0.5';
            } else {
                removeBtn.classList.remove('disabled');
                removeBtn.style.opacity = '1';
            }
        }
    });
}

/**
 * Tambah Baris Baru
 */
function addNewRow() {
    var itemsList = document.getElementById('itemsList');
    var newRow = document.createElement('div');
    newRow.className = 'card p-3 mb-3 rounded-3 item-card bg-light bg-opacity-25';
    newRow.id = 'itemRow_' + rowIndex;
    newRow.setAttribute('data-row-id', rowIndex);

    newRow.innerHTML = `
        <div class="row align-items-start g-3">
            <div class="col-md-7">
                <label class="form-label fw-semibold small mb-1">
                    <span class="badge bg-primary me-1 item-badge">Item</span> Pilih Barang <span class="text-danger">*</span>
                </label>
                <div class="combobox-wrapper">
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted border-end-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </span>
                        <input type="text" 
                               class="form-control supply-search-input border-start-0" 
                               placeholder="Ketik nama barang... (contoh: Ker, Kertas, Spidol)" 
                               autocomplete="off"
                               required>
                        <button class="btn btn-outline-secondary border-start-0 supply-clear-btn" type="button" title="Bersihkan pilihan" style="display: none;">
                            &times;
                        </button>
                        <button class="btn btn-outline-secondary supply-toggle-btn" type="button" title="Tampilkan semua barang">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Hidden input for supply_id -->
                    <input type="hidden" name="items[${rowIndex}][supply_id]" class="supply-id-input" required>
                    
                    <!-- Stock info badge under input -->
                    <div class="supply-stock-info mt-1" style="display: none;"></div>

                    <!-- Floating suggestions menu -->
                    <div class="supply-dropdown-menu"></div>
                </div>
            </div>

            <div class="col-md-3 col-8">
                <label class="form-label fw-semibold small mb-1">Jumlah (Qty) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" name="items[${rowIndex}][quantity]" class="form-control quantity-input" min="1" value="1" required placeholder="Jml">
                    <span class="input-group-text bg-light text-muted small unit-label">Unit</span>
                </div>
            </div>

            <div class="col-md-2 col-4 text-end">
                <label class="form-label small mb-1 d-block text-white opacity-0">&nbsp;</label>
                <button type="button" class="btn btn-outline-danger w-100 btn-remove-row" onclick="removeRow(${rowIndex})" title="Hapus baris ini">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                    </svg>
                    Hapus
                </button>
            </div>
        </div>
    `;

    itemsList.appendChild(newRow);
    initSupplyCombobox(newRow);
    rowIndex++;
    updateBadgesAndButtons();

    // Fokus langsung ke input baru
    var newInput = newRow.querySelector('.supply-search-input');
    if (newInput) newInput.focus();
}

/**
 * Hapus Baris
 */
function removeRow(id) {
    var rows = document.querySelectorAll('#itemsList .item-card');
    if (rows.length > 1) {
        var rowToRemove = document.getElementById('itemRow_' + id);
        if (rowToRemove) {
            rowToRemove.remove();
            updateBadgesAndButtons();
        }
    }
}

// Inisialisasi saat Halaman Selesai Dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi baris pertama (Row #0)
    var row0 = document.getElementById('itemRow_0');
    if (row0) {
        initSupplyCombobox(row0);
    }
    updateBadgesAndButtons();

    // Event tombol tambah baris (atas dan bawah)
    var btnAddTop = document.getElementById('btnAddRowTop');
    var btnAddBottom = document.getElementById('btnAddRowBottom');

    if (btnAddTop) {
        btnAddTop.addEventListener('click', function(e) {
            e.preventDefault();
            addNewRow();
        });
    }

    if (btnAddBottom) {
        btnAddBottom.addEventListener('click', function(e) {
            e.preventDefault();
            addNewRow();
        });
    }

    // Validasi Form sebelum submit
    var form = document.getElementById('formSupplies');
    if (form) {
        form.addEventListener('submit', function(e) {
            var rows = document.querySelectorAll('#itemsList .item-card');
            var invalidFound = false;

            rows.forEach(function(row, idx) {
                var idInput = row.querySelector('.supply-id-input');
                var searchInput = row.querySelector('.supply-search-input');

                if (!idInput || !idInput.value) {
                    invalidFound = true;
                    if (searchInput) {
                        searchInput.classList.add('is-invalid');
                        searchInput.focus();
                    }
                }
            });

            if (invalidFound) {
                e.preventDefault();
                alert('Silakan pilih barang yang valid dari daftar pilihan untuk setiap baris barang yang diajukan (contoh: ketik "Ker" lalu klik "Kertas A4").');
            }
        });
    }
});
</script>

<?= $this->endSection() ?>
