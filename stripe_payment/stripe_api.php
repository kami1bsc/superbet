<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('stripe-php/init.php');

if(!isset($_GET['action'])){
	echo "Action missing";
	die();
}

global $stripe;
$stripe = new \Stripe\StripeClient('sk_test_51JlfHUHLDhes5Kw7335rcI1xxDZvG6O7JTfY4oeIH3TVEb9VxKkmzA3JxjPxrZ6tymnQjd5McKsOPOwmqljY9col00AjBsuC9S');

$action = $_GET["action"];
if($action == "create_customer"){
	$email = $_POST['email'];
	//createCustomer($email);
} else if($action == "create_payment_intent"){
	createPaymentIntent();
} else if($action == "create_account"){
	createAccount();
} else if($action == "get_account_detail"){
	getAccountDetail();
} else if($action == "claim_reward"){
	claimReward();
} else {
	die("Unknown action");
}

function claimReward(){
	global $stripe;
	checkMethod("POST");
	$response = array();
	$status = 0;
	$msg = '';
	
	if(!isset($_POST['account_id']) || !isset($_POST['amount'])){
		$status = 0;
		$msg = 'Param(s) Missing';
	} else {
		$amount = $_POST['amount'];
		$amount = round($amount, 0);
		$account_id = $_POST['account_id'];
		$status = 1;
		$msg = "Success";
		$transfer = $stripe->transfers->create([
		  'amount' => $amount,
		  'currency' => 'USD',
		  'destination' => $account_id,
		]);
		
		$response['transfer'] = $transfer;	
	}
	
	$response['status'] = $status;
	$response['message'] = $msg;
	echo json_encode($response);
}

function createAccount(){
	global $stripe;
	checkMethod("POST");
	$response = array();
	$status = 0;
	$msg = '';
	if(!isset($_POST['email'])){
		$status = 0;
		$msg = 'Param(s) Missing';
	} else {
		$status = 1;
		$email = $_POST['email'];
	
		$account = $stripe->accounts->create([
		  'type' => 'express',
		  //'country' => 'US',
		  'email' => $email,
		  'capabilities' => [
			//'card_payments' => ['requested' => true],
			'transfers' => ['requested' => true],
		  ],
		  'business_type' => 'individual',
		  //'business_profile' => ['url' => 'https://example.com'],
		]);
		$accountId = $account->id;
		$response['account_id'] =$accountId;
		/*$link = $stripe->accountLinks->create(
		  [
			'account' => $accountId,
			'refresh_url' => 'https://uppi.androidworkshop.net/refresh.php',
			'return_url' => 'https://uppi.androidworkshop.net/thankyou.php',
			'type' => 'account_onboarding',
		  ]);
		$response['account_link'] = $link->url;*/
	}

	$response['status'] = $status;
	$response['message'] = $msg;
	echo json_encode($response);
}

function getAccountDetail(){
	global $stripe;
	checkMethod("POST");
	$response = array();
	$status = 0;
	$msg = '';
	if(!isset($_POST['account_id'])){
		$status = 0;
		$msg = 'Param(s) Missing';
	} else {
		$accountId = $_POST['account_id'];
	}
	$account = $stripe->accounts->retrieve(
	  $accountId,
	  []
	);
	$response['account'] = $account;
	if($account->details_submitted !== true){
		$link = $stripe->accountLinks->create(
		  [
			'account' => $accountId,
			'refresh_url' => 'https://uppi.onlinedownloader.xyz/refresh.php',
			'return_url' => 'https://uppi.onlinedownloader.xyz/thankyou.php',
			'type' => 'account_onboarding',
		  ]);
		$response['account_link'] = $link->url;
	}
	$response['status'] = $status;
	$response['message'] = $msg;
	echo json_encode($response);
}

function createPaymentIntent(){
	global $stripe;
	checkMethod("POST");
	$status = 0;
	$msg = '';
	if(!isset($_POST['amount']) || !isset($_POST['currency'])){
		$status = 0;
		$msg = 'Param(s) Missing';
	} else {
		$status = 1;
		$amount = $_POST['amount'];
		$currency = $_POST['currency'];
		
		//die();
		$paymentIntent = $stripe->paymentIntents->create([
			'amount' => $amount*100,
			'currency' => $currency,
		]);
		$clientSecret = $paymentIntent->client_secret;
	}
	$response = array();
	$response['status'] = $status;
	$response['message'] = $msg;
	if(isset($clientSecret)){
		$response['clientSecret'] = $clientSecret;
	}
	echo json_encode($response);
}

function checkMethod($m){
	$method = $_SERVER['REQUEST_METHOD'];
	if($method != $m){
		$response = array();
		$response['status'] = 0;
		$response['message'] = "Incorrect method";
		die(json_encode($response));
	}
}

?>