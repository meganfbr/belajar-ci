<h5>Detail Transaksi #<?= $transaksi['id'] ?></h5>
<table class="table">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Diskon</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($details as $item): ?>
        <tr>
            <td><?= esc($item['product_id']) ?></td>
            <td><?= esc($item['jumlah']) ?></td>
            <td><?= number_format($item['subtotal_harga']) ?></td>
            <td><?= number_format($item['diskon']) ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
