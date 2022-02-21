<?php

namespace App;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use Userable;

    protected $table = 'wallet';

    protected $fillable = ['user_id', 'balance'];
    static function findByUserId(int $user_id){
        return self::where('user_id', $user_id)->first();
    }

    static function put(int $user_id, float $amount){
        $wallet = Wallet::findByUserId($user_id, $amount);
        $wallet -> balance += $amount;
        $wallet -> save();
    }

}
