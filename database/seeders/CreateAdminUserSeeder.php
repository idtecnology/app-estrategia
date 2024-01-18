<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => '',
            'password' => bcrypt('123'),
            'avatar' => 'avatar-1.jpg',
            'empresa_id' => 1,
            'crm_id' => '12472210-2'
        ]);

        $user2 = User::create([
            'name' => 'admin2',
            'email' => '',
            'password' => bcrypt('123'),
            'avatar' => 'avatar-1.jpg',
            'empresa_id' => 11,
            'crm_id' => '12472210-1'
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
        $user2->assignRole([$role->id]);
    }
}
