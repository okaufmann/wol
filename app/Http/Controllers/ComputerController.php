<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ComputerRequest;
use Illuminate\Http\Request;

use App\Computer;
use JJG\Ping;

class ComputerController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$computers = Computer::all();

		return view('computer.index')->with(compact('computers'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('computer.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Computer $computer, ComputerRequest $request)
    {
        $computer->fill($request->all());

        $computer->save();

        flash()->success('Computer created.');

        return redirect()->route('computer.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Computer  $computer
	 * @return Response
	 */
	public function edit(Computer $computer)
	{
		return view('computer.edit')->with(compact('computer'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param Computer $computer
     * @param ComputerRequest $request
     * @return Response
     */
	public function update(Computer $computer, ComputerRequest $request)
	{
		$computer->fill($request->all());

        $computer->save();

        flash()->success('Computer updated.');

        return redirect()->route('computer.index');
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param Computer $computer
     * @return Response
     */
	public function destroy(Computer $computer)
	{
        $computer->delete();

        flash()->success('Computer deleted!');

		return redirect()->route('computer.index');
	}

    /**
     * Boot the computer.
     *
     * @return Response
     */
    public function boot(Computer $computer, \Phpwol\Factory $phpwol)
    {
        $magicPacket = $phpwol->magicPacket();

        $result = $magicPacket->send($computer->mac, $computer->broadcast);

        if($result)
        {
            $message = 'Computer wird gestartet!';
        }
        else
        {
            $message = 'Fehler aufgetreten!';
        }

        return back()->with(compact('message'));
    }

    /**
     * Check if the computer is online.
     *
     * @return Response
     */
    public function status(Computer $computer)
    {
        if($computer->ip == '')
        {
            return "unknown";
        }

        $ping = new Ping($computer->ip, 100, 1);

        $latency = $ping->ping('exec');

        if($latency)
        {
            return "on";
        }

        return "off";
    }

}
