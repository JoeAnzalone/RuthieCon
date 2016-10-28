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

    public function getRsvpStatusAttribute()
    {
        $options = [
            0 => 'not_replied',
            1 => 'attending',
            2 => 'declined',
            3 => 'unsure',
        ];

        return $options[$this->rsvp_status_id];
    }

    public function getRoleAttribute()
    {
        $roles = [
            0 => 'none',
            1 => 'admin',
        ];

        return $roles[$this->role_id];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function avatar($size = 64)
    {
        return 'https://graph.facebook.com/' . $this->facebook_id . '/picture?type=square&width=' . $size . '&height=' . $size;
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
