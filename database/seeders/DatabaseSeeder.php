<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $singers = [
            ['name' => 'Sơn Tùng'],
            ['name' => 'J97'],
            ['name' => 'Amee'],
            ['name' => 'Bảo Thy'],
            ['name' => 'Erik'],
            ['name' => 'Đạt G'],
            ['name' => 'Chi Pu'],
            ['name' => 'Min'],
            ['name' => 'Binz'],
            ['name' => 'Hiền Hồ'],
            ['name' => 'Đông  Nhi'],
        ];
        DB::table('singers')->insert($singers);
    }
}
