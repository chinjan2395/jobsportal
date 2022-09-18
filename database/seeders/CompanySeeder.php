<?php

namespace Database\Seeders;

use App\Company;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        Company::factory()
            ->count($faker->numberBetween(1, 2))
            ->hasJobs($faker->numberBetween(1, 3))
            ->hasEvents($faker->numberBetween(1, 2))
            ->create();
    }
}
