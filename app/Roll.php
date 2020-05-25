<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    protected $fillable = [
        'input', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->hasOneThrough('App\Sesion', 'App\User');
    }

    public function processInput()
    {
        //Process things like "4d10" into a dice roll like "James rolled 13! [2,6,1,4]" or "Elizabeth rolled 3 successes! [10,4,9,9]", if type is provided.
        $input = explode('d', $this->input);
        
        $count = intval($input[0]);
        $sides = intval($input[1]);

        if ($sides > getrandmax()) {
            $sides = getrandmax(); 
            $this->input = $count.'d'.$sides;
        }

        if ($count <= 0) {
            $count = 1;
        }

        if ($count >= 1000) {
            $count = 1000;
            $this->input = $count.'d'.$sides;
        }

        $rolls = [];
        for ($i = 0; $i < $count; $i++) {
            $rolls[] = rand(1, $sides);
        }
        
        $this->output = array_sum($rolls).' ['.implode(', ', $rolls).']';
    }
}
