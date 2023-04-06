<?php

namespace The3LabsTeam\GoogleNewsFeed\Http;

use Illuminate\Support\Str;
use The3LabsTeam\GoogleNewsFeed\GoogleNewsFeed;
use The3LabsTeam\GoogleNewsFeed\Helpers\ResolveGoogleNewsFeedItems;

class GoogleNewsFeedController
{
    public function __invoke()
    {
        $feeds = config('google-news-feed.feeds');

        $name = Str::after(app('router')->currentRouteName(), 'googleFeeds.');

        $feed = $feeds[$name] ?? null;

        abort_unless($feed, 404);

        $items = ResolveGoogleNewsFeedItems::resolve($name, $feed['items']);

        return new GoogleNewsFeed(
            $feed['title'],
            $items,
            request()->url(),
            $feed['view'] ?? 'google-news-feed::rss',
            $feed['keywords'] ?? '',
            $feed['publicationName'] ?? '',
            $feed['publicationDate'] ?? '',
            $feed['publicationLanguage'] ?? 'it-IT',
            $feed['format'] ?? 'rss',
        );
    }
}
