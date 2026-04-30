<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Blog (CMS)</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --primary: #1e3a5f;
    --primary-light: #2d5a9e;
    --accent: #3b82f6;
    --accent-hover: #2563eb;
    --danger: #ef4444;
    --danger-hover: #dc2626;
    --success: #22c55e;
    --bg: #f0f4f8;
    --sidebar-bg: #1e3a5f;
    --card-bg: #ffffff;
    --text: #1e293b;
    --text-muted: #64748b;
    --border: #e2e8f0;
    --shadow: 0 2px 12px rgba(0,0,0,.08);
    --radius: 10px;
  }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  /* HEADER */
  header {
    background: var(--primary);
    color: #fff;
    padding: 0 28px;
    height: 60px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.2);
    position: sticky;
    top: 0;
    z-index: 100;
  }
  header svg { flex-shrink: 0; }
  header .brand { font-size: 1.05rem; font-weight: 700; letter-spacing: -.2px; }
  header .sub   { font-size: .75rem; color: #93c5fd; font-weight: 400; margin-top: 1px; }

  /* LAYOUT */
  .layout {
    display: flex;
    flex: 1;
    min-height: calc(100vh - 60px);
  }

  /* SIDEBAR */
  aside {
    width: 220px;
    background: var(--sidebar-bg);
    padding: 24px 0;
    flex-shrink: 0;
  }
  .nav-label {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #93c5fd;
    padding: 0 20px 10px;
  }
  .nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 20px;
    color: #cbd5e1;
    cursor: pointer;
    font-size: .875rem;
    font-weight: 500;
    transition: background .15s, color .15s;
    border-left: 3px solid transparent;
  }
  .nav-item:hover  { background: rgba(255,255,255,.07); color: #fff; }
  .nav-item.active { background: rgba(59,130,246,.25); color: #93c5fd; border-left-color: #3b82f6; }

  /* CONTENT */
  main {
    flex: 1;
    padding: 28px;
    overflow-y: auto;
  }

  /* CARD */
  .card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 24px;
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  .card-header h2 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text);
  }

  /* TABLE */
  table {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
  }
  thead tr { border-bottom: 2px solid var(--border); }
  thead th {
    text-align: left;
    padding: 10px 14px;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--text-muted);
  }
  tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
  tbody tr:hover { background: #f8fafc; }
  tbody td { padding: 12px 14px; vertical-align: middle; }

  .foto-thumb {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--border);
    background: #e2e8f0;
  }

  .badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 600;
    background: #dbeafe;
    color: #1d4ed8;
  }

  .pw-mask { font-family: monospace; color: var(--text-muted); font-size: .8rem; }

  /* BUTTONS */
  .btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border: none;
    border-radius: 7px;
    font-family: inherit;
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s, transform .1s;
  }
  .btn:active { transform: scale(.97); }
  .btn-primary  { background: var(--accent);  color: #fff; }
  .btn-primary:hover  { background: var(--accent-hover); }
  .btn-danger   { background: var(--danger);  color: #fff; }
  .btn-danger:hover   { background: var(--danger-hover); }
  .btn-secondary { background: #e2e8f0; color: var(--text); }
  .btn-secondary:hover { background: #cbd5e1; }
  .btn-sm { padding: 5px 12px; font-size: .78rem; }

  /* MODAL */
  .modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 500;
    backdrop-filter: blur(3px);
  }
  .modal-overlay.show { display: flex; }

  .modal {
    background: #fff;
    border-radius: 14px;
    padding: 28px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,.3);
    animation: slideUp .2s ease;
  }
  @keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
  }
  .modal h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; }

  /* FORM */
  .form-row { display: flex; gap: 14px; }
  .form-row .form-group { flex: 1; }

  .form-group { margin-bottom: 16px; }
  .form-group label {
    display: block;
    font-size: .8rem;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 6px;
  }
  .form-group input,
  .form-group select,
  .form-group textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    font-family: inherit;
    font-size: .875rem;
    color: var(--text);
    outline: none;
    transition: border .15s;
    background: #f8fafc;
  }
  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
    border-color: var(--accent);
    background: #fff;
  }
  .form-group textarea { resize: vertical; min-height: 90px; }

  .form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 8px;
  }

  /* CONFIRM MODAL */
  .confirm-modal {
    text-align: center;
    max-width: 360px;
  }
  .confirm-modal .icon-trash {
    width: 52px; height: 52px;
    background: #fee2e2;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    color: var(--danger);
  }
  .confirm-modal h3 { font-size: 1rem; margin-bottom: 6px; }
  .confirm-modal p  { font-size: .85rem; color: var(--text-muted); margin-bottom: 20px; }

  /* TOAST */
  #toast {
    position: fixed;
    bottom: 28px; right: 28px;
    background: #1e293b;
    color: #fff;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: .875rem;
    font-weight: 500;
    box-shadow: 0 8px 24px rgba(0,0,0,.2);
    transform: translateY(80px);
    opacity: 0;
    transition: all .3s ease;
    z-index: 9999;
    max-width: 320px;
  }
  #toast.show { transform: translateY(0); opacity: 1; }
  #toast.success { border-left: 4px solid var(--success); }
  #toast.error   { border-left: 4px solid var(--danger);  }

  .empty-state {
    text-align: center;
    padding: 48px 20px;
    color: var(--text-muted);
    font-size: .9rem;
  }

  .spinner {
    border: 3px solid #e2e8f0;
    border-top-color: var(--accent);
    border-radius: 50%;
    width: 28px; height: 28px;
    animation: spin .7s linear infinite;
    margin: 40px auto;
  }
  @keyframes spin { to { transform: rotate(360deg); } }
</style>
</head>
<body>

<!-- HEADER -->
<header>
  <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
  </svg>
  <div>
    <div class="brand">Sistem Manajemen Blog (CMS)</div>
    <div class="sub">Blog Kami</div>
  </div>
</header>

<div class="layout">
  <!-- SIDEBAR -->
  <aside>
    <div class="nav-label">Menu Utama</div>
    <div class="nav-item active" onclick="gotoMenu('penulis', this)">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Kelola Penulis
    </div>
    <div class="nav-item" onclick="gotoMenu('artikel', this)">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
      Kelola Artikel
    </div>
    <div class="nav-item" onclick="gotoMenu('kategori', this)">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Kelola Kategori
    </div>
  </aside>

  <!-- MAIN -->
  <main id="main-content">
    <!-- Content will be rendered here -->
  </main>
</div>

<!-- ============================
     MODAL: TAMBAH PENULIS
============================= -->
<div class="modal-overlay" id="modal-tambah-penulis">
  <div class="modal">
    <h3>Tambah Penulis</h3>
    <form id="form-tambah-penulis" enctype="multipart/form-data">
      <div class="form-row">
        <div class="form-group">
          <label>Nama Depan</label>
          <input type="text" name="nama_depan" placeholder="Ahmad" required>
        </div>
        <div class="form-group">
          <label>Nama Belakang</label>
          <input type="text" name="nama_belakang" placeholder="Fauzi" required>
        </div>
      </div>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="user_name" placeholder="ahmad_f" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label>Foto Profil</label>
        <input type="file" name="foto" accept="image/*">
      </div>
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupModal('modal-tambah-penulis')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: EDIT PENULIS -->
<div class="modal-overlay" id="modal-edit-penulis">
  <div class="modal">
    <h3>Edit Penulis</h3>
    <form id="form-edit-penulis" enctype="multipart/form-data">
      <input type="hidden" name="id" id="edit-penulis-id">
      <div class="form-row">
        <div class="form-group">
          <label>Nama Depan</label>
          <input type="text" name="nama_depan" id="edit-penulis-depan" required>
        </div>
        <div class="form-group">
          <label>Nama Belakang</label>
          <input type="text" name="nama_belakang" id="edit-penulis-belakang" required>
        </div>
      </div>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="user_name" id="edit-penulis-username" required>
      </div>
      <div class="form-group">
        <label>Password Baru <small style="font-weight:400">(kosongkan jika tidak diganti)</small></label>
        <input type="password" name="password" placeholder="••••••••••••">
      </div>
      <div class="form-group">
        <label>Foto Profil <small style="font-weight:400">(kosongkan jika tidak diganti)</small></label>
        <input type="file" name="foto" accept="image/*">
      </div>
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupModal('modal-edit-penulis')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: TAMBAH KATEGORI -->
<div class="modal-overlay" id="modal-tambah-kategori">
  <div class="modal">
    <h3>Tambah Kategori</h3>
    <form id="form-tambah-kategori">
      <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" placeholder="Nama kategori..." required>
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" placeholder="Deskripsi kategori..."></textarea>
      </div>
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupModal('modal-tambah-kategori')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: EDIT KATEGORI -->
<div class="modal-overlay" id="modal-edit-kategori">
  <div class="modal">
    <h3>Edit Kategori</h3>
    <form id="form-edit-kategori">
      <input type="hidden" name="id" id="edit-kategori-id">
      <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" id="edit-kategori-nama" required>
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" id="edit-kategori-ket"></textarea>
      </div>
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupModal('modal-edit-kategori')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: TAMBAH ARTIKEL -->
<div class="modal-overlay" id="modal-tambah-artikel">
  <div class="modal" style="max-width:560px">
    <h3>Tambah Artikel</h3>
    <form id="form-tambah-artikel" enctype="multipart/form-data">
      <div class="form-group">
        <label>Judul</label>
        <input type="text" name="judul" placeholder="Judul artikel..." required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Penulis</label>
          <select name="id_penulis" id="select-penulis-tambah" required></select>
        </div>
        <div class="form-group">
          <label>Kategori</label>
          <select name="id_kategori" id="select-kategori-tambah" required></select>
        </div>
      </div>
      <div class="form-group">
        <label>Isi Artikel</label>
        <textarea name="isi" placeholder="Tulis isi artikel di sini..." required style="min-height:120px"></textarea>
      </div>
      <div class="form-group">
        <label>Gambar</label>
        <input type="file" name="gambar" accept="image/*" required>
      </div>
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupModal('modal-tambah-artikel')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: EDIT ARTIKEL -->
<div class="modal-overlay" id="modal-edit-artikel">
  <div class="modal" style="max-width:560px">
    <h3>Edit Artikel</h3>
    <form id="form-edit-artikel" enctype="multipart/form-data">
      <input type="hidden" name="id" id="edit-artikel-id">
      <div class="form-group">
        <label>Judul</label>
        <input type="text" name="judul" id="edit-artikel-judul" required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Penulis</label>
          <select name="id_penulis" id="select-penulis-edit" required></select>
        </div>
        <div class="form-group">
          <label>Kategori</label>
          <select name="id_kategori" id="select-kategori-edit" required></select>
        </div>
      </div>
      <div class="form-group">
        <label>Isi Artikel</label>
        <textarea name="isi" id="edit-artikel-isi" required style="min-height:120px"></textarea>
      </div>
      <div class="form-group">
        <label>Gambar <small style="font-weight:400">(kosongkan jika tidak diganti)</small></label>
        <input type="file" name="gambar" accept="image/*">
      </div>
      <div class="form-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupModal('modal-edit-artikel')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: KONFIRMASI HAPUS -->
<div class="modal-overlay" id="modal-hapus">
  <div class="modal confirm-modal">
    <div class="icon-trash">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
    </div>
    <h3>Hapus data ini?</h3>
    <p>Data yang dihapus tidak dapat dikembalikan.</p>
    <div class="form-actions" style="justify-content:center">
      <button class="btn btn-secondary" onclick="tutupModal('modal-hapus')">Batal</button>
      <button class="btn btn-danger" id="btn-konfirmasi-hapus">Ya, Hapus</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast"></div>

<script>
// ============================
// UTILITIES
// ============================
let currentMenu = 'penulis';

function showToast(msg, type = 'success') {
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.className = 'show ' + type;
  clearTimeout(t._timer);
  t._timer = setTimeout(() => { t.className = ''; }, 3500);
}

function bukaModal(id) {
  document.getElementById(id).classList.add('show');
}
function tutupModal(id) {
  document.getElementById(id).classList.remove('show');
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(el => {
  el.addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('show');
  });
});

function setLoading(container) {
  container.innerHTML = '<div class="spinner"></div>';
}

function gotoMenu(menu, el) {
  currentMenu = menu;
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  el.classList.add('active');
  renderMenu(menu);
}

function renderMenu(menu) {
  if (menu === 'penulis')   renderPenulis();
  if (menu === 'artikel')   renderArtikel();
  if (menu === 'kategori')  renderKategori();
}

// ============================
// PENULIS
// ============================
function renderPenulis() {
  const main = document.getElementById('main-content');
  main.innerHTML = `
    <div class="card">
      <div class="card-header">
        <h2>Data Penulis</h2>
        <button class="btn btn-primary btn-sm" onclick="bukaModal('modal-tambah-penulis'); document.getElementById('form-tambah-penulis').reset()">
          + Tambah Penulis
        </button>
      </div>
      <div id="tabel-penulis"><div class="spinner"></div></div>
    </div>`;
  muatPenulis();
}

function muatPenulis() {
  fetch('ambil_penulis.php')
    .then(r => r.json())
    .then(res => {
      const el = document.getElementById('tabel-penulis');
      if (!el) return;
      if (!res.data || res.data.length === 0) {
        el.innerHTML = '<div class="empty-state">Belum ada data penulis.</div>';
        return;
      }
      let rows = res.data.map(p => `
        <tr>
          <td><img src="uploads_penulis/${escHtml(p.foto)}" class="foto-thumb" onerror="this.src='uploads_penulis/default.png'"></td>
          <td>${escHtml(p.nama_depan)} ${escHtml(p.nama_belakang)}</td>
          <td>${escHtml(p.user_name)}</td>
          <td><span class="pw-mask">${escHtml(p.password.substring(0,20))}…</span></td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="editPenulis(${p.id})">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="hapusKonfirmasi('penulis', ${p.id})">Hapus</button>
          </td>
        </tr>`).join('');
      el.innerHTML = `
        <table>
          <thead><tr><th>Foto</th><th>Nama</th><th>Username</th><th>Password</th><th>Aksi</th></tr></thead>
          <tbody>${rows}</tbody>
        </table>`;
    });
}

document.getElementById('form-tambah-penulis').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('simpan_penulis.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') {
        tutupModal('modal-tambah-penulis');
        this.reset();
        muatPenulis();
      }
    });
});

function editPenulis(id) {
  fetch('ambil_satu_penulis.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (res.status !== 'ok') { showToast(res.pesan, 'error'); return; }
      const d = res.data;
      document.getElementById('edit-penulis-id').value       = d.id;
      document.getElementById('edit-penulis-depan').value    = d.nama_depan;
      document.getElementById('edit-penulis-belakang').value = d.nama_belakang;
      document.getElementById('edit-penulis-username').value = d.user_name;
      document.querySelector('#form-edit-penulis input[name="password"]').value = '';
      document.querySelector('#form-edit-penulis input[name="foto"]').value = '';
      bukaModal('modal-edit-penulis');
    });
}

document.getElementById('form-edit-penulis').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('update_penulis.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') {
        tutupModal('modal-edit-penulis');
        muatPenulis();
      }
    });
});

// ============================
// KATEGORI
// ============================
function renderKategori() {
  const main = document.getElementById('main-content');
  main.innerHTML = `
    <div class="card">
      <div class="card-header">
        <h2>Data Kategori Artikel</h2>
        <button class="btn btn-primary btn-sm" onclick="bukaModal('modal-tambah-kategori'); document.getElementById('form-tambah-kategori').reset()">
          + Tambah Kategori
        </button>
      </div>
      <div id="tabel-kategori"><div class="spinner"></div></div>
    </div>`;
  muatKategori();
}

function muatKategori() {
  fetch('ambil_kategori.php')
    .then(r => r.json())
    .then(res => {
      const el = document.getElementById('tabel-kategori');
      if (!el) return;
      if (!res.data || res.data.length === 0) {
        el.innerHTML = '<div class="empty-state">Belum ada data kategori.</div>';
        return;
      }
      let rows = res.data.map(k => `
        <tr>
          <td><span class="badge">${escHtml(k.nama_kategori)}</span></td>
          <td>${escHtml(k.keterangan || '-')}</td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="editKategori(${k.id})">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="hapusKonfirmasi('kategori', ${k.id})">Hapus</button>
          </td>
        </tr>`).join('');
      el.innerHTML = `
        <table>
          <thead><tr><th>Nama Kategori</th><th>Keterangan</th><th>Aksi</th></tr></thead>
          <tbody>${rows}</tbody>
        </table>`;
    });
}

document.getElementById('form-tambah-kategori').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('simpan_kategori.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') {
        tutupModal('modal-tambah-kategori');
        this.reset();
        muatKategori();
      }
    });
});

function editKategori(id) {
  fetch('ambil_satu_kategori.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (res.status !== 'ok') { showToast(res.pesan, 'error'); return; }
      const d = res.data;
      document.getElementById('edit-kategori-id').value  = d.id;
      document.getElementById('edit-kategori-nama').value = d.nama_kategori;
      document.getElementById('edit-kategori-ket').value  = d.keterangan || '';
      bukaModal('modal-edit-kategori');
    });
}

document.getElementById('form-edit-kategori').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('update_kategori.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') {
        tutupModal('modal-edit-kategori');
        muatKategori();
      }
    });
});

// ============================
// ARTIKEL
// ============================
function renderArtikel() {
  const main = document.getElementById('main-content');
  main.innerHTML = `
    <div class="card">
      <div class="card-header">
        <h2>Data Artikel</h2>
        <button class="btn btn-primary btn-sm" onclick="bukaModalTambahArtikel()">
          + Tambah Artikel
        </button>
      </div>
      <div id="tabel-artikel"><div class="spinner"></div></div>
    </div>`;
  muatArtikel();
}

function muatArtikel() {
  fetch('ambil_artikel.php')
    .then(r => r.json())
    .then(res => {
      const el = document.getElementById('tabel-artikel');
      if (!el) return;
      if (!res.data || res.data.length === 0) {
        el.innerHTML = '<div class="empty-state">Belum ada data artikel.</div>';
        return;
      }
      let rows = res.data.map(a => `
        <tr>
          <td><img src="uploads_artikel/${escHtml(a.gambar)}" class="foto-thumb" style="border-radius:6px"></td>
          <td style="max-width:200px;font-weight:600">${escHtml(a.judul)}</td>
          <td><span class="badge">${escHtml(a.nama_kategori)}</span></td>
          <td>${escHtml(a.nama_penulis)}</td>
          <td style="font-size:.78rem;color:var(--text-muted)">${escHtml(a.hari_tanggal)}</td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="editArtikel(${a.id})">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="hapusKonfirmasi('artikel', ${a.id})">Hapus</button>
          </td>
        </tr>`).join('');
      el.innerHTML = `
        <table>
          <thead><tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th></tr></thead>
          <tbody>${rows}</tbody>
        </table>`;
    });
}

function isiDropdown(selectEl, data, valueKey, labelKey, selectedId = null) {
  selectEl.innerHTML = data.map(d =>
    `<option value="${d[valueKey]}" ${d[valueKey] == selectedId ? 'selected' : ''}>${escHtml(d[labelKey])}</option>`
  ).join('');
}

function bukaModalTambahArtikel() {
  document.getElementById('form-tambah-artikel').reset();
  // Isi dropdown penulis dan kategori
  Promise.all([
    fetch('ambil_penulis.php').then(r => r.json()),
    fetch('ambil_kategori.php').then(r => r.json())
  ]).then(([rPenulis, rKategori]) => {
    isiDropdown(document.getElementById('select-penulis-tambah'), rPenulis.data || [], 'id', 'nama_depan');
    // Nama lengkap untuk penulis
    const selP = document.getElementById('select-penulis-tambah');
    selP.innerHTML = (rPenulis.data || []).map(p =>
      `<option value="${p.id}">${escHtml(p.nama_depan + ' ' + p.nama_belakang)}</option>`
    ).join('');
    isiDropdown(document.getElementById('select-kategori-tambah'), rKategori.data || [], 'id', 'nama_kategori');
    bukaModal('modal-tambah-artikel');
  });
}

document.getElementById('form-tambah-artikel').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('simpan_artikel.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') {
        tutupModal('modal-tambah-artikel');
        this.reset();
        muatArtikel();
      }
    });
});

function editArtikel(id) {
  Promise.all([
    fetch('ambil_satu_artikel.php?id=' + id).then(r => r.json()),
    fetch('ambil_penulis.php').then(r => r.json()),
    fetch('ambil_kategori.php').then(r => r.json())
  ]).then(([rArtikel, rPenulis, rKategori]) => {
    if (rArtikel.status !== 'ok') { showToast(rArtikel.pesan, 'error'); return; }
    const d = rArtikel.data;
    document.getElementById('edit-artikel-id').value    = d.id;
    document.getElementById('edit-artikel-judul').value = d.judul;
    document.getElementById('edit-artikel-isi').value   = d.isi;
    document.querySelector('#form-edit-artikel input[name="gambar"]').value = '';

    const selP = document.getElementById('select-penulis-edit');
    selP.innerHTML = (rPenulis.data || []).map(p =>
      `<option value="${p.id}" ${p.id == d.id_penulis ? 'selected' : ''}>${escHtml(p.nama_depan + ' ' + p.nama_belakang)}</option>`
    ).join('');

    const selK = document.getElementById('select-kategori-edit');
    selK.innerHTML = (rKategori.data || []).map(k =>
      `<option value="${k.id}" ${k.id == d.id_kategori ? 'selected' : ''}>${escHtml(k.nama_kategori)}</option>`
    ).join('');

    bukaModal('modal-edit-artikel');
  });
}

document.getElementById('form-edit-artikel').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('update_artikel.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
      if (res.status === 'ok') {
        tutupModal('modal-edit-artikel');
        muatArtikel();
      }
    });
});

// ============================
// KONFIRMASI HAPUS
// ============================
function hapusKonfirmasi(tipe, id) {
  bukaModal('modal-hapus');
  document.getElementById('btn-konfirmasi-hapus').onclick = function() {
    let url = '';
    if (tipe === 'penulis')  url = 'hapus_penulis.php';
    if (tipe === 'kategori') url = 'hapus_kategori.php';
    if (tipe === 'artikel')  url = 'hapus_artikel.php';

    const fd = new FormData();
    fd.append('id', id);

    fetch(url, { method: 'POST', body: fd })
      .then(r => r.json())
      .then(res => {
        tutupModal('modal-hapus');
        showToast(res.pesan, res.status === 'ok' ? 'success' : 'error');
        if (res.status === 'ok') renderMenu(currentMenu);
      });
  };
}

// ============================
// XSS PROTECTION
// ============================
function escHtml(str) {
  if (str === null || str === undefined) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

// ============================
// INIT
// ============================
renderPenulis();
</script>
</body>
</html>
