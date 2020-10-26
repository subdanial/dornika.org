<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use App\Category;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('parent_id', null)->get();
        return view('dashboard.categories.list', compact('categories'));
    }

    public function ajax_index()
    {
        return Datatables::of(Category::query())
            ->editColumn('created_at', function (Category $m)
            {
                return $m->created_at->diffForHumans();
            })
            ->addColumn('parent', function (Category $m)
            {
                return $m->parent ? $m->parent->title : 'مشخص نشده';
            })
            ->addColumn('action', function (Category $m)
            {
                $parent = $m->parent ? $m->parent->id : '';
                $out = '<div class="btn-group btn-block" role="group" aria-label="">';
                $out .= '<button type="button" class="btn btn-secondary editCat" data-cat-id="' . $m->id . '" data-cat-name="' . $m->title . '" data-cat-parent="' . $parent . '" data-cat-image="' . $m->image . '"><i class="fa fa-pencil-alt"></i></button>';
                $out .= '<button type="button" class="btn btn-dark deleteCat" data-cat-id="' . $m->id . '"><i class="fa fa-times"></i></button>';
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
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategory $request)
    {
        $img = false;
        $create = [
            'title' => $request->title,
            'slug' => str_slug($request->title),
            'parent_id' => $request->parent,
        ];

        if ( isset( $request->image ) && !empty( $request->image ) ) {
            $file_name = str_slug($request->title) . '.' . $request->file('image')->getClientOriginalExtension();
            if (!file_exists(public_path() . '/images')) {
                mkdir(public_path() . '/images', 666, true);
            }

            if ( file_exists( public_path() . "/images/" . $file_name ) ) {
                unlink( public_path() . "/images/" . $file_name );
            }

            $img = Image::make($request->file('image'));
            $img->fit(500);
            $img->save(public_path() . "/images/" . $file_name);
            $create['image'] = 'images/' . $file_name;
        }

        Category::create($create);
        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'title' => 'required',
            'parent_id' => 'nullable',
            'image' => 'nullable',
        ]);

        if ( isset( $request->image ) && !empty( $request->image ) ) {
            $file_name = str_slug($request->title) . '.' . $request->file('image')->getClientOriginalExtension();
            if (!file_exists(public_path() . '/images')) {
                mkdir(public_path() . '/images', 666, true);
            }

            if ( file_exists( public_path() . "/images/" . $file_name ) ) {
                unlink( public_path() . "/images/" . $file_name );
            }

            $img = Image::make($request->file('image'));
            $img->fit(500);
            $img->save(public_path() . "/images/" . $file_name);
            $validated['image'] = 'images/' . $file_name;
        }

        unset($validated['id']);

        Category::where('id', $request->id)->update($validated);
        return response()->json(['success' => true], 200);
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

        $cat = Category::where('id', $request->id)->first();
        $new_cat = Category::where('id', '!=', $request->id)->first();
        if ( !$new_cat ) {
            $new_cat = Category::create([
                'title' => 'دسته بندی نشده',
                'slug' => str_slug('uncategorized', '-')
            ]);
        }

        $products = $cat->products()->get();
        foreach ($products as $product) {
            $product->category()->associate($new_cat);
            $product->save();
        }

        $cat->destroy($request->id);

        return response()->json(['success' => true], 200);
    }
}
