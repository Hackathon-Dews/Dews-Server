<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = ['User', 'User-premium', 'User-Developer'];
        foreach ($data as $data) {
            DB::table('Roles')->insert([
                'name' => $data,
            ]);
        }
    }
}
