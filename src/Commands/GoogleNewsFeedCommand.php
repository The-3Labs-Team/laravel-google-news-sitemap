<?php

namespace The3LabsTeam\GoogleNewsFeed\Commands;

use Illuminate\Console\Command;

class GoogleNewsFeedCommand extends Command
{
    public $signature = 'laravel-google-news-sitemap';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
