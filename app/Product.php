<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'slug', 'image',
        'price_1', 'price_2', 'price_3', 'price_4', 'consumer',
        'number_in_box', 'available', 'category_id', 'commission'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['price_one', 'price_two', 'price_three', 'price_four'];

    public function getPriceOneAttribute($value)
    {
        $user = auth()->user();
        if ( $user && $user->setting('fake_price') ) {
            $fprice = $this->f_prices()->where('user_id', $user->id)->first();
            if ( $fprice ) {
                return $fprice->price;
            }
        }

        return $this->price_1;
    }

    public function getPriceTwoAttribute($value)
    {
        $user = auth()->user();
        if ( $user && $user->setting('fake_price') ) {
            $fprice = $this->f_prices()->where('user_id', $user->id)->first();
            if ( $fprice ) {
                return $fprice->price;
            }
        }

        return $this->price_2;
    }

    public function getPriceThreeAttribute($value)
    {
        $user = auth()->user();
        if ( $user && $user->setting('fake_price') ) {
            $fprice = $this->f_prices()->where('user_id', $user->id)->first();
            if ( $fprice ) {
                return $fprice->price;
            }
        }

        return $this->price_3;
    }

    public function getPriceFourAttribute($value)
    {
        $user = auth()->user();
        if ( $user && $user->setting('fake_price') ) {
            $fprice = $this->f_prices()->where('user_id', $user->id)->first();
            if ( $fprice ) {
                return $fprice->price;
            }
        }

        return $this->price_4;
    }

    /**
     * Get the category record associated with the product.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function stats()
    {
        return $this->hasMany('App\Stat');
    }

    public function items()
    {
        return $this->hasMany('App\Item');
    }

    public function f_prices()
    {
        return $this->hasMany('App\FPrice');
    }

}
