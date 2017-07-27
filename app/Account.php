<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'description',
        'currency_id'
    ];

    protected $hidden = ['transactions', 'updated_at', 'created_at'];

    protected $appends = ['amount'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getAmountAttribute()
    {
        return $this->transactions->sum('amount');
    }

    public function rehydrate()
    {
        $this->load('currency');
    }
}
