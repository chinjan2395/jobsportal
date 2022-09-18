<?php

namespace Database\Factories;

use App\CareerLevel;
use App\Country;
use App\FunctionalArea;
use App\JobExperience;
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
            'phone' => $this->faker->e164PhoneNumber,
            'mobile_num' => $this->faker->e164PhoneNumber,
            'is_active' => $gender,
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),
            'current_salary' =>  $this->faker->numberBetween($min = 10000, $max = 49999),
            'expected_salary' => $this->faker->numberBetween($min = 40000, $max = 99999)
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

            $user->update([
                'job_experience_id' => JobExperience::inRandomOrder()->first()->job_experience_id,
                'career_level_id' => CareerLevel::inRandomOrder()->first()->id,
                'industry_id' => CareerLevel::inRandomOrder()->first()->id,
                'functional_area_id' => FunctionalArea::inRandomOrder()->first()->id,
            ]);
        });
    }
}

