<?php

namespace The3LabsTeam\GoogleNewsFeed;

use Illuminate\Support\Collection;
use The3LabsTeam\GoogleNewsFeed\Helpers\Path;
use Spatie\Feed\Http\FeedController;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GoogleNewsFeedServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-google-news-feed')
            ->hasConfigFile()
            ->hasViews();
    }

    public function packageRegistered()
    {
        $this->registerRouteMacro();
    }

    protected function registerRouteMacro(): void
    {
        $router = $this->app['router'];

        $router->macro('feeds', function ($baseUrl = '') use ($router)
        {
            foreach (config('google-news-sitemap.feeds') as $name => $configuration)
            {
                $url = Path::merge($baseUrl, $configuration['url']);

                $router->get($url, '\\' . FeedController::class)->name("feeds.{$name}");
            }
        });
    }

    protected function feedsGoogleNews(): Collection
    {
        return collect(config('google-news-sitemap.feeds'));
    }

    public function packageBooted()
    {
        //
    }
}
