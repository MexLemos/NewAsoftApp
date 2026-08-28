<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmPayment extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
