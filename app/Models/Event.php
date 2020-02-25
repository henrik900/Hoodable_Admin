<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_type', 'spot_id', 'user_id', 'name', 'description', 'start_date', 'end_date', 'location',
        'latitude', 'longitude', 'image_url', 'prizes', 'crystal'
    ];

    public function getImageUrlAttribute($value)
    {
        return url('uploads/events/'.$value);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function spot()
    {
        return $this->hasOne(Spot::class, 'id', 'spot_id');
    }
}
