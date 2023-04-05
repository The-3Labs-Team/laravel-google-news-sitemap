<?php

namespace The3LabsTeam\GoogleNewsFeed;

interface GoogleNewsFeedable
{
    public function toGoogleNewsFeedItem(): GoogleNewsFeedItem;
}
