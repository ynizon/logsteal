<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Connection;
use App\User;

class Computer extends Model
{
    public function connections()
    {
        return $this->hasMany(Connection::class)->orderBy('created_at','desc');
    }

	public function user()
    {
        return $this->hasOne(User::class);
    }

    public function genUrl(){
        return env('APP_URL').'/log/'.$this->code;
    }

    public function genCode($len=8) {

		$hex = md5(env('APP_KEY') . uniqid("", true));

		$pack = pack('H*', $hex);
		$tmp =  base64_encode($pack);

		$uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);

		$len = max(4, min(128, $len));

		while (strlen($uid) < $len)
			$uid .= gen_uuid(22);

		$this->code = substr($uid, 0, $len);
	}

	public function delete()
    {
        foreach ($this->connections as $connection){
            $connection->delete();
        }
        parent::delete();
    }

    public function removeConnections(){
        foreach($this->connections as $connection){
            $connection->delete();
        }
    }
}
