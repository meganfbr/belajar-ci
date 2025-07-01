<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h2>History Transaksi Pembelian <strong><?= esc($username) ?></strong></h2>
<hr>

<div class="table-responsive">
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Pembelian</th>
                <th scope="col">Waktu Pembelian</th>
                <th scope="col">Total Bayar</th>
                <th scope="col">Alamat</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($buy)) : ?>
                <?php foreach ($buy as $index => $item) : ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= esc($item['id']) ?></td>
                        <td><?= esc($item['created_at']) ?></td>
                        <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?= esc($item['alamat']) ?></td>
                        <td><?= $item['status'] == "1" ? "Sudah Selesai" : "Belum Selesai" ?></td>
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal-<?= esc($item['id']) ?>">
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Begin -->
                    <div class="modal fade" id="detailModal-<?= esc($item['id']) ?>" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel">Detail Transaksi #<?= esc($item['id']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (!empty($product) && isset($product[$item['id']])) : ?>
                                        <?php foreach ($product[$item['id']] as $index2 => $item2) : ?>
                                            <div class="product-item">
                                                <div class="product-index">
                                                    <strong><?= esc($index2 + 1) . ")" ?></strong>
                                                </div>

                                                <!-- Cek apakah foto produk ada -->
                                                <?php if (!empty($item2['foto']) && file_exists("img/" . $item2['foto'])) : ?>
                                                    <div class="product-image">
                                                        <img src="<?= base_url("img/" . esc($item2['foto'])) ?>" width="100px" alt="<?= esc($item2['nama']) ?>" />
                                                    </div>
                                                <?php endif; ?>

                                                <div class="product-details">
                                                    <div class="product-name">
                                                        <strong><?= esc($item2['nama']) ?></strong>
                                                    </div>
                                                    <div class="product-price">
                                                        <?= number_to_currency($item2['harga'], 'IDR') ?>
                                                    </div>
                                                    <div class="product-quantity">
                                                        <?= "(" . esc($item2['jumlah']) . " pcs)" ?>
                                                    </div>
                                                    <div class="product-subtotal">
                                                        <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                                    </div>
                                                </div>

                                                <hr class="product-divider" />
                                            </div>

                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p>Tidak ada produk untuk transaksi ini.</p>
                                    <?php endif; ?>

                                    <!-- Penanganan Ongkir -->
                                    <?php 
                                    $ongkir = isset($item['ongkir']) ? $item['ongkir'] : 0;
                                    ?>
                                    <p><strong>Ongkir:</strong> <?= number_to_currency($ongkir, 'IDR') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal End -->

                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- End Table with stripped rows -->
</div>

<?= $this->endSection() ?>
