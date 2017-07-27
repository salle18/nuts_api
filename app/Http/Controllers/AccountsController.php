<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;

use App\Http\Requests;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Account::with('currency')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $account = new Account($request->all());
        $account->save();
        $account->rehydrate();
        return $account;
    }

    /**
     * Display the specified resource.
     *
     * @param  Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        $account->rehydrate();
        return $account;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $account->update($request->all());
        $account->rehydrate();
        return $account;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return response()->success($account->id);
    }
}
