<?php

namespace App;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Model;

class PromotionsCodes extends Model
{
    protected $fillable = [
        'start_date', 'end_date', 'amount', 'quota', 'code'
    ];
    use Userable;


    public function users_used(){
        return $this->hasMany(PromotionsCodesUsed::class, 'promotion_codes_id', 'id');
    }
    public function useCode(){
        $this->quota_used += 1;
        if($this->quota_used == $this->quota) $this->status = 'used';
        $this->save();
    }
    static function findByCode(string $code){
        return self::getAll()->where('code', $code)->first();
    }
    static function code_exists(string $code){
        return self::where('code', $code)->exists();
    }

    static function getAll(){
        return self::where('status', 'active');
    }
}
