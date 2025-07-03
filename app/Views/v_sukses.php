<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="alert alert-success text-center">
    <h2>🎉 Terima kasih!</h2>
    <p>Transaksi Anda berhasil. Kami akan segera memproses pesanan Anda.</p>
    <a href="<?= base_url('/') ?>" class="btn btn-primary">Kembali ke Beranda</a>
</div>

<?= $this->endSection() ?>
