<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    //boot 

    protected static function boot(){
        parent::boot();

        //created 
        static::updated(function($company){
            die("Updated....".$company->name);
        });
    }
}
