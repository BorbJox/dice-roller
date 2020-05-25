@extends('form')

@section('title')
Join Session
@endsection

@section('form-content')
            <h4>Join Session</h4>

            <form method="POST" action="/session/join">
                @csrf
                <div class="form-group">
                    <label for="session_name">Session Name</label>
                    <input 
                        type="text"
                        class="form-control @error('session_name') is-invalid @enderror"
                        id="session_name"
                        name="session_name"
                        value="{{ old('session_name') ? old('session_name') : $session_name }}">
                    <div class="invalid-feedback">{{ $errors->first('session_name') }}</div>
                </div>
                <div class="form-group">
                    <label for="player_name">Player Name</label>
                    <input 
                        type="text"
                        class="form-control @error('player_name') is-invalid @enderror"
                        id="player_name"
                        name="player_name"
                        placeholder="Your Name"
                        value="{{ old('player_name') }}">
                    <div class="invalid-feedback">{{ $errors->first('player_name') }}</div>
                </div>
                <button type="submit" class="btn btn-primary">Join Session</button>
            </form>
@endsection
