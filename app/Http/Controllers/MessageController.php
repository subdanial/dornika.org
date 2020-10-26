<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\CreateMessage;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.messages.list');
    }

    public function ajax_index()
    {
        return Datatables::of(Message::query())
            ->editColumn('created_at', function (Message $m)
            {
                return $m->created_at->diffForHumans();
            })
            ->addColumn('action', function (Message $m)
            {
                $parent = $m->parent ? $m->parent->id : '';
                $out = '<div class="btn-group btn-block" role="group" aria-label="">';
                $out .= '<button type="button" class="btn btn-secondary editMessage" data-message-id="' . $m->id . '" data-message-title="' . $m->title . '" data-message-description="' . $m->description . '"><i class="fa fa-pencil-alt"></i></button>';
                $out .= '<button type="button" class="btn btn-dark deleteMessage" data-message-id="' . $m->id . '"><i class="fa fa-times"></i></button>';
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
        return view('dashboard.messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMessage $request)
    {
        Message::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        
        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return view('dashboard.messages.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        unset($validated['id']);

        Message::where('id', $request->id)->update($validated);
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

        Message::destroy($request->id);
        return response()->json(['success' => true], 200);
    }
}
