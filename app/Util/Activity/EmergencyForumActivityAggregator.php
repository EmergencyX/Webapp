<?php

namespace EmergencyExplorer\Util\Activity;

use Carbon\Carbon;
use EmergencyExplorer\Activity;
use EmergencyExplorer\Project;
use GuzzleHttp;


class EmergencyForumActivityAggregator implements ActivityAggregator
{
    /**
     * Update activities from the given $url
     *
     * @param string $url
     * @param int $start
     * @param int $limit
     */
    public function updateActivitiesForProject(Project $project, string $url, int $start = 0, int $limit = 20)
    {
        $response = \Cache::remember(md5($url), 30, function() use ($url, $start, $limit) {
            $client = new GuzzleHttp\Client();
            $response = $client->request('POST', 'http://www.emergency-forum.de/mobiquo/mobiquo.php', [
                'body' => xmlrpc_encode_request('get_thread', [$this->extractIdFromUrl($url), $start, $limit, true]),
                'headers' => [
                    'User-Agent'   => 'EmergencyExplorer/0.0.1 EmergencyActivityAggregator/1',
                    'Content-Type' => 'text/xml',
                ]
            ])->getBody()->getContents();

            return $response;
        });

        $parsed = xmlrpc_decode($response, 'utf-8');

        //Todo:
        //Handle more than 10 posts
        //Remember where we stopped parsing the posts


        $posts = $parsed['posts'];
        /*$synced = Activity::whereIn('remote_id', array_pluck($posts, 'post_id'))->get();

        if($synced->count() == count($posts)) {
            logger()->notice('Sorry godra :(');
            return;
        }*/

        foreach ($posts as $post) {
            $activity = new Activity;

            $activity->description = $post['post_content']->scalar;
            $activity->name = 'Neuer Beitrag im Emergency Forum';
            $activity->created_at = \Carbon\Carbon::createFromTimestampUTC($post['post_time']->timestamp);
            
            $project->activities()->save($activity);
        }
    }

    /**
     * Get the identifier for the aggregator
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return 'em-forum';
    }

    /**
     * Check if the given link with type=aggregator can be processed by this activity aggregator
     *
     * @param string $url
     * @return bool
     */
    public function canFetchFromThread(string $url): bool
    {
        $parsed = parse_url($url);

        return in_array($parsed['host'], ['emergency-forum.de', 'www.emergency-forum.de'])
        && $parsed['path'] === '/index.php'
        && str_is('thread/*', $parsed['query']);
    }

    /**
     * Fetch the id from the given thread url
     *
     * @param string $url
     * @return string
     */
    public function extractIdFromUrl(string $url): string
    {
        preg_match("/thread\\/(\\d+)-/", parse_url($url, PHP_URL_QUERY), $matches);

        return $matches[1];
    }

}