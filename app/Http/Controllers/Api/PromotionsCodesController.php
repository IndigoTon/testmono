<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreatePromotionCodesResource;
use App\Http\Resources\PromotionsCodesResource;
use App\PromotionsCodes;
use \App\Http\Controllers\Api\BaseController as BaseController;

use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PromotionsCodesController extends BaseController
{
    public function index()
    {
        $promotions_codes = PromotionsCodes::getAll()->get();
        return $this->sendResponse(PromotionsCodesResource::collection($promotions_codes), 'List all promocodes!');
    }
    public function store(Request $request){

        $input = $request->all();
        $validator = Validator::make($input, [
            'start_date' => 'required|date|after:tomorrow',
            'end_date' => 'required|date|after:start_date',
            'amount' => 'required|integer',
            'quota' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Bad implementation, could not quickly find the right method in Faker Lib
        $input['code'] = $this->RandomCode();
        $promotions_code = PromotionsCodes::create($input);
        return $this->sendResponse(new CreatePromotionCodesResource($promotions_code), 'Promotion codes successeful created');
    }
    function RandomCode(){
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle(str_repeat($pool, 5)), 0, 12);
        if(PromotionsCodes::where('code', $code)->exists())
            $this->RandomCode();
        return $code;

    }
    public function show($id){
        try {

            $promotion_codes = PromotionsCodes::find($id);

            if(is_null($promotion_codes)) throw new \Exception('Promotions codes not found!');
            return $this->sendResponse(new PromotionsCodesResource($promotion_codes), 'Promotions codes founded!');
        }
        catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }

    }
    public function update(){

    }
    public function delete(){

    }
    public function assign_promotion(Request  $request){
        try {
            DB::beginTransaction();
            $input = $request->all();
            $validator = Validator::make($input, [
                'code' => 'required|string|min:12|max:12',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $promotions_codes = \App\PromotionsCodes::findByCode($input['code']);
            if(!$promotions_codes) throw new \Exception('Code not found!');

            if(\App\PromotionsCodesUsed::checkPromoByUser($promotions_codes->id, auth()->user()->id))
                throw new \Exception('The user has already used a promo');

            \App\PromotionsCodesUsed::create([
                'promotion_codes_id' => $promotions_codes->id,
                'user_id' => auth()->user()->id
            ]);

            $promotions_codes->useCode();
            \App\Wallet::put(auth()->user()->id, $promotions_codes->amount);
            DB::commit();

            return $this->sendResponse(null, null);
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->sendError($exception->getMessage());
        }

    }
}
