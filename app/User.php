<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'fname', 'lname'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function attachProduct($pid)
    {
        $relation = ProductUser::create([
            'user_id' => $this->id,
            'product_id' => $pid
        ]);

        if (!$relation) {
            return response('', 404);
        }

        return response('success', 200);
    }

    public function detachProduct($pid)
    {
        $relation = ProductUser::whereUserId($this->id)
            ->whereProductId($pid)
            ->first();

        if (!$relation) {
            return response('', 404);
        }

        $relation->delete();
        return response('success', 200);
    }
}
