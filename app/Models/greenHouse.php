<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreenHouse extends Model
{
    use HasFactory;

    protected $table = 'tblGreenHouse';
    protected $primaryKey = 'idGreenHouse';
    protected $fillable = [
        'idCompany','name','description','img','created_at','updated_at'
    ];
}
