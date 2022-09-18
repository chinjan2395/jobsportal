<?php

namespace Database\Seeders;

use App\CompanyEvent;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class CompanyEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        CompanyEvent::factory()
            ->count($faker->numberBetween(1, 5))
            ->create();
    }
}
