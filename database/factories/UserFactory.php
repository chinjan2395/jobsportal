<?php

namespace Database\Factories;

use App\City;
use App\Country;
use App\State;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gender = rand(1, 2);
        $names = [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName($gender ? 'male' : 'female'),
            'last_name' => $this->faker->lastName,
        ];
        return [
            'first_name' => $names['first_name'],
            'middle_name' => $names['middle_name'],
            'last_name' => $names['last_name'],
            'name' => $names['first_name'] . ' ' . $names['middle_name'] . ' ' . $names['last_name'],
            'email' => $this->faker->unique()->safeEmail(),
            'date_of_birth' => $this->faker->dateTimeBetween('-30 years','-20 years'),
            'gender_id' => $gender,
            'country_id' => Country::where('country', '=', $this->faker->country)->first()->id,
            'state_id' => State::where('state', '=', $this->faker->state)->first()->id,
            'phone' => $this->faker->phoneNumber,
            'mobile_num' => $this->faker->phoneNumber,
            'is_active' => $gender,
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
        });
    }
}

