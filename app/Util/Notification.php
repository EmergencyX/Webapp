<?php

namespace EmergencyExplorer\Util;

use EmergencyExplorer\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Notification
{
    const PRIORITY_HIGH   = 0;
    const PRIORITY_NORMAL = 1;
    const PRIORITY_LOW    = 2;

    /**
     * Turn automatic saving off. Not sure if required though.
     * @var \Illuminate\Support\Collection
     */
    public $autosave = true;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $notifications;

    /* Notification format v1
    [
        's-123' | 'd-456' | 'g-789' => [
            'content'    => 'signup.complete',
            'parameters' => ['name' => 'Fubar'],
            'priority'   => 2,
            'timestamp'  => 13214139434,
            'flash'      => false,
            'global'     => true
        ]
    ]

    We wont store the full notification string - only the translation id.
    Afterwards we should be able to call
    trans($notification['content'], $notification['parameters'])
    and have nice notification pop up, regarding the current locale
    while reducing the required storage space.

    - priority helps sorting out what is important and what not
    - timestamp does the same thing on a time basis
    - expires is either a timestamp defining if a notification will expire
      or has to be dismissed by the user. Global notifications may not be dismissed.
      use them wisely to avoid annoying the enduser.
    - global tells you if this is a global notification
    */

    /**
     * Notification constructor.
     */
    public function __construct()
    {
        $this->notifications = collect(session('notifications', []));

        //add those from the database for the current user

        //add global notifications
    }

    /**
     * @return \Illuminate\Support\Collection|static
     */
    public function getNotifications()
    {
        return $this->notifications->sortBy('priority');
    }

    public function dismiss($id)
    {
        if (! $this->notifications->contains($id)) {
            throw new \InvalidArgumentException('Could not find notification to dismiss');
        }
    }

    /**
     * @param User $user
     * @param array $notification
     */
    public function persistent(User $user, array $notification)
    {

    }

    public function flash(array $notification)
    {
        $tries = 10;
        while ($id = mt_rand(0, 10000000) && $tries > 0) {
            $tries--;
            if (! $this->notifications->has("s-$id")) {
                break;
            }
        }

        $this->notifications->put("s-$id", $notification);
    }


    protected function autosave()
    {
        if ($this->autosave) {
            session('notifications', $this->notifications->filter(function(array $notification) {
                if (str_is('s-*', $notification['id'])) {

                }
            }));
        }
    }
}