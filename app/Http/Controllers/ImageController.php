<?php

namespace App\Http\Controllers;

use App\Image;
use App\Host;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $host = Host::find($request->input('host_id'));
      $client = new \GuzzleHttp\Client();
      $res = $client->request('GET', 'http://'.$host->host.':'.$host->port.'/images/json');
      return $res->getBody();
      // $host = Host::find($request->host_id)->images;
      // return compact('host');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $host = Host::find($request->post('host_id'));
      $querys = $request->post();
      unset($querys['host_id']);
      $authentication = array('username' => 'jaiminwu',
                              'password' => 'Jaimin011210.',
                              'email' => 'JaiminWu1025@gmail.com',
                              'serveraddress' => $host->host,);
      $headers = array('X-Registry-Auth' => base64_encode(json_encode($authentication)));
      $client = new \GuzzleHttp\Client();
      $res = $client->request('POST', 'http://'.$host->host.':'.$host->port.'/images/create', [
          'headers' => $headers,
          'query' => $querys,
      ]);
      if($res->getStatusCode() != 200){
        return $res->getBody();
      }
      $image = new Image;
      $image->name = $querys['name'];
      $image->host_id = $request->post('host_id');
      $image->save();
      return compact('image');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
        $image = Image::find($id);
        $client = new \GuzzleHttp\Client();
        $res = $client->request('DELETE', 'http://'.$image->host->host.':'.$image->host->port.'/containers/'.$image->key.'/remove');
        return $res->getBody();
    }
}
