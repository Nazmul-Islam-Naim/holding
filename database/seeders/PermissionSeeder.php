<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Role management
         $moduleAppRole = Module::updateOrCreate(['title' => 'Role Management', 'slug'=>Str::slug('Role Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRole->id,
             'title' => 'Access Roles',
             'slug' => 'app.roles.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRole->id,
             'title' => 'Create Role',
             'slug' => 'app.roles.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRole->id,
             'title' => 'Edit Role',
             'slug' => 'app.roles.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppRole->id,
             'title' => 'Delete Role',
             'slug' => 'app.roles.destroy',
         ]);


         // User management
         $moduleAppUser = Module::updateOrCreate(['title' => 'User Management', 'slug'=>Str::slug('User Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppUser->id,
             'title' => 'Access User',
             'slug' => 'app.users.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppUser->id,
             'title' => 'Create User',
             'slug' => 'app.users.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppUser->id,
             'title' => 'Edit User',
             'slug' => 'app.users.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppUser->id,
             'title' => 'Delete User',
             'slug' => 'app.users.destroy',
         ]);
         // designation management
         $moduleAppDesignation = Module::updateOrCreate(['title' => 'Designation Management', 'slug'=>Str::slug('Designation Management')]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDesignation->id,
             'title' => 'Access Designation',
             'slug' => 'app.designations.index',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDesignation->id,
             'title' => 'Create Designation',
             'slug' => 'app.designations.create',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDesignation->id,
             'title' => 'Edit Designation',
             'slug' => 'app.designations.edit',
         ]);
         Permission::updateOrCreate([
             'module_id' => $moduleAppDesignation->id,
             'title' => 'Delete Designation',
             'slug' => 'app.designations.destroy',
         ]);
    }
}
