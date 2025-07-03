<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?= form_open('keranjang/edit') ?>

<!-- Tabel Keranjang -->
<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">Nama</th>
            <th scope="col">Foto</th>
            <th scope="col">Harga</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $total_asli = 0;

        if (!empty($items)) :
            foreach ($items as $item) :
                $harga_asli = $item['options']['harga_asli'] ?? $item['price'];
                $subtotal_asli = $harga_asli * $item['qty'];
                $total_asli += $subtotal_asli;

                // Ambil nama file foto dari options
                $foto = $item['options']['foto'] ?? null;
        ?>
                <tr>
                    <td><?= esc($item['name']) ?></td>
                    <td>
                        <?php if (!empty($foto)) : ?>
                            <img src="<?= base_url("img/" . esc($foto)) ?>" width="100px" alt="<?= esc($item['name']) ?>">
                        <?php else : ?>
                            <span class="text-muted">Tidak ada gambar</span>
                        <?php endif; ?>
                    </td>
                    <td><?= number_to_currency($item['price'], 'IDR') ?></td>
                    <td>
                        <input type="number" min="1" name="qty<?= $i++ ?>" class="form-control" value="<?= esc($item['qty']) ?>">
                    </td>
                    <td><?= number_to_currency($item['subtotal'], 'IDR') ?></td>
                    <td>
                        <a href="<?= base_url('keranjang/delete/' . $item['rowid']) ?>" class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
        <?php
            endforeach;
        endif;
        ?>
    </tbody>
</table>

<!-- Informasi Total -->
<?php
$diskon = session()->get('diskon_nominal') ?? 0;
$total_setelah_diskon = max(0, $total - $diskon);
?>

<div class="alert alert-warning">
    <strong>Total Sebelum Diskon:</strong> <?= number_to_currency($total, 'IDR') ?><br>
    <strong>Diskon:</strong> -<?= number_to_currency($diskon, 'IDR') ?><br>
    <strong>Total Setelah Diskon:</strong> <?= number_to_currency($total_setelah_diskon, 'IDR') ?>
</div>

<!-- Tombol Aksi -->
<div class="mb-3">
    <button type="submit" class="btn btn-primary">Perbarui Keranjang</button>
    <a class="btn btn-warning" href="<?= base_url('keranjang/clear') ?>">Kosongkan Keranjang</a>
    <?php if (!empty($items)) : ?>
        <a class="btn btn-success" href="<?= base_url('checkout') ?>">Selesai Belanja</a>
    <?php endif; ?>
</div>

<?= form_close() ?>
<?= $this->endSection() ?>
