<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'account_id',
        'description',
        'amount'
    ];

    protected $hidden = ['updated_at'];

    public function account()
    {
        $this->belongsTo(Account::class);
    }
}
