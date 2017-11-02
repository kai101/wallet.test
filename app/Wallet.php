<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes;
    protected $hidden = ['updated_at', 'created_at', 'deleted_at'];

    protected $dates = ['deleted_at'];
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
