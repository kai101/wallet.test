<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Wallet;
use App\Transaction;
use Auth;
use Response;
use DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        //$this->middleware('admin', ['only'=>['store','destroy']]); //checking admin api call
        $this->middleware('john');// only for quiz, injecting john as user
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    private function createTransaction($wallet,$credit,$debit,$remarks = ''){
        $transaction            = new Transaction;
        $transaction->wallet_id = $wallet->id;
        $transaction->credit    = $credit;
        $transaction->debit     = $debit;
        $transaction->remarks   = $remarks;

        $saved = $transaction->save();

        if(!$saved){
            throw new \Exception('Database Error.');
        }

        return $transaction;
    }

    private function updateWallet($wallet,$credit,$debit){
        $wallet->amount = $this->numberFormat($wallet->amount - $debit + $credit);
        if(+$wallet->amount < 0){
            throw new \Exception('Not enough balance.');
        }
        $wallet->save();
        return $wallet;
    }


    private function numberFormat($number){
        return number_format($number,2,'.','');
    }

    private function sanitizeInput($input){
        $input['credit'] = $this->numberFormat($input['credit']);
        $input['debit'] = $this->numberFormat($input['debit']);
        return $input;
    }

    /**
     * Store a new Transaction
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'credit'  => 'required',
                'debit'   => 'required',
                'remarks' => 'string'
            ]);
            $input = $request->all();
            $input = $this->sanitizeInput($input);
            $user  = Auth::user();
            if(!($user)){
                throw new \Exception('User not found.');
            }
            $wallet      = Wallet::where('user_id',$user->id)->first();
        }catch(\Exception $e){
            DB::rollBack();
            return Response::json([
                'code'      =>  500,
                'message'   =>  $e->getMessage()
            ], 500);
        }

        //begin transaction.
        DB::beginTransaction();
        try{
            $transaction = $this->createTransaction($wallet,$input['credit'],$input['debit'],$input['remarks'] ?? '');
            $wallet      = $this->updateWallet($wallet,$input['credit'],$input['debit']);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return Response::json([
                'code'      =>  500,
                'message'   =>  $e->getMessage()
            ], 500);
        }
        
        $result = array_merge($transaction->toArray(),[
            'amount' => $wallet->amount,
            'email'  => $user->email,
        ]);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
