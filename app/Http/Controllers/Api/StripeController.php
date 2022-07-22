<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Avatar;
use App\Models\Bet;
use Session;
use Stripe;

class StripeController extends Controller
{
    public function get_account_details(Request $request)
    {
        $stripe = new \Stripe\StripeClient('sk_test_BHlJPzC6PloLo7ELEKksI1uy00LlQbLa2X');
        
        $accountId = $request->account_id;
        
        $account = $stripe->accounts->retrieve(
    	    $accountId,
    	    []
    	);
    	
    	return $account;
    }
}
