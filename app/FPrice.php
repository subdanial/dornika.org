<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FPrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_id', 'price',
    ];

    /**
     * Get the post that owns the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the post that owns the product.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
