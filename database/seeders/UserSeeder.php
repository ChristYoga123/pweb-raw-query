<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::insert('insert into users (name, email, password) values (?, ?, ?)', ['Christianus Yoga Wibisono', 'christianuswibisono@gmail.com', bcrypt("password")]);
    }
}
