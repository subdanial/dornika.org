<?php

namespace App\Http\Controllers;

use Image;
use App\Product, App\Category;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.products.list');
    }

    public function ajax_index()
    {
        return Datatables::of(Product::query())
            ->editColumn('created_at', function (Product $m)
            {
                return $m->created_at->diffForHumans();
            })
            ->editColumn('image', function (Product $m)
            {
                return asset($m->image);
            })
            ->addColumn('category', function (Product $m)
            {
                return $m->category->title;
            })
            ->addColumn('action', function (Product $m)
            {
                $parent = $m->parent ? $m->parent->id : '';
                $out = '<div class="btn-group btn-block" role="group" aria-label="">';
                $out .= '<a href="' . route('products.single', $m->slug) . '" target="_blank" class="btn btn-info"><i class="fa fa-eye"></i></a>';
                $out .= '<a href="' . route('products.edit', $m->id) . '" class="btn btn-secondary editCat"><i class="fa fa-pencil-alt"></i></a>';
                $out .= '<button type="button" class="btn btn-dark deleteProduct" data-product-id="' . $m->id . '"><i class="fa fa-times"></i></button>';
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
        $category = Category::whereNull('parent_id')->get();
        $categories = [];
        foreach ($category as $cat) {
            $out = [
                'label' => $cat['title'],
                'value' => $cat->id,
            ];

            if ( $cat->children ) {
                foreach ($cat->children as $value) {
                    $out['childrens'][] = [
                        'label' => $value->title,
                        'value' => $value->id,
                    ];
                }
            }

            $categories[] = $out;
        }

        $categories = json_encode($categories);

        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProduct $request)
    {
        $img = Image::make($request->image);
        $img->fit(500, 500);
        $name = '/images/' . time() . '.jpg';
        $img->save(public_path() . $name);

        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $name,
            'slug' => str_slug($request->title),
            'price_1' => $request->price_1,
            'price_2' => $request->price_2,
            'price_3' => $request->price_3,
            'price_4' => $request->price_4,
            'consumer' => $request->consumer,
            'number_in_box' => $request->number_in_box,
            'available' => $request->available,
            'category_id' => $request->category_id,
            'commission' => $request->commission,
        ]);

        if ( $request->ajax() ) {
            return response()->json(['success' => true], 200);
        } else {
            return redirect()->route('products.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // return view('dashboard.products.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $category = Category::whereNull('parent_id')->get();
        $categories = [];
        foreach ($category as $cat) {
            $out = [
                'label' => $cat['title'],
                'value' => $cat->id,
            ];

            if ( $cat->children ) {
                foreach ($cat->children as $value) {
                    $out['childrens'][] = [
                        'label' => $value->title,
                        'value' => $value->id,
                    ];
                }
            }

            $categories[] = $out;
        }

        $categories = json_encode($categories);

        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable',
            'price_1' => 'required',
            'price_2' => 'required',
            'price_3' => 'required',
            'price_4' => 'required',
            'consumer' => 'required',
            'number_in_box' => 'required',
            'available' => 'required',
            'category_id' => 'nullable',
            'commission' => 'required',
        ]);

        if ( isset( $validated['image'] ) ) {
            $img = Image::make($request->image);
            $img->fit(500, 500);
            $name = '/images/' . time() . '.jpg';
            $img->save(public_path() . $name);
            $validated['image'] = $name;
        }

        $product->update($validated);

        if ( $request->ajax() ) {
            return response()->json(['success' => true], 200);
        } else {
            return redirect()->route('products.index');
        }
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

        $product = Product::where('id', $request->id)->first();
		
		if ( $product ) {
			$product->f_prices()->delete();
			$product->items()->delete();
			$product->stats()->delete();
			
			$product->delete();
		}
		
        return response()->json(['success' => true], 200);
    }
}
