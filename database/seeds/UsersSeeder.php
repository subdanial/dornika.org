<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'visitor']);

        $user = User::create([
            'name' => 'مدیر کل',
            'email' => 'admin@gmail.com',
            'username' => 'super-admin',
            'mobile' => '09123456789',
            'password' => bcrypt('changethisPassword'),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\User',
            'model_id' => $user->id
        ]);
        $user = User::create([
            'name' => 'ویزیتور',
            'email' => 'visitor@gmail.com',
            'username' => 'visitor',
            'mobile' => '09123456788',
            'password' => bcrypt('changethisPassword'),
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => 2,
            'model_type' => 'App\User',
            'model_id' => $user->id
        ]);

        for ($i=0; $i < 10; $i++) {
            $user->clients()->create([
                'name' => 'مشتری شماره ' . rand(1, 100),
                'address' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officia perferendis sint libero, labore esse eum nemo possimus exercitationem qui a! Alias facilis consequatur necessitatibus. Id tempora perferendis ipsam voluptas deserunt?',
                'slug' => str_slug(rand(999, 9999999))
            ]);
        }
    }
}
