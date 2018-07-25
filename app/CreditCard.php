<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    protected $fillable = ['card_number','card_type','expiry_month','expiry_year','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
