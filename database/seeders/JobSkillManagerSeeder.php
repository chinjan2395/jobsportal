<?php

namespace Database\Seeders;

use App\JobSkillManager;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class JobSkillManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        JobSkillManager::factory()
            ->count($faker->numberBetween(1, 3))
            ->create();
    }
}
