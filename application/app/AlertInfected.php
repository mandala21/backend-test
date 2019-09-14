<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertInfected extends Model
{
    protected $table = 'alert_infected';

    protected $fillable = ['survivor_id'];
}
