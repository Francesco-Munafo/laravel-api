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
                $languagesPercentage = [];
                if ($languagesResponse->successful()) {

                    $languagesData = $languagesResponse->json();

                    $totalSize = array_sum($languagesData);

                    foreach ($languagesData as $language => $size) {
                        $percentage = ($size / $totalSize) * 100;

                        $technology = Technology::updateOrCreate(
                            ['name' => $language],
                            [
                                'slug' => Technology::generateSlug($language),
                            ]
                        );
                        $project->technologies()->sync([$technology->id => ['technology_percentage' => $percentage]]);
                    }
                }
            }

            //ensure to handle duplicates and updates appropriately


            return to_route('admin.projects.index')->with('success', 'Repositories fetched successfully!');
        }

        return to_route('admin.projects.index')->with('error', 'Failed to fetch repositories!');
    }
}
