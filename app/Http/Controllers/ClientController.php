<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateClient;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.clients.list');
    }

    public function ajax_index()
    {
        return Datatables::of(Client::query())
            ->editColumn('created_at', function (Client $m)
            {
                return $m->created_at->diffForHumans();
            })
            ->addColumn('user', function (Client $m)
            {
                return $m->user->name;
            })
            ->addColumn('action', function (Client $m)
            {
                $parent = $m->parent ? $m->parent->id : '';
                $out = '<div class="btn-group btn-block" role="group" aria-label="">';
                $out .= '<button type="button" class="btn btn-secondary editClient" data-client-id="' . $m->id . '" data-client-name="' . $m->name . '" data-client-phone="' . $m->phone . '" data-client-address="' . $m->address . '"><i class="fa fa-pencil-alt"></i></button>';
                $out .= '<button type="button" class="btn btn-dark deleteClient" data-client-id="' . $m->id . '"><i class="fa fa-times"></i></button>';
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
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClient $request)
    {
        Client::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('dashboard.clients.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('dashboard.clients.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        unset($validated['id']);

        Client::where('id', $request->id)->update($validated);
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

        Client::destroy($request->id);
        return response()->json(['success' => true], 200);
    }
}
