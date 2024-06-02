<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Psr\Http\Message\UriInterface;
use Spatie\Sitemap\SitemapGenerator;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('generate-sitemap', function () {
    $sitemap = SitemapGenerator::create(config('app.url'))
        ->shouldCrawl(function (UriInterface $url) {
            return ! str_contains($url->getPath(), '/register') && ! str_contains($url->getPath(), '/login');
        })
        ->getSitemap();

    $sitemap->writeToFile(public_path('sitemap.xml'));
//    $sitemap->writeToDisk('public', 'sitemap.xml');
});
