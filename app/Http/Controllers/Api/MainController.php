<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Avatar;
use App\Models\Bet;
use Session;
use Stripe;

class MainController extends Controller
{
    public function get_avatars()
    {
        $avatars = Avatar::all(['id', 'avatar_image']);

        if(!empty($avatars))
        {
            foreach($avatars as $avatar)
            {
                $avatar->avatar_image = IMAGE_URL.$avatar->avatar_image;
            }
        }

        return response()->json([
            'status' => true,
            'message' => $avatars->count() > 0 ? 'Avatars Found' : 'No Avatar Found',
            'data' => $avatars->count() > 0 ? $avatars : [],
        ], 200); 
    }

    public function create_bet(Request $request)
    {
        try{
            $stripe = new \Stripe\StripeClient(
                'pk_test_crwKgwLBaPlD6PyegWa6ln6E00AowPrKUI'
            );
              
            $token = $stripe->tokens->create([
                'card' => [
                  'number' => $request->card_number,
                  'exp_month' => $request->exp_month,
                  'exp_year' => $request->exp_year,
                  'cvc' => $request->cvv,
                ],
            ]);

            Stripe\Stripe::setApiKey('sk_test_BHlJPzC6PloLo7ELEKksI1uy00LlQbLa2X');

            $pay = Stripe\Charge::create ([
                "amount" => 100 * (int)$request->first_player_bet_amount,
                "currency" => "USD",
                "source" => $token->id,
                "description" => "Bet Payment",
                // 'capture' => false,
            ]);

            if($pay->status == 'succeeded')
            {
                $bet = new Bet;
                $bet->first_player_id = $request->first_player_id;
                $bet->first_player_avatar_id = $request->first_player_avatar_id;
                $bet->first_player_name = $request->first_player_name;
                $bet->first_player_bet_amount = $request->first_player_bet_amount;
                $bet->first_player_payment_id = $pay->id;
                $bet->first_player_payment_status = $pay->status;
                $bet->bet_status = 'pending';
                $bet->save();

                $bet1 = Bet::where('id', $bet->id)->first();

                return response()->json([
                    'status' => true,
                    'message' => 'Bet Created Successfully',
                    'data' => $bet1,
                ], 200);

            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'There is some issue to proceed your payment, please try againt later',
                ], 200);
            }

        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',
            ], 200);
        }
    } 
    
    public function update_bet(Request $request)
    {
        try{
            
            $stripe = new \Stripe\StripeClient(
                'pk_test_crwKgwLBaPlD6PyegWa6ln6E00AowPrKUI'
            );
              
            $token = $stripe->tokens->create([
                'card' => [
                  'number' => $request->card_number,
                  'exp_month' => $request->exp_month,
                  'exp_year' => $request->exp_year,
                  'cvc' => $request->cvv,
                ],
            ]);

            Stripe\Stripe::setApiKey('sk_test_BHlJPzC6PloLo7ELEKksI1uy00LlQbLa2X');

            $pay = Stripe\Charge::create ([
                "amount" => 100 * (int)$request->second_player_bet_amount,
                "currency" => "USD",
                "source" => $token->id,
                "description" => "Bet Payment",
                // 'capture' => false,
            ]);

            if($pay->status == 'succeeded')
            {
                $bet = Bet::where('id', $request->bet_id)->first();
                $bet->second_player_id = $request->second_player_id;
                $bet->second_player_avatar_id = $request->second_player_avatar_id;
                $bet->second_player_name = $request->second_player_name;
                $bet->second_player_bet_amount = $request->second_player_bet_amount;
                $bet->second_player_payment_id = $pay->id;
                $bet->second_player_payment_status = $pay->status;
                $bet->bet_status = 'active';
                $bet->save();

                $bet1 = Bet::where('id', $bet->id)->first();

                return response()->json([
                    'status' => true,
                    'message' => 'Bet Started Successfully',
                    'data' => $bet1,
                ], 200);

            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'There is some issue to proceed your payment, please try againt later',
                ], 200);
            }

        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',
            ], 200);
        }
    } 

    public function bet_details($bet_id)
    {
        try{
            $bet = Bet::where('id', $bet_id)->first();

            if(empty($bet))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Bet does not Exists',
                ], 200);
            }

            $avatar1 = Avatar::where('id', $bet->first_player_avatar_id)->first('avatar_image');
            
            if(!empty($avatar1))
            {
                $bet->first_player_avatar = IMAGE_URL.$avatar1->avatar_image;
            }

            $avatar2 = Avatar::where('id', $bet->second_player_avatar_id)->first('avatar_image');
            
            if(!empty($avatar2))
            {
                $bet->second_player_avatar = IMAGE_URL.$avatar2->avatar_image;
            }

            return response()->json([
                'status' => true,
                'message' => 'Bet Details Found',
                'data' => $bet
            ], 200);
            
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',
            ], 200);
        }
    }
    
    public function bet_status($user_id)
    {
        try{
            $user = User::where('id', $user_id)->first();

            if(empty($user))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not Exists',
                ], 200);
            }

            $bet = Bet::orWhere('first_player_id', $user_id)->orWhere('second_player_id', $user_id)->orderBy('id', 'desc')->first(['id', 'bet_status']);

            if(!empty($bet))
            {
                if($bet->bet_status == 'pending' || $bet->bet_status == 'active')
                {
                    return response()->json([
                        'status' => true,
                        'message' => 'Bet Found',
                        'data' => [
                            'status' => $bet->bet_status
                        ],
                    ], 200);    
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'No Bet Found',
                    ], 200);    
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'No Bet Found',
                ], 200);
            }            
            
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',
            ], 200);
        }
    }

    public function select_winner($bet_id, $winner_id)
    {
        try{
            $user = User::where('id', $winner_id)->first();

            if(empty($user))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Winner Player does not Exists',
                ], 200);
            }

            $bet = Bet::where('id', $bet_id)->first();

            if($bet->bet_status == 'completed')
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Bet has already been Completed',
                ], 200);
            }

            $bet->winner_id = $winner_id;
            $bet->bet_status = 'completed';
            $bet->save();

            $user->wallet_balance = $user->wallet_balance + ($bet->first_player_bet_amount + $bet->second_player_bet_amount);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => $user->name.' has won the bet',
            ], 200);
            
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',
            ], 200);
        }
    }
}
