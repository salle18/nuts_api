<?php

namespace App\Http\Controllers;

use App\Account;
use App\Transaction;
use Illuminate\Http\Request;

use App\Http\Requests;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Account $account
     * @return \Illuminate\Http\Response
     */
    public function index(Account $account)
    {
        return $account->transactions()->orderBy('id', 'desc')->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Account $account
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Account $account, Request $request)
    {
        $transaction = new Transaction($request->all());
        $account->transactions()->save($transaction);
        return $transaction;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Account $account
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account, $id)
    {
        $transaction = $account->transactions->find($id);
        return $transaction;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Account $account
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Account $account, Request $request, $id)
    {
        $transaction = $account->transactions->find($id);
        if ($transaction) {
            $transaction->update($request->all());
            return $transaction;
        }
        return response()->not_found();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Account $account
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account, $id)
    {
        $transaction = $account->transactions->find($id);
        if ($transaction) {
            $transaction->delete();
            return response()->success($id);
        }
        return response()->not_found();
    }
}
