<?php

namespace EmergencyExplorer\Util\Activity;

use GetStream\Stream\Client;
use Illuminate\Cache\Repository as Cache;

class StreamActivityManager
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Cache
     */
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->client = new Client(env('STREAM_API_KEY'), env('STREAM_API_SECRET'));
        $this->client->setLocation('eu-central');

        $this->cache = $cache;
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

    /**
     * @param string $key
     * @param callable $func
     *
     * @return mixed
     */
    public function cached(string $key, callable $func)
    {
        return $this->cache->remember($key, 1, $func);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function flushCache(string $key)
    {
        return $this->cache->forget($key);
    }

}