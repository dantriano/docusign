<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Dan',
            'surname' => 'Triano',
            'nif' => '47159695N',
            'email' => 'dtriano@xtec.cat',
            'password' => Hash::make('password'),
        ]);
    }
}
