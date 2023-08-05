<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Department;
use App\Models\Designation;
use App\Models\District;
use App\Models\Division;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin
        User::updateOrCreate([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'phone' => '01977686222',
            'password' => Hash::make('password'),
            'role_id' => Role::where('slug', 'admin')->first()->id,
            'status' => true
        ]);
    }
}
