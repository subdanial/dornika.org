<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cart_id', 'product_id', 'number', 'box', 'pp', 'cp'
    ];
    
    /**
     * Get the post that owns the cart.
     */
    public function cart()
    {
        return $this->belongsTo('App\Cart');
    }

    /**
     * Get the post that owns the cart.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function calculatePrice()
    {

        if ( $this->number == 0 ) {
            return 0;
        }

        $boxes = floor($this->number / $this->product->number_in_box);
        // $box = $this->box ? $this->product->number_in_box * $this->box : 0;
        // $number = $this->number + $box;
        if ( $boxes == 0 ) {
            if ( $this->number <= 1 ) {
                return $this->product->price_one;
            } else {
                return $this->number * $this->product->price_one;
            }
        } elseif ( $boxes >= 1 && $boxes <= 5 ) {
            return $this->number * $this->product->price_two;
        } elseif ( $boxes > 5 && $boxes <= 10 ) {
            return $this->number * $this->product->price_three;
        } else {
            return $this->number * $this->product->price_four;
        }
    }

    public function singlePrice()
    {
        $boxes = floor($this->number / $this->product->number_in_box);
        // $box = $this->box ? $this->product->number_in_box * $this->box : 0;
        // $number = $this->number + $box;
        if ( $boxes == 0 ) {
            if ( $this->number <= 1 ) {
                return $this->product->price_one;
            } else {
                return $this->product->price_one;
            }
        } elseif ( $boxes >= 1 && $boxes <= 5 ) {
            return $this->product->price_two;
        } elseif ( $boxes > 5 && $boxes <= 10 ) {
            return $this->product->price_three;
        } else {
            return $this->product->price_four;
        }
    }

    public function realPrice()
    {
        $boxes = floor($this->number / $this->product->number_in_box);
        // $box = $this->box ? $this->product->number_in_box * $this->box : 0;
        // $number = $this->number + $box;
        if ( $boxes == 0 ) {
            if ( $this->number <= 1 ) {
                return $this->product->price_1;
            } else {
                return $this->product->price_1;
            }
        } elseif ( $boxes >= 1 && $boxes <= 5 ) {
            return $this->product->price_2;
        } elseif ( $boxes > 5 && $boxes <= 10 ) {
            return $this->product->price_3;
        } else {
            return $this->product->price_4;
        }
    }

    public function calculateCommission()
    {
        // $box = $this->box ? $this->product->number_in_box * $this->box : 0;
        // $number = $this->number + $box;
        // return intval( (( $this->product->price_1 * $this->product->commission ) / 100) * $number );
        return intval( (( $this->realPrice() * $this->product->commission ) / 100) * $this->number );
        // return intval( ($this->calculatePrice() * $this->product->commission) / 100 );
    }

    public function calculateQuantity( $target = 'num' )
    {
        // $box = $this->box ? $this->product->number_in_box * $this->box : 0;
        // return $this->number + $box;
        $box = intval($this->number / $this->product->number_in_box);
        $number = $this->number - ($box * $this->product->number_in_box);
        if ( $target == 'num' ) {
            return $number;
        } else {
            return $box;
        }
    }
}
