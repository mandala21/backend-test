<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Survivor as Survivor;

class Inventory extends Model
{
    protected $table = 'inventory';
    
    protected $fillable = ['item','ammount','survivor_id'];

    public static function getHumanItem($value){
        switch ($value) {
            case 4:
                return 'Water';
            case 3:
                return 'Food';
            case 2:
                return 'Medication';
            case 1:
                return 'Ammunition';
        }
    }

    public function survivor()
    {
        return $this->belongsTo(Survivor::class);
    }
}
