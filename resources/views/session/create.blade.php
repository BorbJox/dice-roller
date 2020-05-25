@extends('form')

@section('title')
Create Session
@endsection

@section('form-content')
            <h4>New Session</h4>

            <form method="POST" action="">
                @csrf
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
                <button type="submit" class="btn btn-primary">Create Session</button>
            </form>
@endsection
