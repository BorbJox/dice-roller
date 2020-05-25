@extends('layout')

@section('title')
Session {{ $session->name }}
@endsection

@section('includes')
@parent
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
@endsection

@section('content')
<div class="containter p-5">
    <div class="row">
        
        <div class="col-auto py-2">
            Session {{ $session->name }}
        </div>

        <div class="col-auto">    
            <div class="form-group">                    
                <div class="input-group">
                    <input 
                    type="text"
                    class="form-control"
                    id="roll_input"
                    placeholder="2d6">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" id="add_roll">Roll</button>
                    </div>
                </div>
                <div class="invalid-feedback" id="roll_feedback"></div>
            </div>
        </div>

        <div class="col-auto">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle mb-3" type="button" data-toggle="dropdown">
                    Users
                </button>
                <div class="dropdown-menu" id="users_output"></div>
            </div>
        </div>

        <div class="col">
            <button type="button" class="btn btn-secondary mb-3" id="refresh_btn"><i class="fas fa-sync-alt"></i></button>
        </div>
    </div>
        
    <div class="row">
        <div class="col-12 p-4 cork-board">
            <h5>Rolls:</h5>
            <ul id="rolls_output"></ul>
        </div>
    </div>
</div>


<script>
    $(function() {
        $('#roll_input').keypress(function() {
            $('#roll_input').removeClass('is-invalid');
            $('#roll_feedback').text('').hide();
        }).change(function() {
            $('#roll_input').removeClass('is-invalid');
            $('#roll_feedback').text('').hide();
        });

        $('#add_roll').click(function() {
            $('#roll_feedback').text('').hide();
            $('#roll_input').removeClass('is-invalid');

            $.ajax({
                method: 'POST',
                url: '/roll/create',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'input': $('#roll_input').val()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#roll_feedback').text(jqXHR.responseJSON.message).show();
                    $('#roll_input').addClass('is-invalid');
                },
                success: function(data) {
                    $('#roll_feedback').text('').hide();
                    $('#roll_input').removeClass('is-invalid');
                    updateRolls();
                }
            })
        });

        $('#refresh_btn').click(function() {
            updateUsers();
            updateRolls();
        });

        updateUsers();
        updateRolls();

        setInterval(updateUsers, 60000);
        setInterval(updateRolls, 10000);
    });

    function updateRolls() {
        $.get('/rolls', function(rolls) {
            $('#rolls_output').html('');
            rolls.forEach(function(roll) {

                var outputs = roll.output.split('[');


                $('#rolls_output').append('<li>'+
                    '<span class="roll-time">('+roll.time+')</span> '+
                    '<span class="roll-user">'+roll.user+':</span> '+
                    '<span class="roll-input">'+roll.input+' =</span> '+
                    '<span class="roll-output">'+outputs[0]+'</span>'+
                    '<span class="roll-output-expanded">['+outputs[1]+'</span>'+
                    '</li>');
            });
        });
    }

    function updateUsers() {
        $.get('/users', function(users) {
            $('#users_output').html('');
            users.forEach(function(user) {
                $('#users_output').append('<button class="dropdown-item" type="button">'+user+'</button>');
            });
        });
    }

</script>

@endsection
