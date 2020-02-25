<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UpgradeRequests extends Model
{
//    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'upgrade_code', 'request_status'
    ];

    //get user detail
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
