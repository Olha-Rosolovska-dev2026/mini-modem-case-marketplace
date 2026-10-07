<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Demo accounts for admin, sellers and customers
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['name' => 'Olha Rosolovska', 'email' => 'admin@minimodemcase.test', 'role' => 'admin'],
            ['name' => 'Cascade Enclosure Works', 'email' => 'seller@minimodemcase.test', 'role' => 'vendor'],
            ['name' => 'Northline Fabrication', 'email' => 'northline@minimodemcase.test', 'role' => 'vendor'],
            ['name' => 'Harbour Signal Cases', 'email' => 'harbour@minimodemcase.test', 'role' => 'vendor'],
            ['name' => 'Field Deployment Supply', 'email' => 'field@minimodemcase.test', 'role' => 'vendor'],
            ['name' => 'Daniel Meyer', 'email' => 'customer@minimodemcase.test', 'role' => 'customer'],
            ['name' => 'Priya Raman', 'email' => 'priya@minimodemcase.test', 'role' => 'customer'],
        ];

        foreach ($accounts as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                $account + [
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'country' => 'United States',
                    'is_active' => true,
                ]
            );
        }
    }
}
