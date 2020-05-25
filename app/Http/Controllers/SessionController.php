<?php

namespace App\Http\Controllers;

use App\Session;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name = '')
    {
        return view('session.join', [
            'session_name' => $name
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('session.create');
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
            'player_name' => ['required', 'max:255']
        ]);

        //Create session
        $session = new Session();
        $session->generateNewName();
        $session->save();

        //Add player to the session
        $player = new User();
        $player->name = request('player_name');
        $player->session()->associate($session);
        $player->save();

        //Set the player as current player
        Auth::loginUsingId($player->id);

        return redirect('/session/'.$session->name);
    }

    /**
     * Create a user and join an existing session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function join(Request $request)
    {
        $request->validate([
            'session_name' => ['required', 'min:5', 'max:5', 'exists:sessions,name'],
            'player_name' => ['required', 'max:255']
        ]);
        
        $session = Session::where('name', request('session_name'))->first();

        //Add player to the session
        $player = new User();
        $player->name = request('player_name');
        $player->session()->associate($session);
        $player->save();

        //Set the player as current player
        Auth::loginUsingId($player->id);
        
        return redirect('/session/'.strtoupper(request('session_name')));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {   
        $session = Session::where('name', $name)->first();
        if ($session) {
            if (Auth::check() && Auth::user()->session_id == $session->id) {
                return view('session.show', [
                    'session' => $session
                ]);
            } else {
                return redirect('/session/join/'.$session->name);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }

    public function users()
    {
        if (Auth::check()) {
            $output = [];
            $users = Session::find(Auth::user()->session_id)->users;
            foreach($users as $user) {
                $output[] = $user->name;
            }
            return response()->json($output);
                
        } else {
            return response()->json([]);
        }
    }

}
