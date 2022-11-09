<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::find(1);
      $admin =  Admin::create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'super_admin' => '1',
            'password' => Hash::make(1234),
           ]);
       $admin->assignRole($role1);

        $role2 = Role::find(2);
        $author = Admin::create([
            'name' => 'Author',
            'email' => 'author@app.com',
            'super_admin' => '0',
            'password' => Hash::make(1234),
        ]);
        $author->assignRole($role2);
    }
}
