<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'student';

    protected $fillable = [
        'name', 'phone','created_at', 'updated_at'
    ];


    public function scopeSelection($query)
    {
        return $query->select('id', 'name','phone');
    }
}
