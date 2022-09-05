<?php

namespace Database\Seeders;

use App\Job;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        Job::factory()
            ->count($faker->numberBetween(1, 2))
            ->hasJobSkills($faker->numberBetween(1, 4))
            ->create();
    }
}
