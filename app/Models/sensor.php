<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;
    
    protected $table = 'tblSensor';
    protected $primaryKey = 'idSensor';
    protected $fillable = [
        'idZone','name','description','typeData','actif','created_at','updated_at'];
}
