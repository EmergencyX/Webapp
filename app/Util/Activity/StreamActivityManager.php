<?php

namespace EmergencyExplorer\Util\Activity;

use GetStream\Stream\Client;

class StreamActivityManager
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(env('STREAM_API_KEY'), env('STREAM_API_SECRET'));
        $this->client->setLocation('eu-central');
    }

    /**
     * @return \GetStream\Stream\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $feed
     * @param $feedId
     *
     * @return \GetStream\Stream\Feed
     */
    public function getFeed($feed, $feedId)
    {
        return $this->client->feed($feed, $feedId);
    }
}