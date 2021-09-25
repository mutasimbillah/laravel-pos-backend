<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $users = [
            'super@user.com' => [
                'name' => 'Super',
                'role' => UserType::SUPER
            ],
            'admin@user.com' => [
                'name' => 'Admin',
                'role' => UserType::ADMIN
            ],
            'merchant@user.com' => [
                'name' => 'Shop Owner',
                'role' => UserType::MERCHANT
            ],
            'waiter@user.com' => [
                'name' => 'Waiter',
                'role' => UserType::WAITER
            ],
            'customer@user.com' => [
                'name' => 'Customer',
                'role' => UserType::CUSTOMER
            ],
        ];
        $i = 0;
        foreach ($users as $email => $user) {
            /** @var User $model */
            $model = User::query()->create([
                'first_name' => $user['name'],
                'last_name' => 'User',
                'password' => bcrypt('secret'),
                'email' => $email,
                'email_verified_at' => now(),
                'phone' => '+880170000000'. ++$i,
                'phone_verified_at' => now()
            ]);
            /** @var Role $role */
            $role = Role::query()->create([
                'name' => $user['role'],
                'display_name' => ucfirst($user['role'])
            ]);
            $model->attachRole($role);
        }
        Model::reguard();
    }
}
