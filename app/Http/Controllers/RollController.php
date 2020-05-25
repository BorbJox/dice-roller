<?php

namespace App\Http\Controllers;

use App\Roll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $output = [];
            $rolls = \App\Session::find(Auth::user()->session_id)->rolls->sortByDesc('created_at')->take(25);
            foreach($rolls as $roll) {
                $output[] = [
                    'input' => $roll->input,
                    'output' => $roll->output,
                    'time' => date('H:i', strtotime($roll->created_at)),
                    'user' => $roll->user->name
                ];
            }
            return response()->json($output);
                
        } else {
            return response()->json([]);
        }
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
        $request->validate([
            'input' => ['required', 'regex:/^\d*d\d+$/i']
        ]);

        if (Auth::check()) {
            $roll = new Roll(['input' => request('input'), 'user_id' => Auth::user()->id]);
            $roll->processInput();
            $roll->save();
            return 'OK';
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Roll  $roll
     * @return \Illuminate\Http\Response
     */
    public function show(Roll $roll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roll  $roll
     * @return \Illuminate\Http\Response
     */
    public function edit(Roll $roll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Roll  $roll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roll $roll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roll  $roll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roll $roll)
    {
        //
    }
}
