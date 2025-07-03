<?php helper('number'); ?>
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashData('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Tabel Keranjang -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        if (!empty($cartItems)) :
            foreach ($cartItems as $item):
                $subtotal = $item['subtotal'];
                $total += $subtotal;
        ?>
            <tr>
                <td><?= esc($item['name']) ?></td>
                <td>Rp<?= number_format($item['price']) ?>
                    <?php if (!empty($item['options']['diskon'])): ?>
                        <br><small class="text-danger">Diskon: -Rp<?= number_format($item['options']['diskon']) ?></small>
                    <?php endif; ?>
                </td>
                <td><?= $item['qty'] ?></td>
                <td>Rp<?= number_format($subtotal) ?></td>
            </tr>
        <?php
            endforeach;
        else:
        ?>
            <tr><td colspan="4" class="text-center">Keranjang kosong</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
$diskon = session()->get('diskon_nominal') ?? 0;
$total_setelah_diskon = max(0, $total - $diskon);
?>

<div class="alert alert-warning">
    <strong>Total Sebelum Diskon:</strong> Rp<?= number_format($total) ?><br>
    <strong>Diskon:</strong> -Rp<?= number_format($diskon) ?><br>
    <strong>Total Setelah Diskon:</strong> Rp<?= number_format($total_setelah_diskon) ?>
</div>

<!-- Tombol Aksi -->
<div class="mb-3">
    <a class="btn btn-warning" href="<?= base_url('keranjang/clear') ?>">Kosongkan Keranjang</a>
    <?php if (!empty($cartItems)) : ?>
        <a class="btn btn-success" href="<?= base_url('checkout') ?>">Selesai Belanja</a>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
