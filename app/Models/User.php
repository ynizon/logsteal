<?php
namespace App\Models;

use Storage;
use File;
use App\Models\Computer;
use Auth;
use DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;


    public function computers()
    {
        return $this->hasMany(Computer::class);
    }

}
