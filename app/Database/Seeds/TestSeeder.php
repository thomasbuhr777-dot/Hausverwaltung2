<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'vorname'    => 'Max',
                'nachname'   => 'Mustermann',
                'email'      => 'max@example.com',
                'ist_mieter' => 1,
            ],
            [
                'vorname'    => 'Erika',
                'nachname'   => 'Musterfrau',
                'email'      => 'erika@example.com',
                'ist_mieter' => 1,
            ]
        ];

        $this->db->table('kontakte')->insertBatch($data);
    }
}