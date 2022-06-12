<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'email' => 'admin@rsss.pos'
        ], [
            'first_name' => 'Admin',
            'last_name' => 'admin',
            'email'=>'admin@rsss.pos',
            'password' => bcrypt('admin123')
        ]);
    }
}
