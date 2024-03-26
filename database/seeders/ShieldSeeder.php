<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"panel_user","guard_name":"web","permissions":[]},{"name":"super_admin","guard_name":"web","permissions":["view_customer","view_any_customer","create_customer","update_customer","restore_customer","restore_any_customer","replicate_customer","reorder_customer","delete_customer","delete_any_customer","force_delete_customer","force_delete_any_customer","view_payment::form","view_any_payment::form","create_payment::form","update_payment::form","restore_payment::form","restore_any_payment::form","replicate_payment::form","reorder_payment::form","delete_payment::form","delete_any_payment::form","force_delete_payment::form","force_delete_any_payment::form","view_product","view_any_product","create_product","update_product","restore_product","restore_any_product","replicate_product","reorder_product","delete_product","delete_any_product","force_delete_product","force_delete_any_product","view_profit::range","view_any_profit::range","create_profit::range","update_profit::range","restore_profit::range","restore_any_profit::range","replicate_profit::range","reorder_profit::range","delete_profit::range","delete_any_profit::range","force_delete_profit::range","force_delete_any_profit::range","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_sale","view_any_sale","create_sale","update_sale","restore_sale","restore_any_sale","replicate_sale","reorder_sale","delete_sale","delete_any_sale","force_delete_sale","force_delete_any_sale","view_suit::case","view_any_suit::case","create_suit::case","update_suit::case","restore_suit::case","restore_any_suit::case","replicate_suit::case","reorder_suit::case","delete_suit::case","delete_any_suit::case","force_delete_suit::case","force_delete_any_suit::case","view_token","view_any_token","create_token","update_token","restore_token","restore_any_token","replicate_token","reorder_token","delete_token","delete_any_token","force_delete_token","force_delete_any_token","view_type::product","view_any_type::product","create_type::product","update_type::product","restore_type::product","restore_any_type::product","replicate_type::product","reorder_type::product","delete_type::product","delete_any_type::product","force_delete_type::product","force_delete_any_type::product","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
