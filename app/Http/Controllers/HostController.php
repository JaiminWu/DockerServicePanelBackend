<?php

namespace App\Http\Controllers;

use App\Host;
use Illuminate\Http\Request;
use App\Container;

class HostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hosts = Host::all();
        return compact('hosts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Host $host)
    {
        //
        $host->fill($request->all());
        $host->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Host  $host
     * @return \Illuminate\Http\Response
     */
    public function show(Host $host)
    {
        return compact('host');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Host  $host
     * @return \Illuminate\Http\Response
     */
    public function edit(Host $host)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Host  $host
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Host $host)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Host  $host
     * @return \Illuminate\Http\Response
     */
    public function destroy(Host $host)
    {
        $host->delete();
    }

    public function createContainer(Request $request, $id){
      $host = Host::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('POST',
      'http://'.$host->host.':'.$host->port.'/containers/create?name='.$request->get('name'),
      ['json' => $request->post()]
      );
      if($res->getStatusCode() != 201){
        return $res->getBody();
      }
      $contain_info = json_decode($res->getBody(),true);
      $container = new Container;
      $container->key = $contain_info['Id'];
      $container->name = $request->get('name');
      $container->image_name = $request->post('Image');
      $container->status = 'created';
      $container->host_id = $id;
      $container->command = json_encode($request->post('Cmd'));
      $container->save();
      return compact($container);
    }
}
