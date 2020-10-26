<?php

namespace App\Http\Controllers;

use Image;
use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.users.list');
    }

    public function ajax_index()
    {
        $users = User::whereHas("roles", function($q){ $q->where("name", "visitor"); });
        return Datatables::of($users)
            ->editColumn('created_at', function (User $m)
            {
                return $m->created_at->diffForHumans();
            })
            ->editColumn('avatar', function (User $m)
            {
                return asset($m->avatar);
            })
            ->addColumn('action', function (User $m)
            {
                $parent = $m->parent ? $m->parent->id : '';
                $out = '<div class="btn-group btn-block" role="group" aria-label="">';
                $out .= '<a href="' . route('profile', $m->username) . '" class="btn btn-info"><i class="fa fa-eye"></i></a>';
                $out .= '<a href="' . route('visitors.edit', $m->id) . '" class="btn btn-secondary editCat"><i class="fa fa-pencil-alt"></i></a>';
                $out .= '<button type="button" class="btn btn-dark deleteUser" data-user-id="' . $m->id . '"><i class="fa fa-times"></i></button>';
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
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUser $request)
    {
        $new = [
            'name' => $request->name,
            'password' => bcrypt( $request->password ),
            'mobile' => $request->mobile,
            'email' => $request->email,
            'username' => $request->username,
        ];

        if ( isset( $request->avatar ) ) {
            $img = Image::make($request->avatar);
            $img->fit(500, 500);
            $name = '/images/' . time() . '.jpg';
            $img->save(public_path() . $name);
            $new['avatar'] = $name;
        }

        $user = User::create($new);
        $user->assignRole('visitor');

        if ( $request->ajax() ) {
            return response()->json(['success' => true], 200);
        } else {
            return redirect()->route('visitors.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('dashboard.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $user = User::where('id', $user)->first();
        if ( !$user ) {
            abort(404);
        }

        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $user = User::where('id', $user)->first();
        if ( !$user ) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required',
            'password' => 'nullable|min:6|confirmed',
            'mobile' => 'required|iran_mobile',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|is_not_persian|unique:users,username,' . $user->id,
            'avatar' => 'nullable|image',
        ]);

        if ( isset( $validated['avatar'] ) ) {
            $img = Image::make($request->avatar);
            $img->fit(500, 500);
            $name = '/images/' . time() . '.jpg';
            $img->save(public_path() . $name);
            $validated['avatar'] = $name;
        }

        if ( !$validated['password'] ) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);
        if ( $request->ajax() ) {
            return response()->json(['success' => true], 200);
        } else {
            return redirect()->route('visitors.index');
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

        $user = User::where('id', $request->id)->first();
		
		if ( $user ) {
			$user->f_prices()->delete();
			$user->clients()->delete();
			$user->carts()->delete();
			
			$user->delete();
		}
		
        return response()->json(['success' => true], 200);
    }
}
