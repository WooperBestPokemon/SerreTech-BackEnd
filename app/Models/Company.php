<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'tblCompany';
    protected $primaryKey = 'idCompany';
    protected $fillable = [
        'name','created_at','updated_at'
    ];
}
