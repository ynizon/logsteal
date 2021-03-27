<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    
	public function computer()
    {
        return $this->hasOne(Computer::class);
    } 
}
