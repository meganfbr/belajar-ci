<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!-- Notifikasi Flashdata -->
<?php if (session()->getFlashData('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashData('failed')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php 
        if (is_array(session()->getFlashData('failed'))) {
            foreach (session()->getFlashData('failed') as $error) {
                echo $error . '<br>';
            }
        } else {
            echo session()->getFlashData('failed');
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Tombol Tambah & Search -->
<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addModal">
        Tambah Kategori
    </button>
    <div class="datatable-search">
        <input type="text" class="form-control" id="searchInput" placeholder="Cari kategori...">
    </div>
</div>

<!-- Tabel Produk Kategori -->
<table class="table datatable">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <!-- <th>Deskripsi</th>
            <th>Status</th> -->
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productcategory as $index => $kategori): ?>
            <tr>
                <th><?= $index + 1 ?></th>
                <td><?= esc($kategori['name']) ?></td>
                <!-- <td><?= esc($kategori['description'] ?? '-') ?></td> -->
                <!-- <td>
                    <span class="badge bg-<?= $kategori['is_active'] ? 'success' : 'danger' ?>">
                        <?= $kategori['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                    </span>
                </td> -->
                <td>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?= $kategori['id'] ?>">Ubah</button>
                        <a href="<?= base_url('product-category/delete/' . $kategori['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>
                    </div>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal-<?= $kategori['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('product-category/edit/' . $kategori['id']) ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div class="form-group mb-2">
                                    <label for="name">Nama Kategori</label>
                                    <input type="text" name="name" class="form-control" value="<?= esc($kategori['name']) ?>" required>
                                </div>
                                <!-- <div class="form-group mb-2">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3"><?= esc($kategori['description'] ?? '') ?></textarea>
                                </div> -->
                                <!-- <div class="form-group mb-2">
                                    <label for="is_active">Status</label>
                                    <select name="is_active" class="form-control" required>
                                        <option value="1" <?= $kategori['is_active'] ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= !$kategori['is_active'] ? 'selected' : '' ?>>Nonaktif</option>
                                    </select>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Edit Modal -->
        <?php endforeach ?>
    </tbody>
</table>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('product-category') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="name">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="is_active">Status</label>
                        <select name="is_active" class="form-control" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi pencarian sederhana
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('.datatable tbody tr');
    
    rows.forEach(row => {
        const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        if (name.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<?= $this->endSection() ?>