<?php

namespace The3LabsTeam\GoogleNewsFeed;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use The3LabsTeam\GoogleNewsFeed\Helpers\GoogleNewsFeedContentType;
use Carbon\Carbon;

class GoogleNewsFeed implements Responsable
{
    protected Collection $feedItems;

    public function __construct(
        protected string $title,
        protected Collection $items,
        protected string $url = '',
        protected string $view = 'feed::rss',
        protected string $keywords = '',
        protected string $publicationName = '',
        protected string $publicationDate = '',
        protected string $publicationLanguage = '',
        protected string $format = 'rss'
    ) {
        $this->url = $url ?? request()->url();

        $this->feedItems = $this->items->map(fn ($feedable) => $this->castToFeedItem($feedable));
    }

    public function toResponse($request): Response
    {
        $meta = [
            'id' => url($this->url),
            'link' => url($this->url),
            'title' => $this->title,
            'keywords' => $this->keywords,
            'publicationName' => $this->publicationName,
            'publicationLanguage' => $this->publicationLanguage,
            'publicationDate' => $this->publicationDate ? Carbon::parse($this->publicationDate)
                ->toIso8601String() : $this->lastUpdated(),
        ];

        $contents = view($this->view, [
            'meta' => $meta,
            'items' => $this->feedItems,
        ]);

        return new Response($contents, 200, [
            'Content-Type' => GoogleNewsFeedContentType::forResponse($this->format).';charset=UTF-8',
        ]);
    }

    public function format(): string
    {
        return $this->format;
    }

    protected function castToFeedItem(array|GoogleNewsFeedItem|GoogleNewsFeedable $feedable): GoogleNewsFeedItem
    {
        if (is_array($feedable)) {
            $feedable = new GoogleNewsFeedItem($feedable);
        }

        if ($feedable instanceof GoogleNewsFeedItem) {
            $feedable->feed = $this;

            $feedable->validate();

            return $feedable;
        }

        $feedItem = $feedable->toGoogleNewsFeedItem();

        $feedItem->feed = $this;

        $feedItem->validate();

        return $feedItem;
    }

    protected function lastUpdated(): string
    {
        if ($this->feedItems->isEmpty()) {
            return '';
        }

        $updatedAt = $this->feedItems
            ->sortBy(fn ($feedItem) => $feedItem->updated)
            ->last()->updated;

        return $this->format === 'rss'
            ? $updatedAt->toRssString()
            : $updatedAt->toRfc3339String();
    }
}
