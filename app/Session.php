<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'category_id', 'user_id', 'location', 'time',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function setCategoryAttribute($status)
    {
        $categories = [
            'Other' => 0,
            'Talk' => 1,
            'Workshop' => 2,
            'Activity' => 3,
            'Performance' => 4,
        ];

        $this->attributes['rsvp_status_id'] = $categories[$category_id];
    }

    public function getCategoryAttribute()
    {
        $categories = [
            0 => 'Other',
            1 => 'Talk',
            2 => 'Workshop',
            3 => 'Activity',
            4 => 'Performance',
        ];

        return $categories[$this->category_id];
    }
}
