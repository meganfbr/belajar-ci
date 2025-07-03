<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row">
    <?php foreach ($produk as $item): ?>
        <div class="col-md-4 mb-4">
            <!-- Form Beli -->
            <?= form_open('keranjang/add') ?>
            <?= form_hidden('id', $item['id']) ?>
            <?= form_hidden('nama', $item['nama']) ?>
            <?= form_hidden('harga', $item['harga']) ?>
            <?= form_hidden('foto', $item['foto']) ?>
            
            <div class="card h-100">
                <img src="<?= base_url('img/' . $item['foto']) ?>" class="card-img-top" alt="<?= esc($item['nama']) ?>" style="height: 250px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= esc($item['nama']) ?></h5>
                    <p class="card-text text-primary fw-bold"><?= number_to_currency($item['harga'], 'IDR') ?></p>
                    <div class="mt-auto">
                        <button type="submit" class="btn btn-info w-100">Beli</button>
                    </div>
                </div>
            </div>

            <?= form_close() ?>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
