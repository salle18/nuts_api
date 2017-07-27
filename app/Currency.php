<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    protected $fillable = ['code'];

    protected $hidden = ['created_at', 'updated_at'];

    public function account()
    {
        return $this->hasMany(Account::class);
    }
}
