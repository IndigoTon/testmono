<?php

namespace App;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Model;

class PromotionsCodesUsed extends Model
{
    use Userable;
    protected $table = 'promotions_codes_used';

    protected $fillable = [
        'promotion_codes_id', 'user_id'
    ];

    static function checkPromoByUser(int $promotion_codes_id, int $user_id){
        return self::where('promotion_codes_id', $promotion_codes_id)->where('user_id', $user_id)->exists();
    }
}
