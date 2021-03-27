<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Computer;
use Auth;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user = Auth::user();
		$computers = $user->computers();
		return view('computers/index', compact('computers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$computer = new Computer();
		$computer->id = 0;
		$computer->name = '';
        $connections = $computer->connections()->paginate(20)->withQueryString();
		return view('computers/edit', compact('computer','connections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $computer = new Computer();
		echo "xx";exit();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $computer = Computer::findOrFail($id);
		return view('computers/view', compact('computer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $computer = Computer::findOrFail($id);
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

        return view('computers/edit', compact('computer','connections', 'latitude','longitude'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		try{
			if ($id == 0){
				$computer = new Computer();
				$computer->genCode();
				$computer->user_id = Auth::user()->id;
			}else{
				$computer = Computer::find($id);
			}
			if ($computer->user_id == Auth::user()->id){
				$computer->name = $request->input('name');
				$computer->save();
			}
			return redirect('/home')->withStatus('You need to add this call: '.$computer->genUrl() . ' at startup on your device.');
        } catch (\Exception $e) {
            return redirect("/home")->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $computer = Computer::findOrFail($id);
		if ($computer->user_id == Auth::user()->id){
			$computer->delete();
			return redirect('/home')->withStatus("Computer has been removed");
		}else{
			return redirect('/home')->withError("Can't remove this computer.");
		}

    }

}
