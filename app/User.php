<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'facebook_id', 'role_id', 'rsvp_status',
    ];

    public function setRsvpStatusAttribute($status)
    {
        $options = [
            'not_replied' => 0,
            'attending' => 1,
            'declined' => 2,
            'unsure' => 3,
        ];

        $this->attributes['rsvp_status_id'] = $options[$status];
    }

    public static function import($guestlist)
    {
        foreach ($guestlist as $guest) {
            self::updateOrCreate(
                ['facebook_id' => $guest['id']],
                ['name' => $guest['name'], 'rsvp_status' => $guest['rsvp_status']]
            );
        }
    }
}
