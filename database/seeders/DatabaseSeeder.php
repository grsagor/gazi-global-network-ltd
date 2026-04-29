<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountrySeeder::class);

        $admin = User::firstOrNew([
            'email' => 'admin@gmail.com',
        ]);

        $admin->name = 'Admin';
        $admin->first_name = 'Admin';
        $admin->last_name = 'User';
        $admin->phone = '0000000000';
        $admin->role = 1;
        $admin->status = 1;
        $admin->password = '123456';
        $admin->save();
    }
}
