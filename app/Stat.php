<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'sales', 'commissions', 'views',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
