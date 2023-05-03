<?php

namespace The3LabsTeam\GoogleNewsFeed\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \The3LabsTeam\LaravelGoogleNewsSitemap\LaravelGoogleNewsSitemap
 */
class GoogleNewsFeed extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \The3LabsTeam\GoogleNewsFeed\GoogleNewsFeedItem::class;
    }
}
