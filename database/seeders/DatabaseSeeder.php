<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create([
            "name" => "admin",
            "email" => "admin@admin.com",
            "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi"
        ]);
        \App\Models\User::factory(9)->create();
        \App\Models\UserRole::factory(10)->create();
        \App\Models\Patient::factory(1000)->create();
        \App\Models\BotAction::factory(10)->create();
    }
}
