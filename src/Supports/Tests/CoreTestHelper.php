<?php

namespace Skillcraft\Core\Supports\Tests;

use Botble\ACL\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithFaker;

class CoreTestHelper
{
    use WithFaker;

    public function __construct()
    {
        $this->setUpFaker();
    }

    public function addUser(): Model
    {
        return User::query()->forceCreate([
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'username' => $this->faker->userName(),
            'password' => 'Qazwsx123!!',
            'super_user' => true,
            'manage_supers' => true,
        ]);
    }
}
