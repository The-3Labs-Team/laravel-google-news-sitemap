<?php

namespace The3LabsTeam\GoogleNewsFeed\Http;

use Illuminate\Support\Str;
use Spatie\Feed\Helpers\ResolveFeedItems;
use The3LabsTeam\GoogleNewsFeed\GoogleNewsFeed;

class FeedController
{
    public function __invoke()
    {
        $feeds = config('feed.feeds');

        $name = Str::after(app('router')->currentRouteName(), 'feeds.');

        $feed = $feeds[$name] ?? null;

        abort_unless($feed, 404);

        $items = ResolveFeedItems::resolve($name, $feed['items']);

        return new GoogleNewsFeed(
            $feed['title'],
            $items,
            request()->url(),
            $feed['view'] ?? 'feed::atom',
            $feed['keywords'] ?? '',
            $feed['publicationName'] ?? '',
            $feed['publicationDate'] ?? '',
            $feed['publicationLanguage'] ?? 'it-IT',
            $feed['format'] ?? 'atom',
        );
    }
}
