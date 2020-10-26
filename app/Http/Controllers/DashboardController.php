<?php

namespace App\Http\Controllers;

use App\Cart, App\Product, App\User, App\Client, App\Stat;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function ajax_sales()
    {
        $products = [];
        $stats = Stat::orderBy('sales', 'DESC')->pluck('product_id')->toArray();

        return Datatables::of(Product::whereIn('id', $stats)->query())->make(true);
    }

    public function ajax_commissions()
    {
        $products = [];
        $stats = Stat::orderBy('commissions', 'DESC')->pluck('product_id')->toArray();

        return Datatables::of(Product::whereIn('id', $stats)->query())->make(true);
    }

    public function ajax_latest()
    {
        return Product::count();
    }

    public function ajax_visitors_number()
    {
        return User::whereHas("roles", function($q){ $q->where("name", "visitor"); })->count();
    }

    public function ajax_clients_number()
    {
        return Client::count();
    }

    public function ajax_total_sales()
    {
        $carts = Cart::all()->pluck('price')->toArray();
        return response()->json(['data' => array_sum($carts)], 200);
    }

    public function ajax_total_commissions()
    {
        $carts = Cart::all()->pluck('commission')->toArray();
        return response()->json(['data' => array_sum($carts)], 200);
    }
}
