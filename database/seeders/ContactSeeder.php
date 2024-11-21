<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    public function run()
    {
        DB::table('contacts')->insert([
            ['name' => 'Andre Rodrigues', 'email' => 'teste@teste.com', 'phone' => '1234567890', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paulo Rodrigues', 'email' => 'teste2@testes.com', 'phone' => '0987654321', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
