<?php

namespace App;

class FacebookHelper
{
    public function __construct()
    {
        $token = env('FACEBOOK_DEVELOPER_ACCESS_TOKEN');

        $this->fb = app(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk::class);
        $this->fb->setDefaultAccessToken((string) $token);
    }

    public function getGuestlist()
    {
        $event_id = env('FACEBOOK_EVENT_ID');

        $possible_rsvp_statuses = [
            'attending',
            'declined',
            'interested',
            'maybe',
            'noreply',
        ];

        $guestlist = [];

        foreach ($possible_rsvp_statuses as $status) {
            $response = $this->fb->get('/' . $event_id . '/' . $status);
            $event_edge = $response->getGraphEdge();
            $guestlist[$status] = $event_edge->asArray();
        }

        return $guestlist;
    }
}
