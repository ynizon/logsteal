<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Computer;
use App\User;
use App\Connection;
use GeoIp2\Database\Reader;
use Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function cron(){
        $year = date("Y")-1;
        foreach (Users::all() as $user){
            foreach ($user->computers as $computer){
                if ($computer->updated_at < $year . date("-m-d")){
                    $computer->delete();
                }
            }
            if (count($user->computers)>0){
                $info = '<a href="/renew/'.$user->id.'">For renewing your computers, click on this link.</a>';
                foreach ($user->computers as $computer){
                    $info = $computer->log();
                }
                $info .= '<hr/>';

                try {
                    $subject = 'Logger > Schedule';
                    Mail::send('emails.message', ['content' => $info], function ($m) use ($user, $subject) {
                        $m->from($user->getEmail(), $user->getName());
                        $m->to($user->getEmail(), $user->getName())->subject($subject);
                    });
                }catch (\Exception $e){

                }

                foreach ($user->computers as $computer){
                    $computer->removeConnections();
                }
            }
        }
    }

    public function renew($user_id){
        $user = User::findOrFail($user_id);
        if ($user){
            foreach ($user->computers as $computer){
                $computer->updated_at = date("Y-m-d");
                $computer->save();
            }
        }
    }

    private function connection($code, $show){
        $computer = Computer::where("code","=",$code)->first();
        if ($computer){
            $user = $computer->user();

            $ip = $this->get_client_ip();
            $info = [];
            $info['ip'] = $ip;
            $info['hostname'] = gethostbyaddr($ip);

            $db = storage_path().'/GeoipDB/GeoLite2-City.mmdb';
            if (file_exists($db)) {
                try {
                    $reader = new Reader($db);
                    $record = $reader->city($ip);

                    $info['code_iso'] = $record->country->isoCode; // 'US'
                    $info['country'] = $record->country->name; // 'United States'
                    $info['subdivision'] = $record->mostSpecificSubdivision->name; // 'Minnesota'
                    $info['city'] = $record->city->name; // 'Minneapolis'
                    $info['postcode'] = $record->postal->code; // '55455'
                    $info['latitude'] = $record->location->latitude; // 44.9733
                    $info['longitude'] = $record->location->longitude; // -93.2323
                    $info['network'] = $record->traits->network; // '128.101.101.101/32'
                }catch(\Exception $e){
                    //No informations about this IP
                }
            }

            $connection = new Connection();
            $connection->computer_id = $computer->id;
            $connection->info = json_encode($info);
            $connection->save();

            $connections = $computer->connections()->paginate(20)->withQueryString();
            $latitude = '';
            $longitude = '';
            if (count($connections)>0){
                $connection = $connections->first();
                $info = json_decode($connection->info, true);
                if (isset($info['latitude'])){
                    $latitude = $info['latitude'];
                }
                if (isset($info['longitude'])){
                    $longitude = $info['longitude'];
                }
            }

            if ($show){
                return view('log', compact('computer','connections', 'longitude','latitude'));
            }else{
                header("location: https://www.google.com");
                exit();
            }
        }
    }

    public function ping($code){
        return $this->connection($code, false);
    }

	public function log($code){
        return $this->connection($code, true);
	}

	// Function to get the client IP address
	private function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		   $ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
}
