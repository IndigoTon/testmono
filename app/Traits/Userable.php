<?php

namespace App\Traits;
use App\User;
trait Userable
{
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
