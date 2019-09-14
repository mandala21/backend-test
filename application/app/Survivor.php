<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\AlertInfected as AlertInfected;
use App\Inventory as Inventory;

class Survivor extends Model
{
    protected $table = 'survivor';

    protected $fillable = ['id','name','gender','age','long','lat'];

    public function alerts_infected(){
        //relationship with alert_infected
        return $this->hasMany(AlertInfected::class,'survivor_id','id');
    }

    public function inventory(){
        //relationship with alert_infected
        return $this->hasMany(Inventory::class,'survivor_id','id');
    }

    public function isInfected(){
        // if have 3 alerts the survivor is infected :( 
        return $this->alerts_infected()->get()->count() >= 3 ? true : false;
    }

    public static function allNotInfected(){
        return Survivor::has('alerts_infected','<',3);
    }
}
