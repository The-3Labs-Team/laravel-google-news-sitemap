<?php

namespace The3LabsTeam\GoogleNewsFeed;

use Exception;
use The3LabsTeam\GoogleNewsFeed\Exceptions\InvalidFeedItem;

class GoogleNewsFeedItem
{
    public ?GoogleNewsFeed $feed = null;

    protected ?string $id = null;

    protected string $title;

    protected string $keywords;

    protected string $publicationName;

    protected string $publicationLanguage;

    protected string $publicationDate;

    protected string $link;

    protected array $category = [];

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public static function create(array $data = []): static
    {
        return new static($data);
    }

    public function id(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function link(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function keywords(string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function pubblicationName(string $publicationName): self
    {
        $this->publicationName = $publicationName;

        return $this;
    }

    public function pubblicationLanguage(string $publicationLanguage): self
    {
        $this->publicationLanguage = $publicationLanguage;

        return $this;
    }

    public function pubblicationDate(string $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function timestamp(): string
    {
        if ($this->feed->format() === 'rss')
        {
            return $this->updated->toRssString();
        }

        return $this->updated->toRfc3339String();
    }

    public function validate(): void
    {
        $requiredFields = ['id', 'title', 'keywords', 'publicationDate', 'link', 'publicationLanguage', 'publicationName'];

        foreach ($requiredFields as $requiredField)
        {
            if (is_null($this->$requiredField))
            {
                throw InvalidFeedItem::missingField($this, $requiredField);
            }
        }
    }

    public function __get($key)
    {
        if (!isset($this->$key))
        {
            throw new Exception("Property `{$key}` doesn't exist");
        }

        return $this->$key;
    }

    public function __isset($key)
    {
        return isset($this->$key);
    }
}
