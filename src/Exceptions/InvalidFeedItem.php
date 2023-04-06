<?php

namespace The3LabsTeam\GoogleNewsFeed\Exceptions;

use Exception;
use The3LabsTeam\GoogleNewsFeed\GoogleNewsFeedItem;

class InvalidFeedItem extends Exception
{
    public ?GoogleNewsFeedItem $subject;

    public static function notFeedable($subject): static
    {
        return (new static('Object does not implement `Spatie\Feed\Feedable`'))->withSubject($subject);
    }

    public static function notAFeedItem($subject): static
    {
        return (new static('`toFeedItem` should return an instance of `Spatie\Feed\Feedable`'))->withSubject($subject);
    }

    public static function missingField(GoogleNewsFeedItem $subject, $field): static
    {
        return (new static("Field `{$field}` is required"))->withSubject($subject);
    }

    protected function withSubject($subject): static
    {
        $this->subject = $subject;

        return $this;
    }
}
