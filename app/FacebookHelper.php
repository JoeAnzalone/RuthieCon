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

    /*
     * "Heavily inspired" by this:
     * https://stackoverflow.com/a/36336039
     */
    public function paginateAll($response)
    {
        $edge = $response->getGraphEdge();

        $totalLikes = [];

        if ($this->fb->next($edge)) {
            $edgeArray = $edge->asArray();
            $totalLikes = array_merge($totalLikes, $edgeArray);
            while ($edge = $this->fb->next($edge)) {
                $edgeArray = $edge->asArray();
                $totalLikes = array_merge($totalLikes, $edgeArray);
            }
        } else {
            $edgeArray = $edge->asArray();
            $totalLikes = array_merge($totalLikes, $edgeArray);
        }

        return $totalLikes;
    }

    public function getGuestlist()
    {
        $event_id = env('FACEBOOK_EVENT_ID');

        $possible_rsvp_statuses = [
            'attending',
            // 'declined',
            // 'interested',
            'maybe',
            // 'noreply',
        ];

        $guests = [];

        foreach ($possible_rsvp_statuses as $status) {
            $response = $this->fb->get('/' . $event_id . '/' . $status);
            $guests = array_merge($this->paginateAll($response), $guests);
        }

        return $guests;
    }
}
