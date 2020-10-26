<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_id', 'price', 'commission', 'status', 'delivery',
    ];

    // Relations

    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the post that owns the comment.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * Get the post that owns the comment.
     */
    public function items()
    {
        return $this->hasMany('App\Item');
    }
}
