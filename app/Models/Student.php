<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
    'name',
    'age',
    'address',
    'email',
    'status'
];
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}