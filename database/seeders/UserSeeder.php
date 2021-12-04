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
            'admin@user.com' => [
                'name' => 'Admin',
                'phone' => env('ADMIN_PHONE'),
                'password' => env('ADMIN_PASS'),
                'role' => UserType::ADMIN
            ],
            'customer@user.com' => [
                'name' => 'Customer',
                'phone' => env('USER_PHONE'),
                'password' => env('USER_PASS'),
                'role' => UserType::CUSTOMER
            ],
        ];
        $i = 0;
        foreach ($users as $email => $user) {
            /** @var User $model */
            $model = User::query()->create([
                'name' => $user['name'],
                'phone' => $user['phone'],
                'password' => bcrypt($user['password']),
                'email' => $email,
                'email_verified_at' => now(),
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
