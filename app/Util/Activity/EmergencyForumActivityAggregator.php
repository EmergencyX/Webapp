<?php

namespace EmergencyExplorer\Util\Activity;

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
        $response = \Cache::remember(md5($url), 30, function () use ($url, $start, $limit) {
            $client = new GuzzleHttp\Client();
            $response = $client->request('POST', 'http://www.emergency-forum.de/mobiquo/mobiquo.php', [
                'body' => xmlrpc_encode_request('get_thread', [$this->extractIdFromUrl($url), $start, $limit, true]),
                'headers' => [
                    'User-Agent' => 'EmergencyExplorer/0.0.1 EmergencyActivityAggregator/1',
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
        $synced = $project->activities()->whereIn('remote_id', array_pluck($posts, 'post_id'))->get();

        $urlTemplate = 'http://www.emergency-forum.de/index.php?thread/%s-/&postID=%s#post%s';
        foreach ($posts as $post) {
            $activity = $synced->first(function ($key, Activity $activity) use ($post) {
                return $activity->remote_id === $post['post_id'];
            });

            if (!$activity) {
                $activity = new Activity;
            }

            $activity->description = trim($post['short_content']->scalar) . "...";
            $activity->name = trim($post['post_title']->scalar);
            if ($activity->name === '') {
                $activity->name = trim($post['topic_title']->scalar);
            }
            $activity->created_at = \Carbon\Carbon::createFromTimestampUTC($post['post_time']->timestamp);
            $activity->url = sprintf($urlTemplate, $post['topic_id'], $post['post_id'], $post['post_id']);
            $activity->remote_id = $post['post_id'];

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

/*
 * [
     "post_id" => "1022099",
     "forum_id" => "331",
     "forum_name" => {#890
       +"scalar": "EMERGENCY 5 / 2016 Community",
       +"xmlrpc_type": "base64",
     },
     "topic_id" => "63440",
     "topic_title" => {#891
       +"scalar": "Emergency Explorer | Neu: Umfrage",
       +"xmlrpc_type": "base64",
     },
     "reply_number" => 18,
     "new_post" => false,
     "view_number" => 1071,
     "post_title" => {#892
       +"scalar": "Emergency Explorer | Neu: Umfrage",
       +"xmlrpc_type": "base64",
     },
     "post_content" => {#893
       +"scalar": "Hey,<br /><br />alles neu macht der Mai und ich möchte auch gar nicht groß um den heißen Brei herumreden. Zusammen mit [url='http://www.emergency-forum.de/index.php?user/15361-ciajoe/']@ciajoe[/url] möchte ich euch ein Projekt vorstellen, mit dem wir das Modding in Emergency 5 verbessern wollen.<br /><br />[align=center]> [url='http://www.emergency-forum.de/index.php?thread/63440-emergency-explorer/&postID=1022443#post1022443']Direkt zur Umfrage in Beitrag #10[/url] < [/align]<br /><br />Wir nennen das Projekt <b>Emergency Explorer</b> (oder kurz EmergencyX). Wir wollen bei der Entwicklung die Community nah dabei haben, gleichzeitig aber nicht nur auf Luftschlössern bauen. Deshalb würden wir gerne eure Meinung zu dem Projekt hören und sehr bald den Testbetrieb aufnehmen, denn ein Grundgerüst haben wir bereits erstellt. Das ist an dieser Stelle ein Versprechen, dass wir es durchaus ernst meinen und gern mit euch teilen würden.<br /><br />Mit dem <b>Emergency Explorer</b> wollen wir eine Plattform bieten, die das Entwickeln, Entdecken und Spielen von Modifikationen vereinfacht. Im Fokus stehen zunächst einfache Funktionen:<br /><br /><b>Eine einfache Installation</b><br />Es sollte möglichst einfach sein eine Modifikation und deren Updates zu installieren. Dabei sollten nur geänderte Daten übertragen werden, um möglichst schnell wieder aktuell zu sein.<br />Auf Seiten der Entwickler möchten wir einen Workflow mit Versionsverwaltungen unterstützen, für den Anfang aber die Einstiegsschwelle gering halten.<br /><br /><b>Korrekte Abhängigkeiten</b><br />Wird für diese Modifikation eine andere Modifikation zwangsläufig erfordert?<br />Gibt es eine Modifikation, die sich mit dieser sehr gut verträgt und die daher empfohlen wird? Gibt es Komplikationen mit anderen Modifikationen?<br />Anhand dieser Regeln sollten Modifikationen aktiviert oder deaktiviert werden können.<br /><br /><b>Multiplayer Verabredungen</b><br />Ein besserer Serverbrowser. Wir kennen die Modifikationen, wir stellen sicher, dass die Lobby die korrekten Versionen und eine identische Konfiguration vorliegen hat.<br /><br />Was ist mit [lexicon]Emergency 4[/lexicon]? Eine Implementierung für [lexicon]Emergency 4[/lexicon] ist möglich, derzeit aber nicht vorgesehen. Emergency 5 erlaubt es, verschiedene Mods gleichzeitig zu verwenden. Hieraus ergeben sich neue, viel modularere Strukturen als in [lexicon]Emergency 4[/lexicon], die schwieriger zu verwalten sind. Das sehen wir als eine große Stärke des Emergency Explorers.<br /><br />Das Projekt werden wir <b>Open Source</b> führen und wer gerne ein Teil der Entwicklung wäre, kann sich mit konkreten Fragen gerne per PN melden.<br /><br />Für Fragen und Ideen stehen wir also hier im Thread zur Verfügung.<br /><br /><br />[table]<br />[tr]<br />[td]Client[/td]<br />[td]Server[/td]<br />[td]Webapp[/td]<br />[td]Plugin für Emergency[/td]<br />[/tr]<br />[tr]<br />[td]Regelt die Installation und Verwaltungen auf dem Computer[/td]<br />[td]Benötigt für den Client (Backend) und für Echtzeitfunktionen (Multiplayer)[/td]<br />[td]Begleitet den Client, ist plattformunabhängig, aber übernimmt keine Installationen[/td]<br />[td]Upload von Screenshots, TBD[/td]<br />[/tr]<br />[tr]<br />[td]C#<br />verwendet WPF, [url='http://www.grpc.io/']grpc[/url][/td]<br />[td]Node.js<br />verwendet [url='http://bookshelfjs.org/']bookshelf[/url], [url='http://www.grpc.io/']grpc[/url],[/td]<br />[td]PHP 7<br />verwendet [url='https://laravel.com/']Laravel[/url][/td]<br />[td]C++[/td]<br />[/tr]<br />[/table]",
       +"xmlrpc_type": "base64",
     },
     "short_content" => {#894
       +"scalar": "Hey,  alles neu macht der Mai und ich möchte auch gar nicht groß um den heißen Brei herumreden. Zusammen mit @ciajoe möchte ich euch ein Projekt vorstellen, mit dem wir das Modding in Emerge",
       +"xmlrpc_type": "base64",
     },
     "post_author_id" => "16442",
     "icon_url" => "http://www.emergency-forum.de/wcf/images/avatars/c4/3023-c4a931edd04160904ba6d4c4f74412f62382287c.png",
     "post_author_name" => {#895
       +"scalar": "noBlubb",
       +"xmlrpc_type": "base64",
     },
     "state" => 0,
     "is_online" => false,
     "can_edit" => false,
     "post_time" => {#896
       +"scalar": "20160531T22:47:23+00:00",
       +"xmlrpc_type": "datetime",
       +"timestamp": 1464734843,
     },
     "timestamp" => "1464727643",
     "can_thank" => false,
     "is_liked" => false,
     "can_like" => false,
     "like_count" => 10,
     "can_delete" => false,
     "can_ban" => false,
     "can_approve" => false,
     "can_move" => false,
     "can_report" => false,
     "attachments" => [],
     "thanks_info" => [],
     "likes_info" => [
       [
         "userid" => "40",
         "username" => {#897
           +"scalar": "godra",
           +"xmlrpc_type": "base64",
         },
       ],
       [
         "userid" => "53647",
         "username" => {#898
           +"scalar": "KillerConsti",
           +"xmlrpc_type": "base64",
         },
       ],
       [
         "userid" => "15826",
         "username" => {#899
           +"scalar": "Traktor",
           +"xmlrpc_type": "base64",
         },
       ],
     ],
   ]
 */