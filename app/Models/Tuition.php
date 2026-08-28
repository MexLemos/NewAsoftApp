<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function payment()
    {
        return $this->belongsTo(CrmPayment::class, 'crm_payment_id');
    }
}
