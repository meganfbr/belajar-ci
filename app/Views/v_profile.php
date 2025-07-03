<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h2>History Transaksi Pembelian <strong><?= esc($username) ?></strong></h2>
<hr>

<div class="table-responsive">
    <table class="table datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Pembelian</th>
                <th>Waktu Pembelian</th>
                <th>Total Bayar</th>
                <th>Alamat</th>
                <th>Status</th>
                <th></th>
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
                                    <h5 class="modal-title">Detail Transaksi #<?= esc($item['id']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (!empty($product) && isset($product[$item['id']])) : ?>
                                        <?php foreach ($product[$item['id']] as $index2 => $item2) : ?>
                                            <div class="product-item mb-3">
                                                <div class="product-index">
                                                    <strong><?= esc($index2 + 1) . ")" ?></strong>
                                                </div>

                                                <?php
                                                $foto = $item2['foto'] ?? '';
                                                $fotoPath = FCPATH . 'img/' . $foto;
                                                ?>

                                                <?php if (!empty($foto) && file_exists($fotoPath)) : ?>
                                                    <div class="product-image mb-2">
                                                        <img src="<?= base_url('img/' . esc($foto)) ?>" width="100px" alt="<?= esc($item2['nama']) ?>" />
                                                    </div>
                                                <?php else : ?>
                                                    <p><em>Gambar tidak tersedia</em></p>
                                                <?php endif; ?>

                                                <div class="product-details">
                                                    <div><strong><?= esc($item2['nama']) ?></strong></div>
                                                    <div><?= number_to_currency($item2['harga'], 'IDR') ?> (<?= esc($item2['jumlah']) ?> pcs)</div>

                                                    <?php
                                                        $harga = $item2['harga'];
                                                        $jumlah = $item2['jumlah'];
                                                        $diskon = $item2['diskon'] ?? 0;
                                                        $subtotal = ($harga - $diskon) * $jumlah;
                                                    ?>
                                                    <div>Subtotal: <?= number_to_currency($subtotal, 'IDR') ?></div>
                                                </div>

                                                <hr class="product-divider" />
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p>Tidak ada produk untuk transaksi ini.</p>
                                    <?php endif; ?>

                                    <p><strong>Ongkir:</strong> <?= number_to_currency($item['ongkir'] ?? 0, 'IDR') ?></p>
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
</div>

<?= $this->endSection() ?>
