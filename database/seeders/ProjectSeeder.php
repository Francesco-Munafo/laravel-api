<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Project;
use Illuminate\Support\Str;


class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {


        for ($i = 0; $i < 10; $i++) {
            $randNumber = random_int(1, 500);
            $project = new Project();
            $project->type_id = rand(1, 5);
            $project->title = $faker->realText(50);
            $project->slug = Str::slug($project->title, '-');
            $project->description = $faker->realText();
            $project->image = 'https://picsum.photos/id/' . $randNumber . '/200/300';
            $project->git_link = $faker->url();
            $project->external_link = $faker->url();
            $project->publication_date = $faker->dateTimeBetween('-5 months', '+1 month');
            $project->save();
        }
    }
}
