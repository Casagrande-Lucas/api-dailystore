<?php

namespace Database\Seeders;

use App\Repository\UserRepository;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit_products']);
        Permission::create(['name' => 'delete_products']);
        Permission::create(['name' => 'create_products']);

        Permission::create(['name' => 'vew_value_products']);
        Permission::create(['name' => 'edit_value_products']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'products_crud']);
        $role1->givePermissionTo('edit_products');

        $role2 = Role::create(['name' => 'products_crud_admin']);
        $role2->givePermissionTo('edit_products');
        $role2->givePermissionTo('delete_products');
        $role2->givePermissionTo('create_products');
        $role2->givePermissionTo('vew_value_products');
        $role2->givePermissionTo('edit_value_products');

        $role3 = Role::create(['name' => 'Super-Admin']);

        $data = [
            'name' => 'Admin',
            'email' =>  'admin@dailycstore.com.br',
            'email_verified_at' => now(),
            'password' => 'D@ily23$$!',
        ];

        try {
            $userAdmin = (new UserRepository($data))->create();
            $userAdmin->assignRole($role3);
        } catch (\Throwable $e) {
            print $e;
        }
    }
}
