<?php

namespace App\Http\Controllers;

use App\Category, App\Product, App\Item, App\Message, App\Client, App\User, App\Stat;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\AddToCart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'categories', 'index'
        ]]);

        $catalogs = Category::whereNull('parent_id')->get();
        view()->share('catalogs', $catalogs);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $products1 = Stat::orderBy('sales', 'DESC')->take(5)->get();
        $products2 = Product::orderby('created_at', 'Desc')->take(5)->get();
        $products3 = Stat::orderBy('commissions', 'DESC')->take(5)->get();

        $sales = Stat::sum('sales');
        $commissions = Stat::sum('commissions');
        $visitors = User::whereHas("roles", function($q){ $q->where("name", "visitor"); })->count();
        $clients = Client::all()->count();

        return view('home', compact('products1', 'products2', 'products3', 'sales', 'visitors', 'clients', 'commissions'));
    }

    /**
     * Show the application index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Archives.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categories($category = null, $sub_category = null)
    {
        $products = Product::query();
        $categories = Category::whereNull('parent_id')->get();
        $sub_categories = null;
        
        if ( !$category ) {
            return view('categories-index', compact('categories'));
        }

        if ( $category ) {
            $sub_categories = Category::where('parent_id', $category)->get();
            if ( !$sub_category ) {
                $products->whereHas('category', function($q) use($category) {
                    $q->where('parent_id', '=', $category);
                });
            }
        }

        if ( $sub_category ) {
            $products->where('category_id', $sub_category);
        }

        $products = $products->paginate();

        return view('categories', compact('category', 'sub_category', 'sub_categories', 'products', 'categories'));
    }

    public function single($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if ( !$product ) {
            abort(404);
        }
        
        $stat = Stat::where('product_id', $product->id)->first();
        if ( $stat ) {
            $stat->views = intval( $stat->views + 1 );
            $stat->save();
        } else {
            $stat = Stat::create([
                'product_id' => $product->id,
                'views' => 1,
                'sales' => 0,
                'commissions' => 0
            ]);
        }

        return view('single', compact('product'));
    }

    public function cart()
    {
        $user = auth()->user();
        // $has_cart = $user->carts()->orderBy('created_at', 'desc')->first();
        $has_cart = $user->carts()->where('status', 0)->first();
        // dd($has_cart);
        if ( $has_cart && $has_cart->status == 0 && $has_cart->price > 0 ) {
            $cart = $has_cart;
        } else {
            $cart = false;
        }

        return view('cart', compact('cart'));
    }

    public function order(AddToCart $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if ( !$product ) {
            abort(404);
        }

        $validated = $request->validated();

        if ( !isset($validated['box']) || $validated['box'] == null ) {
            $validated['box'] = 0;
        }

        if ( !isset($validated['number']) || $validated['number'] == null ) {
            $validated['number'] = 0;
        }

        $user = auth()->user();

        if ( $validated['box'] ) {
            $validated['number'] = $validated['number'] + ( $validated['box'] * $product->number_in_box );
        }

        $cart = $user->carts()->where('status', 0)->first();
        if ( $cart && $cart->status == 0 ) {
            $exist_item = $cart->items()->where('product_id', $product->id)->first();

            if ( $exist_item ) {
                $exist_item->number = $exist_item->number + $validated['number'];
                $exist_item->box = 0;
                $exist_item->save();
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'number' => $validated['number'],
                    'box' => 0,
                ]);
            }

            $price = 0;
            $commission = 0;
            foreach ($cart->items as $item) {
                $price = $price + $item->calculatePrice();
                $commission = $commission + $item->calculateCommission();
            }

            $cart->price = $price;
            $cart->commission = $commission;
            $cart->save();
        } else {
            $cart = $user->carts()->create([
                'client_id' => $validated['client'],
                'price' => 0,
                'commission' => 0,
                'status' => 0,
            ]);
            $cart->items()->create([
                'product_id' => $product->id,
                'number' => $validated['number'],
                'box' => 0,
            ]);

            $price = 0;
            $commission = 0;
            foreach ($cart->items as $item) {
                $price = $price + $item->calculatePrice();
                $commission = $commission + $item->calculateCommission();
            }

            $cart->price = $price;
            $cart->commission = $commission;
            $cart->save();
        }

        if ( $request->ajax ) {
            return response()->json(['success' => true], 200);
        } else {
            return redirect()->route('cart')->with('message', 'با موفقیت به سبد خرید افزوده شد.');
        }
    }

    public function reset($slug)
    {
        $product = Product::where('slug', $slug)->first();
        auth()->user()->f_prices()->where('product_id', $product->id)->delete();

        return redirect()->route('products.single', $product->slug);
    }

    public function fake_price(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if ( !$product ) {
            abort(404);
        }

        $validated = $request->validate([
            'fake_price' => 'integer|min:100|min:' . $product->price_4
        ]);

        auth()->user()->f_prices()->updateOrCreate(['product_id' => $product->id], [
            'price' => $validated['fake_price']
        ]);

        return redirect()->route('products.single', $product->slug);
    }

    public function calculatePrice($number, $box, $product)
    {
        if ( $number == 0 && $box == 0 ) {
            return 0;
        }

        $boxes = floor($number / $product->number_in_box);
        // $box = $this->box ? $product->number_in_box * $this->box : 0;
        // $number = $number + $box;
        if ( $boxes == 0 ) {
            if ( $number <= 1 ) {
                return $product->price_one;
            } else {
                return $number * $product->price_one;
            }
        } elseif ( $boxes >= 1 && $boxes <= 5 ) {
            return $number * $product->price_two;
        } elseif ( $boxes > 5 && $boxes <= 10 ) {
            return $number * $product->price_three;
        } else {
            return $number * $product->price_four;
        }
    }

    public function calculateCommission($number, $box, $product)
    {
        // $box = $box ? $product->number_in_box * $box : 0;
        // $number = $number + $box;
        return intval( (( $product->price_1 * $product->commission ) / 100) * $number );
    }

    public function removeItem(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        
        $item = Item::where('id', $request->id)->first();
        if ( !$item || $item->cart->status == 1 ) {
            abort(404);
        }

        $cart = $item->cart;
        // $price = $cart->price - $item->calculatePrice();
        // $cart->price = $price < 0 ? 0 : $price;
        // $cart->save();
        
        $item->destroy($item->id);
        
        $price = 0;
        $commission = 0;
        if ( $cart->items()->count() != 0 ) {
            foreach ($cart->items as $item) {
                $price = $price + $item->calculatePrice();
                $commission = $commission + $item->calculateCommission();
            }
        }

        $cart->price = $price;
        $cart->commission = $commission;
        $cart->save();

        if ( $cart->items()->count() == 0 ) {
            $cart->delete();
            return response()->json(['success' => true, 'price' => number_format($cart->price), 'commission' => number_format($cart->commission), 'reload' => true], 200);
        }

        return response()->json(['success' => true, 'price' => number_format($cart->price), 'commission' => number_format($cart->commission)], 200);
    }

    public function saveCart(Request $request)
    {
        $user = auth()->user();
        $cart = $user->carts()->where('status', 0)->first();
        if ( !$cart || $cart->status == 1 || $cart->items->count() == 0 ) {
            return response()->json(['message' => 'سبد خرید خالی میباشد.'], 404);
        } else {

            foreach ($cart->items as $item) {
                $box = $item->box ? $item->product->number_in_box * $item->box : 0;
                $number = $item->number + $box;
                if ( $item->number > $item->product->available ) {
                    return response()->json(['message' => $item->product->title . ' اندازه سفارش شما وجود ندارد. لطفا تعداد محصول مورد نظر را کم کنید.'], 404);
                }
            }

            $cart->status = 1;
            $cart->save();

            foreach ($cart->items as $item) {
                $box = $item->box ? $item->product->number_in_box * $item->box : 0;
                $number = $item->number + $box;
                $product = $item->product;
                $product->available = $product->available - $number;
                $product->save();

                $item->pp = $item->singlePrice();
                $item->cp = $item->calculatePrice();
                $item->save();

                $stat = Stat::where('product_id', $item->product->id)->first();
                if ( $stat ) {
                    $stat->sales = intval( $stat->sales + $this->calculatePrice($item->number, $item->box, $product) );
                    $stat->commissions = intval( $stat->commissions + $this->calculateCommission($item->number, $item->box, $product) );
                    $stat->save();
                } else {
                    $stat = Stat::create([
                        'product_id' => $item->product->id,
                        'sales' => $this->calculatePrice($item->number, $item->box, $product),
                        'commissions' => $this->calculateCommission($item->number, $item->box, $product)
                    ]);
                }
            }

            return response()->json(['success' => true, 'redirect' => route('orders')], 200);
        }
        
    }

    public function changeItem(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'number' => 'required|integer',
            'item' => 'required|integer',
            'cart' => 'required|integer',
        ]);
        if ( $validated['number'] < 0 ) {
            $validated['number'] = 1;
        }
        $cart = $user->carts()->where('id', $validated['cart'])->first();
        $item = $cart ? $cart->items()->where('id', $validated['item'])->first() : false;

        if ( $item ) {
            $box = intval($item->number / $item->product->number_in_box);
            $number = $validated['number'] + ($box * $item->product->number_in_box);
            $item->number = $number;
            $item->save();

            $price = 0;
            $commission = 0;
            foreach ($cart->items as $it) {
                $price = $price + $it->calculatePrice();
                $commission = $commission + $it->calculateCommission();
            }
            
            $cart->price = $price;
            $cart->commission = $commission;
            $cart->save();
            
            $box = intval($item->number / $item->product->number_in_box);
            $number = $item->number - ($box * $item->product->number_in_box);
            return response()->json(['success' => true, 'number' => $number, 'box' => $box, 'item_price' => number_format($item->calculatePrice()) . ' تومان', 'price' => number_format( $price ), 'commission' => number_format( $commission )], 200);
        } else {
            abort(404);
        }
    }

    public function changeItemBox(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'box' => 'required|integer',
            'item' => 'required|integer',
            'cart' => 'required|integer',
        ]);
        if ( $validated['box'] < 0 ) {
            $validated['box'] = 1;
        }
        $cart = $user->carts()->where('id', $validated['cart'])->first();
        $item = $cart ? $cart->items()->where('id', $validated['item'])->first() : false;
        if ( $item ) {
            $number = intval($validated['box'] * $item->product->number_in_box) + $item->calculateQuantity('num');
            $item->number = $number;
            $item->save();

            $price = 0;
            $commission = 0;
            foreach ($cart->items as $it) {
                $price = $price + $it->calculatePrice();
                $commission = $commission + $it->calculateCommission();
            }

            $cart->price = $price;
            $cart->commission = $commission;
            $cart->save();

            $box = intval($item->number / $item->product->number_in_box);
            $number = $item->number - ($box * $item->product->number_in_box);
            return response()->json(['success' => true, 'number' => $number, 'box' => $box, 'item_price' => number_format($item->calculatePrice()) . ' تومان', 'price' => number_format( $price ), 'commission' => number_format( $commission )], 200);
        } else {
            abort(404);
        }
    }

    public function messages(Request $request)
    {
        $messages = Message::orderBy('created_at', 'desc')->paginate(10);
        return view('messages', compact('messages'));
    }

    /**
     * Display a listing of the clients.
     *
     * @return \Illuminate\Http\Response
     */
    public function clients()
    {
        return view('clients');
    }

    public function ajax_clients()
    {
        $user = auth()->user();
        return Datatables::of($user->clients)
            ->editColumn('created_at', function (Client $m)
            {
                return $m->created_at->diffForHumans();
            })
            ->addColumn('action', function (Client $m)
            {
                $parent = $m->parent ? $m->parent->id : '';
                $out = '<div class="btn-group btn-block" role="group" aria-label="">';
                $out .= '<button type="button" class="btn btn-secondary editClient" data-client-id="' . $m->id . '" data-client-name="' . $m->name . '" data-client-address="' . $m->address . '" data-client-phone="' . $m->phone . '"><i class="fa fa-pencil-alt"></i></button>';
                $out .= '<button type="button" class="btn btn-dark deleteClient" data-client-id="' . $m->id . '"><i class="fa fa-times"></i></button>';
                $out .= '</div>';
                return $out;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function clients_store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $user->clients()->create([
            'name' => $request->name,
            'slug' => str_slug( $request->name ),
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json(['success' => true], 200);
    }

    public function clients_update(Request $request, Client $client)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        unset($validated['id']);

        Client::where('id', $request->id)->where('user_id', $user->id)->update($validated);
        return response()->json(['success' => true], 200);
    }

    public function clients_destroy(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'id' => 'required'
        ]);

        $client = Client::where('id', $request->id)->where('user_id', $user->id)->first();
        if ( !$client ) {
            abort(404);
        }

        Client::destroy($request->id);
        return response()->json(['success' => true], 200);
    }

    public function profile($username)
    {
        $user = User::where('username', $username)->first();
        if ( !$user ) {
            abort(404);
        }

        $carts = $user->carts()->where('status', 1)->orderBy('created_at', 'ASC')->get();
        $sales_number = 0;
        $sales = 0;
        $last_sale = 0;
        $total_com = 0;
        $last_com = 0;
        if ( $carts->isNotEmpty() ) {
            foreach ($carts as $cart) {
                $last_sale = $cart->price;
                $last_com = $cart->commission;
                $sales = $sales + $cart->price;
                $total_com = $total_com + $cart->commission;
                if ( $cart->items->isNotEmpty() ) {
                    foreach ($cart->items as $item) {
                        $sales_number = $sales_number + $item->number;
                    }
                }
            }
        }

        return view('profile', compact('user', 'sales_number', 'sales', 'last_sale', 'total_com', 'last_com'));
    }

    public function selling()
    {
        $products = Stat::orderBy('sales', 'DESC')->paginate(10);
        return view('archives.selling', compact('products'));
    }

    public function viewed()
    {
        $products = Stat::orderBy('views', 'DESC')->paginate(10);
        return view('archives.viewed', compact('products'));
    }

    public function latest()
    {
        $products = Product::orderby('created_at', 'Desc')->paginate(10);
        return view('archives.latest', compact('products'));
    }

    public function orders()
    {
        $orders = auth()->user()->carts()->where('status', 1)->paginate(15);
        return view('orders', compact('orders'));
    }

    public function orders_cancel(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required'
        ]);
        $cart = auth()->user()->carts()->where('id', $validated['cart_id'])->first();
        $cart->status = 2;
        $cart->save();

        foreach ($cart->items as $item) {
            $product = $item->product;
            $product->available = $product->available + $item->number;
            $product->save();
        }

        return redirect()->route('orders');
    }

    public function orders_return(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required'
        ]);
        $user = auth()->user();
        $has_cart = $user->carts()->where('status', 0)->first();
        if ( $has_cart && $has_cart->status == 0 && $has_cart->price > 0 ) {
            return redirect()->back()->withErrors(['سبد خرید شما درحال حاضر پر میباشد.']);
        } else {
            $cart = $user->carts()->where('id', $validated['cart_id'])->first();
            $cart->status = 0;
            $cart->save();

            foreach ($cart->items as $item) {
                $product = $item->product;
                $product->available = $product->available + $item->number;
                $product->save();
            }
    
            return redirect()->route('cart');
        }

    }

    public function saveSettings(Request $request)
    {
        $user = auth()->user();
        if ( isset( $request->commission ) ) {
            $user->setSetting('commission', true);
        } else {
            $user->setSetting('commission', false);
        }

        if ( isset( $request->fake_price ) ) {
            $user->setSetting('fake_price', true);
        } else {
            $user->setSetting('fake_price', false);
        }

        $user->save();

        return redirect()->back();
    }
}
