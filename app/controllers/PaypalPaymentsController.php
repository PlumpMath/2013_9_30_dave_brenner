<?php

class PaypalPaymentsController extends BaseController {

	/**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /**
     * Set the ClientId and the ClientSecret.
     * @param 
     *string $_ClientId
     *string $_ClientSecret
     */
    private $_ClientId='';
    private $_ClientSecret='';

    /*
     *   These construct set the SDK configuration dynamiclly, 
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */
    public function __construct(){

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate 
        // the call. You can also send a unique request id 
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly. 


        $this->_apiContext = Paypalpayment:: ApiContext(
                Paypalpayment::OAuthTokenCredential(
                    $this->_ClientId,
                    $this->_ClientSecret
                )
        );

        // dynamic configuration instead of using sdk_config.ini

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));

    }


    /**
    *   Checkout
    */
    public function verify()
    {

        if ( ! Auth::check())
            return App::abort(401, 'You are not authorized.');

          
        $data = Input::all();

        if (Input::has('same_as_billing')) {
            $user = Auth::user();

            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['address'] = $user->address;
            $data['address_2'] = $user->address_2;
            $data['city'] = $user->city;
            $data['state'] = $user->state;
            $data['zip_code'] = $user->zip_code;
        }

        /**
        *   Standardize input, change to lowercase 
        */
        foreach ($data as $key => $value) {
           $data[$key] = strtolower($value);
        }

        /**
        *   Change settings for CVV auth, place first digit of cardnumber
        *   as first digit of CVV, then change back if validates
        */
        $firstnumber = (int) substr($data['card_number'], 0, 1);
        $cvv = $data['cvv'];
        $data['cvv'] += ($firstnumber == 3 ? "30000":"1000");
        $userrules = [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'address'       => 'required',
            'address_2'     => '',
            'city'          => 'required',
            'state'         => 'required',
            'zip_code'      => 'required',
            'phone'         => 'required',
        ];
        
        $cardrules = array (
            'card_number' => 'required|creditcard',
            'cvv' => 'required|cvv',
            'expire_month' => 'required|size:2',
            'expire_year' => 'required|size:4',
            'coupon' => 'coupon'
            );

        $rules = $userrules + $cardrules;
        
        $verify = Validator::make($data, $rules);
        $data['cvv'] = $cvv;
        
        //verify input
        if ($verify->passes()) {
            //Session::flash('data', $data);
            //$response = Response::make($data);
            //$response->header('Content-Type','POST');
            $this->makepay($data);
        }
        else
        	print_r($verify->messages());
			return Redirect::to('/checkout')->withInput(Input::all())->withErrors($verify);

    }
    /**
    *   Checking user info
    */
    public function user()
    {
        $data = Input::all();
        var_dump($data);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        echo "<pre>";

        $payments = Paypalpayment::all(array('count' => 1, 'start_index' => 0),$this->_apiContext);

        print_r($payments);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function makepay($in)
	{
        //$in = Session::get('data');

        $data = array(
            'addr' => array(
                'address' => '',
                'address_2' => '',
                'city' => '',
                'state' => '',
                'zip_code' => '',
                ),
            'card' => array(
                'card_type' => '',
                'card_number' => '',
                'expire_month' => '',
                'expire_year' => '',
                'cvv' => '',
                'first_name' => '',
                'last_name' => '',
                ),
            'phone' => '',
            'amount' => '',
            'description' => '',
        );
        $address = $data['addr'];
        foreach ($in as $key=>$val) {
            //fill $data with fields from input
            if (isset($data[$key])) {
                $data[$key] = $val;
            }
            elseif (array_key_exists($key, $data['addr'])) {
                $data['addr'][$key] = strval($val);
            }
            elseif (array_key_exists($key, $data['card'])) {
                $data['card'][$key] = strval($val);
            }
        }
        
        // Account for coupons
        if (isset($in['coupon'])) {
            //  lookup coupon value
            $value = 100.00;
            $data['amount'] -= $value;
            $data['description'] .= " with coupon: " . $in['coupon'];
        }
        
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr= Paypalpayment::Address();
        $addr->setLine1($data['addr']['address']);
        $addr->setLine2($data['addr']['address_2']);
        $addr->setCity($data['addr']['city']);
        $addr->setState($data['addr']['state']);
        $addr->setPostal_code($data['addr']['zip_code']);
        $addr->setCountry_code("US");
        $addr->setPhone($data['phone']);

        // ### CreditCard
        // A resource representing a credit card that can be
        // used to fund a payment.
        $card = Paypalpayment::CreditCard();
        $card->setType($data['card']['card_type']);
        $card->setNumber($data['card']['card_number']);
        $card->setExpire_month($data['card']['expire_month']);
        $card->setExpire_year($data['card']['expire_year']);
        $card->setCvv2($data['card']['cvv']);
        $card->setFirst_name($data['card']['first_name']);
        $card->setLast_name($data['card']['last_name']);
        $card->setBilling_address($addr);

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::FundingInstrument();
        $fi->setCredit_card($card);


        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::Payer();
        $payer->setPayment_method("credit_card");
        $payer->setFunding_instruments(array($fi));

        // ### Amount
        // Let's you specify a payment amount.
        $amount = Paypalpayment:: Amount();
        $amount->setCurrency("USD");
        $amount->setTotal($data['amount']);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types
        $transaction = Paypalpayment:: Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription($data['description']);

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'
        $payment = Paypalpayment:: Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));

        // ### Create Payment
        // Create a payment by posting to the APIService
        // using a valid ApiContext
        // The return object contains the status;
        
        try {
            $payment->create($this->_apiContext);
            //return Redirect::route('Paypalpayments.index');
        } catch (\PPConnectionException $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            var_dump($ex->getData());
            exit(1);
        }
        
        $response=$payment->toArray();
        $response['coupon'] = $in['coupon'];

        return Redirect::to('/confirmation');

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($payment_id)
	{
		$payment = Paypalpayment::get($payment_id,$this->_apiContext);

		echo "<pre>";

		print_r($payment);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('paypalpayments.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
