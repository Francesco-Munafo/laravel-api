<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class GitHubController extends Controller
{
    public function fetchRepos()
    {
        $username = config('services.github.username');
        $response = Http::withoutVerifying()->withHeader('Authorization', 'Bearer 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')->get("https://api.github.com/users/$username/repos?sort=created&direction=asc&per_page=100");
        if ($response->successful()) {
            $repositories = $response->json();



            foreach ($repositories as $repository) {

                $slug = Project::generateSlug($repository['name']);

                $project = Project::updateOrCreate(
                    ['title' => $repository['name']],
                    [
                        'slug' => $slug,
                        'git_link' => $repository['html_url'],
                        'description' => $repository['description'],
                        'image' => 'placeholders/placeholderimage.png',
                        'publication_date' => Carbon::parse($repository['created_at'])->format('Y-m-d'),
                    ]
                );

                $languagesResponse = Http::withoutVerifying()->withHeader('Authorization', 'Bearer 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')->get($repository['languages_url']);
                if ($languagesResponse->successful()) {
                    $languages = array_keys($languagesResponse->json());
                    //$languagesPercentage = array_values($languagesResponse->json()); //TODO GET PERCENTAGE

                    $technologyIds = [];

                    foreach ($languages as $language) {
                        $technology = Technology::firstOrCreate(
                            ['name' => $language],
                            ['slug' => Technology::generateSlug($language)]
                        );
                        $technologyIds[] = $technology->id;
                    }
                    $project->technologies()->sync($technologyIds);
                }

                //ensure to handle duplicates and updates appropriately
            }

            return to_route('admin.projects.index')->with('success', 'Repositories fetched successfully!');
        }

        return to_route('admin.projects.index')->with('error', 'Failed to fetch repositories!');
    }
}
