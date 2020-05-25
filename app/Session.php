<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    public function generateNewName()
    {
        //Generate unique name
        $chars = 'ABCDEFGHJKLNPQRSTUVWXYZ123456789';
        $max = strlen($chars) - 1;
        do {
            $name = '';
            for ($i = 0; $i < 5; $i++) {
                $name .= $chars[mt_rand(0, $max)];
            }
        } while (Session::where('name', $name)->exists());

        $this->name = $name;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    

    public function rolls()
    {
        return $this->hasManyThrough('App\Roll', 'App\User');
    }
}
