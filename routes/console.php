<?php

use App\Models\Project;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Psr\Http\Message\UriInterface;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('generate-sitemap', function () {
    $sitemap = SitemapGenerator::create(config('app.url'))
        ->shouldCrawl(function (UriInterface $url) {
            return ! str_contains($url->getPath(), '/register') && ! str_contains($url->getPath(), '/login');
        })
        ->getSitemap();

    $sitemap->add(
        Url::create(route('terms.index'))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0)
            ->addAlternate('/terms-of-services-in-english', 'uk'),
    );

    $projects = (new Project())->paginate(12);

    if ($projects->lastPage() > 0) {
        foreach (range(1, $projects->lastPage()) as $index) {
            $url = route('projects.index', $index === 1 ? [] : ['page' => $index]);
            $sitemap->add(
                Url::create($url)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.5)
            );
        }
    }

    $sitemap->writeToFile(public_path('sitemap.xml'));
//    $sitemap->writeToDisk('public', 'sitemap.xml');
});
