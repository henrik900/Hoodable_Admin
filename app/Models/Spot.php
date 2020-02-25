<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spot extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_type_id', 'category_id', 'spot_name', 'spot_description', 'spot_phone',
        'spot_website', 'spot_opening_time', 'spot_ending_time', 'location', 'latitude', 'longitude', 'image_url'
    ];

    public function spot_creator()
    {
        return $this->hasOne(SpotCreator::class, 'spot_id', 'id');
    }

    public function getImageUrlAttribute($value)
    {
        return url('uploads/spots/'.$value);
    }

    public function businessType()
    {
        return $this->hasOne(BusinessType::class, 'id', 'business_type_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function event()
    {
        return $this->hasMany(Event::class, 'spot_id', 'id');
    }

    public function promotion()
    {
        return $this->hasMany(Event::class, 'spot_id', 'id');
    }

    public function competition()
    {
        return $this->hasMany(Event::class, 'spot_id', 'id');
    }
}
