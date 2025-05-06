<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Data produk furniture
        $data = [
            [
                'nama' => 'Sofa Chesterfield 3 Seater',
                'harga' => 12500000,
                'jumlah' => 10,
                'foto' => 'sofa_chesterfield.jpg',
                'kategori_id' => 6, // ID kategori Sofas
                'deskripsi' => 'Sofa klasik dengan desain Chesterfield, bahan kulit asli, nyaman untuk ruang tamu',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Tempat Tidur King Size Minimalis',
                'harga' => 8500000,
                'jumlah' => 8,
                'foto' => 'tempat_tidur_king.jpg',
                'kategori_id' => 7, // ID kategori Beds
                'deskripsi' => 'Tempat tidur king size dengan desain minimalis, rangka kayu jati solid',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Meja Makan Minimalis 6 Kursi',
                'harga' => 6500000,
                'jumlah' => 5,
                'foto' => 'meja_makan_minimalis.jpg',
                'kategori_id' => 4, // ID kategori Dining Room
                'deskripsi' => 'Set meja makan minimalis dengan 6 kursi, bahan kayu oak dengan finishing natural',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Lemari Pakaian 3 Pintu',
                'harga' => 4500000,
                'jumlah' => 12,
                'foto' => 'lemari_pakaian.jpg',
                'kategori_id' => 3, // ID kategori Bedroom
                'deskripsi' => 'Lemari pakaian 3 pintu dengan desain modern, material MDF tebal dan finishing doff',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Meja Kerja Executive',
                'harga' => 3200000,
                'jumlah' => 15,
                'foto' => 'meja_kerja_executive.jpg',
                'kategori_id' => 5, // ID kategori Office
                'deskripsi' => 'Meja kerja executive dengan laci penyimpanan, material kayu mahoni dengan finishing glossy',
                'created_at' => date("Y-m-d H:i:s"),
            ]
        ];

        // Insert semua data ke tabel
        $this->db->table('products')->insertBatch($data);
    }
}