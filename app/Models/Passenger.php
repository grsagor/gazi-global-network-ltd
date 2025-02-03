<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($passenger) {
            $passenger->id = mt_rand(1000, 9999);
        });
    }

    public function agent() {
        return $this->belongsTo(User::class, 'agent_id')->withTrashed();
    }
    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
