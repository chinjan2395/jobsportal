<?php

namespace Database\Factories;

use App\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->company;
        return [
            'name' => $title,
            'slug' => Str::slug($title),
            'email' => $this->faker->companyEmail,
            'ceo' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'description' => $this->faker->paragraph(3),
            'no_of_offices' => $this->faker->randomDigit,
            'website' => $this->faker->url,
            'no_of_employees' => $this->faker->randomDigit,
            'established_in' => $this->faker->dateTimeBetween('-30 years', '-20 years')->format('y'),
            'fax' => $this->faker->bankAccountNumber,
            'phone' => $this->faker->phoneNumber,
            'is_active' => rand(0, 1),
            'verified' => rand(0, 1),
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
        return $this
            ->afterCreating(function (Company $company) {
                //
            });
    }
}
