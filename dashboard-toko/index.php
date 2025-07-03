<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body>
    <?php 
    function curl(){ 
        $curl = curl_init(); 
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost:8080/api",
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: fNqM2Iw4183c28482a1f26a7CCol0IkT",
            ),
        ));
            
        $output = curl_exec($curl); 	
        curl_close($curl);      
        
        $data = json_decode($output);   
        
        return $data;
    } 

    //test webservice
    //$send1 = curl();
    //echo "<pre>";
    //print_r($send1);
    //echo "</pre>"; 
    
    ?>
    <div class="p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Dashboard - TOKO</h1>
        <p class="fs-5 text-body-secondary"><?= date("l, d-m-Y") ?> <span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span></p>
    </div> 
    <hr>
    <div class="table-responsive card m-5 p-5">
    <table cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Alamat</th>
                <th>Total Harga</th>
                <th>Ongkir</th>
                <th>Jumlah Item</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $data = curl(); // panggil fungsi curl() di sini agar $data terdefinisi
            if (!empty($data->results) && is_array($data->results)): 
            ?>
                <?php foreach ($data->results as $key => $row): ?>
                    <?php 
                        $jumlah_item = (isset($row->details) && is_array($row->details)) ? count($row->details) : 0;
                        $status = (isset($row->status) && $row->status == 1) ? 'Selesai' : 'Belum Selesai';
                    ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $row->username ?? '-' ?></td>
                        <td><?= $row->alamat ?? '-' ?></td>
                        <td><?= number_format($row->total_harga ?? 0) ?></td>
                        <td><?= number_format($row->ongkir ?? 0) ?></td>
                        <td><?= $jumlah_item ?></td>
                        <td><?= $status ?></td>
                        <td><?= $row->created_at ?? '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Tidak ada data yang tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>

    </table>
    </div> 

    <script>
        window.setTimeout("waktu()", 1000);

        function waktu() {
            var waktu = new Date();
            setTimeout("waktu()", 1000);
            document.getElementById("jam").innerHTML = waktu.getHours();
            document.getElementById("menit").innerHTML = waktu.getMinutes();
            document.getElementById("detik").innerHTML = waktu.getSeconds();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>