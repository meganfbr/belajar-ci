<?phpnamespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tanggal' => '2025-07-03',
                'nominal' => 20,
                'created_at' => date('Y-m-d H:i:s'),
                'update_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tanggal' => '2025-07-04',
                'nominal' => 15,
                'created_at' => date('Y-m-d H:i:s'),
                'update_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('diskon')->insertBatch($data);
    }
}
