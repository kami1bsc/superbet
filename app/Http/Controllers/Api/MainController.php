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
                  'number' => '4242424242424242',
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
                'capture' => false,
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
                
                $bet1->second_player_id = "";
                $bet1->second_player_avatar_id = "";
                $bet1->winner_id = "";
                
                if($bet1->first_player_avatar_id != null)
                {
                    $avatar = Avatar::where('id', $bet1->first_player_avatar_id)->first();
                    $bet1->first_player_avatar = IMAGE_URL.$avatar->avatar_image;
                }else{
                    $bet1->first_player_avatar = "";
                }

                $bet1->second_player_avatar = "";
                
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
                  'number' => '4242424242424242',
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
                'capture' => false,
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
            
            if($bet->second_player_id == null)
            {
                $bet->second_player_id = "";
            }

            if(!empty($bet->second_player_avatar_id))
            {
                $avatar2 = Avatar::where('id', $bet->second_player_avatar_id)->first('avatar_image');
            
                if(!empty($avatar2))
                {
                    $bet->second_player_avatar = IMAGE_URL.$avatar2->avatar_image;
                }    
            }else{
                $bet->second_player_avatar_id = "";
                $bet->second_player_avatar = "";
            }

            if($bet->winner_id == null)
            {
                $bet->winner_id = "";
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
                            'id' => $bet->id,
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
        // try{
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
            
            //Stripe payment
            
            $player1_amount = (($bet->first_player_bet_amount * 1) / 100);
            
            $player_amount1 =  $bet->first_player_bet_amount - $player1_amount;
            
            $player2_amount = (($bet->second_player_bet_amount * 1) / 100);
            
            $player_amount2 =  $bet->first_player_bet_amount - $player2_amount;
            
            $win_amount = $player_amount1 + $player_amount2;
            
            // $stripe = new \Stripe\StripeClient('sk_test_BHlJPzC6PloLo7ELEKksI1uy00LlQbLa2X');

            // $pay = $stripe->charges->capture($bet->first_player_payment_id, []);
            // $pay1 = $stripe->charges->capture($bet->second_player_payment_id, []);
            
            // if($pay->status == 'succeeded' && $pay1->status == 'succeeded')
            // {
                 //if payment captured
                 
                //  \Stripe\Stripe::setApiKey('sk_test_BHlJPzC6PloLo7ELEKksI1uy00LlQbLa2X');

                // // //Create a Transfer to a connected account (later):
                // $transfer = \Stripe\Transfer::create([
                //   'amount' => 100 * (int)$win_amount,
                //   'currency' => 'USD',
                //   'destination' => $user->stripe_id,
                //   'transfer_group' => 'Superbet Payment',
                // ]);
                
                // if($transfer->amount_reversed == 0)
                // {
                    $bet->winner_id = $winner_id;
                    $bet->bet_status = 'completed';
                    $bet->save();
        
                    $user->wallet_balance = $user->wallet_balance + $win_amount;
                    $user->save();
                // }
            // }
            
            //End Stripe payment

            return response()->json([
                'status' => true,
                'message' => $user->name.' has won the bet',
            ], 200);
            
        // }catch(\Exception $e)
        // {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'There is some trouble to proceed your action',
        //     ], 200);
        // }
    }
    
    public function update_stripe_account(Request $request)
    {
        try{
            $user = User::where('id', $request->user_id)->first();
            
            if(empty($user))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not Exists',
                ], 200);
            }
            
            if($request->has('stripe_id') && $request->stripe_id != "")
            {
                $user->stripe_id = $request->stripe_id;
            }
            
            $user->save();
            
            return response()->json([
                'status' => true,
                'message' => 'Stripe Account Saved',
            ], 200);
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action'
            ], 200);
        }
    }
    
    public function create_connect_account(Request $request)
    {
        $stripe = new \Stripe\StripeClient('sk_test_BHlJPzC6PloLo7ELEKksI1uy00LlQbLa2X');
        
        $account = $stripe->accounts->create([
		  'type' => 'express',
		  //'country' => 'US',
		  'email' => $request->email,
		  'capabilities' => [
			'card_payments' => ['requested' => true],
			'transfers' => ['requested' => true],
// 			'legacy_payments' => ['requested' => true],
		  ],
		  'business_type' => 'individual',
		  //'business_profile' => ['url' => 'https://example.com'],
		]);
		$accountId = $account->id;
		
		return $accountId;
    }
    
    public function cash_out($user_id)
    {
        return response()->json([
            'status' => true,
            'message' => 'Cashout Successfully'
        ], 200);
    }
}
