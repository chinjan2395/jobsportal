<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->realText(20);
        return [
            'title' => $title,
            'description' => $this->faker->paragraph(),
            'slug' => Str::slug($title),
            'start_date' => $this->faker->dateTimeBetween('0 days', '+14 days'),
            'end_date' => $this->faker->dateTimeBetween('0 days', '+14 days'),
        ];
    }
}
