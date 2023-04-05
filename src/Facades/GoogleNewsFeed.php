<?php

namespace The3LabsTeam\GoogleNewsFeed\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VendorName\Skeleton\Skeleton
 */
class GoogleNewsFeed extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \The3LabsTeam\GoogleNewsFeed\GoogleNewsFeedItem::class;
    }
}
