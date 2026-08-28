<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'name', 'monthly_fee', 'is_active'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tuitions()
    {
        return $this->hasMany(Tuition::class);
    }
}
