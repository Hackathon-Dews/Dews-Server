<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'username' => 'userbiasa1',
                'name' => 'userbiasa',
                'password' => Hash::make('password'),
                'roles_id' => 1,
            ],
            [
                'username' => 'userpremium2',
                'name' => 'userpremium',
                'password' => Hash::make('password'),
                'roles_id' => 2,
            ],

        ];
        foreach ($data as $d) {
            $d['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $d['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            DB::table('users')->insert($d);
        }
    }
}
