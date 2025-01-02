<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesandPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define permission names
        $arrayOfPermissionNames = [
            'viewUsers',
            'createUsers',
            'editUsers',
            'deleteUsers',
            'viewAdmins',
            'createAdmins',
            'editAdmins',
            'deleteAdmins',
            'viewRoles',
            'createRoles',
            'editRoles',
            'deleteRoles',
            'viewPermissions',
            'createPermissions',
            'editPermissions',
            'deletePermissions',
            'viewCategories',
            'createCategories',
            'editCategories',
            'deleteCategories',
            'viewSettings',
            'createSettings',
            'editSettings',
            'deleteSettings',
            'viewComments',
            'createComments',
            'editComments',
            'deleteComments',
            'viewNotifications',
            'createNotifications',
            'editNotifications',
            'deleteNotifications',
            'viewOrders',
            'createOrders',
            'editOrders',
            'deleteOrders',
            'viewContacts',
            'createContacts',
            'editContacts',
            'deleteContacts',
            'viewImages',
            'createImages',
            'editImages',
            'deleteImages',
            'viewBlogs',
            'createBlogs',
            'editBlogs',
            'deleteBlogs',
            'viewRatings',
            'createRatings',
            'editRatings',
            'deleteRatings',
            'viewPrices',
            'createPrices',
            'editPrices',
            'deletePrices',
            'viewProducts',
            'createProducts',
            'editProducts',
            'deleteProducts',
            'viewAttributes',
            'createAttributes',
            'editAttributes',
            'deleteAttributes',
        ];

        // Insert or update permissions
        foreach ($arrayOfPermissionNames as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'admin'], // Unique columns
                ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()] // Values to update
            );
        }

        // Define roles
        $arrayOfRolesNames = [
            'Staff',
            'Moderator',
            'Supervisor',
            'Manager',
            'Admin',
            'SuperAdmin',
            'Auditor',
            'Author',
            'Support',
            'Guest',
            'Sales',
        ];

        // Insert or update roles
        foreach ($arrayOfRolesNames as $role) {
            Role::firstOrCreate(
                ['name' => $role, 'guard_name' => 'admin'], // Unique columns
                ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()] // Values to update
            );
        }

        // Retrieve permissions for assignment
        $permissions = [];
        foreach ($arrayOfPermissionNames as $permissionName) {
            // Dynamically create the variable name
            $variableName = "{$permissionName}Permission";

            // Fetch the permission from the database
            $permissions[$variableName] = Permission::where('name', $permissionName)->first();
        }

        // Retrieve roles for assignment
        $roles = [];
        foreach ($arrayOfRolesNames as $roleName) {
            // Dynamically create the variable name
            $variableName = "{$roleName}Role";

            // Fetch the role from the database
            $roles[$variableName] = Role::where('name', $roleName)->first();
        }
        // Assign permissions to each role
        // Admin Role: Assign all permissions
        if ($roles['AdminRole']) {
            $roles['AdminRole']->givePermissionTo(Permission::all());
        }
        if ($roles['SuperAdminRole']) {
            $roles['SuperAdminRole']->givePermissionTo(Permission::all());
        }

        if ($roles['StaffRole']) {
            $roles['StaffRole']->givePermissionTo([
                $permissions['viewProductsPermission'],
                $permissions['viewAttributesPermission'],
            ]);
        }

        if ($roles['ModeratorRole']) {
            $roles['ModeratorRole']->givePermissionTo([
                $permissions['viewProductsPermission'],
                $permissions['viewAttributesPermission'],
            ]);
        }

        if ($roles['SupervisorRole']) {
            $roles['SupervisorRole']->givePermissionTo([
                $permissions['viewProductsPermission'],
                $permissions['viewAttributesPermission'],
            ]);
        }

        if ($roles['ManagerRole']) {
            $roles['ManagerRole']->givePermissionTo([
                $permissions['viewProductsPermission'],
                $permissions['viewAttributesPermission'],
            ]);
        }

        if ($roles['AuditorRole']) {
            $roles['AuditorRole']->givePermissionTo([
                $permissions['viewProductsPermission'],
                $permissions['viewAttributesPermission'],
            ]);
        }
        
        if ($roles['AuthorRole']) {
            $roles['AuthorRole']->givePermissionTo([
                $permissions['viewProductsPermission'],
                $permissions['viewAttributesPermission'],
            ]);
        }

        
        if ($roles['SupportRole']) {
            $roles['SupportRole']->givePermissionTo([
                $permissions['viewProductsPermission'],
                $permissions['viewAttributesPermission'],
            ]);
        }

        if ($roles['GuestRole']) {
            $roles['GuestRole']->givePermissionTo([
                $permissions['viewProductsPermission'],
                $permissions['viewAttributesPermission'],
            ]);
        }

        if ($roles['SalesRole']) {
            $roles['SalesRole']->givePermissionTo([
                $permissions['viewProductsPermission'],
                $permissions['viewAttributesPermission'],
            ]);
        }
    }
}
