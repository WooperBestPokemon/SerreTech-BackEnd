<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $table = 'tblData';
    protected $fillable = [
        'idSensor','data','created_at','updated_at'
    ];
}
