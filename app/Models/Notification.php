<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'tblnotification';
    protected $primaryKey = 'idAlerte';
    protected $fillable = [
        'description','alerteStatus','created_at','updated_at','idSensor'];
}