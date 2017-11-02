<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Wallet;
use Auth;
use Response;
use Validator;

class WalletController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['only'=>['store','show','destroy']]); //checking admin api call
        $this->middleware('john');// only for quiz, injecting john as user
    }

    /**
     * Display a Wallet.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get current user
        try{
            $me     = Auth::user();
            $wallet = Wallet::where('user_id', $me->id)
                ->with(['transactions'=>function($query) {
                    return $query->limit(3)->orderBy('created_at', 'desc');
                }])
                ->first();
            
            if(empty($wallet)){
                throw new \Exception('Wallet not found.');
            }

            if($wallet->trashed()){
                throw new \Exception('Wallet deleted.');
            }
        }catch(\Excception $e){
            return Response::json([
                'code'      =>  500,
                'message'   =>  $e->getMessage()
            ], 500);
        }

        $result = [
            'id'     => $wallet->id,
            'amount' => $wallet->amount,
            'email'  => $me->email,
            'transactions' => $wallet->transactions,
            //'transactions' => $wallet->transactions,
        ];

        return response()->json($result);
    }

    private function createUser($email)
    {
        $name = explode('@',$email)[0];
        return User::create([
            'name'      => $name,
            'email'     => $email,
            'password'  => bcrypt('12341234'), //hard code password for quiz purpose
        ]);
    }

    private function createWallet($user_id){
        $wallet             = new Wallet;
        $wallet->user_id    = $user_id;
        $wallet->amount     = '0.00';
        $wallet->status     = 'active';
        $saved              = $wallet->save();
        if($saved){
            return $wallet;
        }else{
            throw new \Exception('Database Error.');
        }
    }

    /**
     * Store a new wallet
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'email' => 'required|email'
            ]);
            $input = $request->all();

            //isNewEmail.
            $user       = User::where('email', $input['email'])->first();
            $isNewEmail = !($user);
            
            if($isNewEmail){
                //create user
                $user   = $this->createUser($input['email']);
                //create wallet
                $wallet = $this->createWallet($user->id);
            } else {
                //existing user
                $hasWallet = Wallet::where('user_id',$user->id)->first();
                if(!$hasWallet){
                    $wallet = $this->createWallet($user->id);
                }else{
                    throw new \Exception('Wallet already exists.');
                }
            }
        }catch(\Exception $e){
            return Response::json([
                'code'      =>  500,
                'message'   =>  $e->getMessage()
            ], 500);
        }

        //!isNewEmail.
        //getuser
        //check wallet exist
        //create wallet

        
        

        $result = [
            'id'     => $wallet->id,
            'amount' => $wallet->amount,
            'email'  => $user->email,
        ];

        return response()->json($result);
    }

    /**
     * Display the wallet for admin.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = $id;
        
        //get current user
        try{
            //validation
            $validator = Validator::make(['email'=>$email], [
                'email' => "required|email",  //this balance variable acts as the parameter array for extended validator class
            ]);
            if($validator->fails()){
                throw new \Exception('Incorrect email.');
            }

            $user   = User::where('email',$email)->first();
            if(!($user)){
                throw new \Exception('Incorrect email.');
            }

            $wallet = Wallet::where('user_id', $user->id)
                ->with(['transactions'=>function($query) {
                    return $query->limit(3)->orderBy('created_at', 'desc');
                }])
                ->first();

            if(empty($wallet)){
                throw new \Exception('Wallet not found.');
            }

            if($wallet->trashed()){
                throw new \Exception('Wallet deleted.');
            }
        }catch(\Excception $e){
            return Response::json([
                'code'      =>  500,
                'message'   =>  $e->getMessage()
            ], 500);
        }

        $result = [
            'id'     => $wallet->id,
            'amount' => $wallet->amount,
            'email'  => $user->email,
            'transactions' => $wallet->transactions,
            //'transactions' => $wallet->transactions,
        ];

        return response()->json($result);
    }

    /**
     * Remove the wallet from email.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $email = $id;
        
        //get current user
        try{
            //validation
            $validator = Validator::make(['email'=>$email], [
                'email' => "required|email",  //this balance variable acts as the parameter array for extended validator class
            ]);
            if($validator->fails()){
                throw new \Exception('Incorrect email.');
            }

            $user   = User::where('email',$email)->first();
            if(!($user)){
                throw new \Exception('Incorrect email.');
            }

            $wallet = Wallet::where('user_id', $user->id)
                ->first();

            if(empty($wallet)){
                throw new \Exception('Wallet Not Found.');
            }

            if($wallet->trashed()){
                throw new \Exception('Wallet deleted.');
            }

            $wallet->delete();
        }catch(\Excception $e){
            return Response::json([
                'code'      =>  500,
                'message'   =>  $e->getMessage()
            ], 500);
        }

        $result = [
            'amount' => $wallet->amount,
            'email'  => $user->email,
            //'transactions' => $wallet->transactions,
        ];

        return response()->json($result);
    }
}
