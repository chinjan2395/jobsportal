<?php

namespace Database\Factories;

use App\CareerLevel;
use App\DegreeLevel;
use App\FunctionalArea;
use App\Job;
use App\JobExperience;
use App\JobShift;
use App\JobType;
use App\SalaryPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobFactory extends Factory
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
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'benefits' => $this->faker->paragraph(2),
            'is_freelance' => rand(3, 5),
            'salary_from' => $this->faker->numberBetween($min = 10000, $max = 99999),
            'salary_to' => $this->faker->numberBetween($min = 10000, $max = 99999),
            'hide_salary' => rand(0, 1),
            'salary_currency' => $this->faker->currencyCode,
            'num_of_positions' => $this->faker->randomDigit,
            'gender_id' => rand(1, 2),
            'expiry_date' => $this->faker->dateTimeBetween('1 days', '+59 days'),
            'is_active' => rand(0, 1),
            'location' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Job $job) {

            $job->update([
                'career_level_id' => CareerLevel::inRandomOrder()->first()->id,
                'salary_period_id' => SalaryPeriod::inRandomOrder()->first()->id,
                'functional_area_id' => FunctionalArea::inRandomOrder()->first()->id,
                'job_type_id' => JobType::inRandomOrder()->first()->job_type_id,
                'job_shift_id' => JobShift::inRandomOrder()->first()->job_shift_id,
                'degree_level_id' => DegreeLevel::inRandomOrder()->first()->degree_level_id,
                'job_experience_id' => JobExperience::inRandomOrder()->first()->job_experience_id,
            ]);
        });
    }
}
