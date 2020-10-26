<?php

namespace App\Http\Controllers;

use App\Cart, App\Stat;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.carts.list');
    }
    
    public function ajax_index()
    {
        return Datatables::of(Cart::All())
            ->editColumn('created_at', function (Cart $m)
            {
                return $m->updated_at->diffForHumans();
            })
            ->addColumn('user', function (Cart $m)
            {
		if($m->user)
                return $m->user->name;
		else
		return '-';
            })
            ->addColumn('client', function (Cart $m)
            {
             if($m->client)
                return $m->client->name;
		else
		return '-';
            })
            ->editColumn('price', function (Cart $m)
            {
                return number_format($m->price);
            })
            ->addColumn('action', function (Cart $m)
            {
                $out = '<div class="btn-group btn-block" role="group" aria-label="">';
                if ( $m->delivery == null || $m->delivery == 0 ) {
                    $out .= '<button type="button" class="btn btn-success changeDelivery" data-cart-id="' . $m->id . '"><i class="fa fa-check"></i></button>';
                } else {
                    $out .= '<button type="button" class="btn btn-danger changeDelivery" data-cart-id="' . $m->id . '"><i class="fa fa-stop-circle"></i></button>';
                }
                $out .= '<a href="' . route('orders.show', $m->id) .'" class="btn btn-secondary"><i class="fa fa-eye"></i></a>';
                $out .= '<button type="button" class="btn btn-warning returnCart" data-cart-id="' . $m->id . '"><i class="fa fa-undo-alt"></i></button>';
                $out .= '<button type="button" class="btn btn-dark deleteCart" data-cart-id="' . $m->id . '"><i class="fa fa-times"></i></button>';
                $out .= '</div>';
                return $out;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $order)
    {
        if ( $order->status == 0 ) {
            abort(404);
        }

        return view('dashboard.carts.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $cart = Cart::where('id', $request->id)->first();
        $cart->items()->delete();
        $cart->delete();
        return response()->json(['success' => true], 200);
    }

    public function orders_return(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required'
        ]);
        $cart = Cart::where('id', $validated['id'])->first();
        $cart->status = 0;
        $cart->save();

        return redirect()->route('orders');
    }

    public function invoice(Cart $cart)
    {
        return view('invoice', compact('cart'));
    }

    public function delivery(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $cart = Cart::where('id', $request->id)->first();
        if ( !$cart->delivery || $cart->delivery == 0 ) {
            $cart->delivery = 1;
        } else {
            $cart->delivery = 0;
        }

        $cart->save();

        return redirect()->route('orders');
    }
}
