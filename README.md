# Laravel Google News Sitemap

[![Latest Version on Packagist](https://img.shields.io/packagist/v/the-3labs-team/laravel-google-news-sitemap.svg?style=flat-square)](https://packagist.org/packages/the-3labs-team/laravel-google-news-sitemap)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/the-3labs-team/laravel-google-news-sitemap/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/the-3labs-team/laravel-google-news-sitemap/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/the-3labs-team/laravel-google-news-sitemap/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/the-3labs-team/laravel-google-news-sitemap/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/the-3labs-team/laravel-google-news-sitemap.svg?style=flat-square)](https://packagist.org/packages/the-3labs-team/laravel-google-news-sitemap)

**This package is still in development and can be subject to breaking changes.**

This package allows you to generate a Google News sitemap for your Laravel application.
It can be used in combination with [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap) to generate a sitemap that includes both regular and news sitemaps.

## Requirements
- PHP 7.4 or higher
- Laravel 8.0 or higher

## Installation

You can install the package via composer:

```bash
composer require the-3labs-team/laravel-google-news-sitemap
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-google-news-sitemap-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-google-news-sitemap-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-google-news-sitemap-views"
```

## Usage

The best way to use this package is creating a command that will generate the sitemap and then schedule it to run periodically.

First, you need to create two methods in your model that will be used to generate the sitemap.

```php
<?php

public static function getGoogleNewsFeedItems()
{
    Article::query()->wherePublished()
                ->where('published_at', '>', now()
                    ->subDays(2))
                ->orderBy('published_at', 'desc')
                ->limit(50)
                ->get();
}

public function toGoogleNewsFeedItem(): GoogleNewsFeedItem
{
    return GoogleNewsFeedItem::create()
    ->id($this->id)
    ->title($this->title) // Change this to the title of your article
    ->keywords('News') // Change this to the keywords of your article
    ->publicationDate($this->published_at) // Change this to the publication date of your article
    ->publicationName($this->getAuthorNameAttribute()) // Change this to the name of your author or publication
    ->publicationLanguage("it") // Change this to the language of your article
    ->link($this->route); // Change this to the route of your article
}
```

You can create the command using the following command:

```bash
php artisan make:command GoogleSitemapBuild
```

Then you can edit the command to look like this:

```php
<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Article;

class GoogleSitemapBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google-sitemap:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build the sitemap for Google News';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->info('Collecting articles...');

        $articles = Article::getGoogleNewsFeedItems();
        $this->info('Done, ' . $articles->count() . ' articles collected.');

        $feeds = [];
        $this->info('Building feed items from collected articles...');
        foreach ($articles as $article) {
            $feeds[] = $article->toGoogleNewsFeedItem();
        }

        $this->info('Done, ' . count($feeds) . ' feed items built.');

        $this->info('Building google news sitemap...');
        $xml = view('google-news-feed::rss', [
            'items' => $feeds,
        ])->render();

        file_put_contents(public_path('google-news-sitemap.xml'), $xml);

        $this->info('Google News Sitemap built successfully!');

        return 0;
    }
}
```

Then you can schedule the command to run periodically in your `app/Console/Kernel.php` file:

```php
<?php
namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('google-sitemap:build')->everyFiveMinutes()->withoutOverlapping();
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Stefano Novelli](https://github.com/The-3Labs-Team)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
