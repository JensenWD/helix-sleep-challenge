<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $guarded = [];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
