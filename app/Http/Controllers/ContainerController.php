<?php
namespace App\Http\Controllers;

use App\Container;
use App\Host;
use Illuminate\Http\Request;

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $host = Host::find($request->input('host_id'));
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://'.$host->host.':'.$host->port.'/containers/json?all=1');
        return $res->getBody();
        // $host = Host::find($request->host_id)->containers;
        // $hosts = Host::all();
        // $i = 0;
        // foreach ($hosts as $key => $value) {
        //   $containers = Container::where(['host_id' => $value['id'],])->get();
        //   foreach ($containers as $v) {
        //     $host[$i] = $v;
        //     $i++;
        //   }
        // }
        // return $host;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Container  $container
     * @return \Illuminate\Http\Response
     */
    public function show(Container $container)
    {
      $client = new \GuzzleHttp\Client();
      $res = $client->request('GET', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/json');
      return $res->getBody();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Container  $container
     * @return \Illuminate\Http\Response
     */
    public function edit(Container $container)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Container  $container
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Container $container)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Container  $container
     * @return \Illuminate\Http\Response
     */
    public function destroy(Container $container)
    {
        //
    }

    public function export($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('GET', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/export');
      return $res->getBody();
    }

    public function start($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('POST', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/start');
      if($res->getStatusCode() != 204){
        return $res->getBody();
      }
      $container->status = 'running';
      $container->save();
      return compact('container');
    }

    public function stop($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('POST', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/stop');
      if($res->getStatusCode() != 204){
        return $res->getBody();
      }
      $container->status = 'exited';
      $container->save();
      return compact('container');
    }

    public function restart($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('POST', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/restart');
      if($res->getStatusCode() != 204){
        return $res->getBody();
      }
      $container->status = 'running';
      $container->save();
      return compact('container');
    }

    public function kill($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('POST', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/kill');
      if($res->getStatusCode() != 204){
        return $res->getBody();
      }
      $container->status = 'deaded';
      $container->save();
      return compact('container');
    }

    public function pause($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('POST', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/pause');
      if($res->getStatusCode() != 204){
        return $res->getBody();
      }
      $container->status = 'paused';
      $container->save();
      return compact('container');
    }

    public function unpause($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('POST', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/unpause');
      if($res->getStatusCode() != 204){
        return $res->getBody();
      }
      $container->status = 'running';
      $container->save();
      return compact('container');
    }

    public function remove($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('DELETE', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->name);
      if($res->getStatusCode() != 204){
        return $res->getBody();
      }
      $container->delete();
      return 'success';
    }

    public function top($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('get', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/top');
      return $res->getBody();
    }

    public function logs($id)
    {
      $container = Container::find($id);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('get', 'http://'.$container->host->host.':'.$container->host->port.'/containers/'.$container->key.'/logs?follow=false&stdout=true&since='.strtotime('7 days ago').'&until='.time());
      return $res->getBody();

    }

}
