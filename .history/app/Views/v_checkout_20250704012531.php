<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-6">
        <?= form_open('buy', 'class="row g-3"') ?>
        <?= form_hidden('username', session()->get('username')) ?>
        <?= form_input(['type' => 'hidden', 'name' => 'total_harga', 'id' => 'total_harga', 'value' => '']) ?>

        <div class="col-12">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" value="<?= session()->get('username') ?>" readonly>
        </div>

        <div class="col-12">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>

        <div class="col-12">
            <label for="kelurahan" class="form-label">Kelurahan</label>
            <select class="form-control" id="kelurahan" name="kelurahan" required></select>
        </div>

        <div class="col-12">
            <label for="layanan" class="form-label">Layanan Pengiriman</label>
            <select class="form-control" id="layanan" name="layanan" required></select>
        </div>

        <div class="col-12">
            <label for="ongkir" class="form-label">Ongkir</label>
            <input type="text" class="form-control" id="ongkir" name="ongkir" readonly>
        </div>
    </div>

    <div class="col-lg-6">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_asli = 0;
                $diskon = session()->get('diskon_nominal') ?? 0;

                if (!empty($items)) :
                    foreach ($items as $item) :
                        $subtotal = $item['price'] * $item['qty'];
                        $total_asli += $subtotal;
                ?>
                        <tr>
                            <td><?= esc($item['name']) ?></td>
                            <td><?= number_to_currency($item['price'], 'IDR') ?></td>
                            <td><?= esc($item['qty']) ?></td>
                            <td><?= number_to_currency($subtotal, 'IDR') ?></td>
                        </tr>
                <?php endforeach; endif; ?>
                <tr>
                    <td colspan="3"><strong>Subtotal</strong></td>
                    <td><?= number_to_currency($total, 'IDR') ?></td>
                </tr>
                <?php if ($diskon > 0): ?>
                <tr>
                    <td colspan="3"><strong>Diskon</strong></td>
                    <td>-<?= number_to_currency($diskon, 'IDR') ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="3"><strong>Ongkir</strong></td>
                    <td><span id="tampil_ongkir">IDR 0</span></td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Total Bayar</strong></td>
                    <td><span id="total"><?= number_to_currency($total, 'IDR') ?></span></td>
                </tr>
            </tbody>
        </table>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Buat Pesanan</button>
        </div>

        <?= form_close() ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function () {
    var ongkir = 0;
    var subtotal = <?= $total ?>;
    var diskon = <?= $diskon ?>;

    hitungTotal();

    $('#kelurahan').select2({
        placeholder: 'Ketik nama kelurahan...',
        ajax: {
            url: '<?= base_url('get-location') ?>',
            dataType: 'json',
            delay: 1000,
            data: function (params) {
                return { search: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.subdistrict_name + ', ' + item.district_name + ', ' + item.city_name
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 3
    });

    $("#kelurahan").on('change', function () {
        var id_kelurahan = $(this).val();
        $("#layanan").empty();
        ongkir = 0;

        $.ajax({
            url: "<?= site_url('get-cost') ?>",
            type: 'GET',
            data: { destination: id_kelurahan },
            dataType: 'json',
            success: function (data) {
                data.forEach(function (item) {
                    var text = item.description + " (" + item.service + ") estimasi " + item.etd;
                    $("#layanan").append($('<option>', {
                        value: item.cost,
                        text: text
                    }));
                });
            }
        });
    });

    $("#layanan").on('change', function () {
        ongkir = parseInt($(this).val());
        hitungTotal();
    });

    function hitungTotal() {
        var totalBayar = Math.max(0, subtotal - diskon + ongkir);
        $("#ongkir").val(ongkir);
        $("#tampil_ongkir").html("IDR " + ongkir.toLocaleString('id-ID'));
        $("#total").html("IDR " + totalBayar.toLocaleString('id-ID'));
        $("#total_harga").val(totalBayar);
    }
});
</script>
<?= $this->endSection() ?>
