<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;

class DungeonController extends Controller
{
    public function inscription()
    {
        $client = new Guzzle;
        $res = $client->get('http://141.95.153.155/inscription', ['headers' => ['Authorization' => 'Basic dG90bzp0b3Rv']]);

        $data['x-auth-token'] = $res->getHeaders()['x-subject-token'];
        $data['message'] = $res->getBody()->getContents();

        return $data;
    }

    public function genericRequest(Request $request)
    {
        $client = new Guzzle;
        if ($request['method'] == 'get') {
            $res = $client->get($request['url'], ['headers' => ['x-auth-token' => $request['token']]]);
        } else if ($request['method'] == 'post') {
            $res = $client->post($request['url'], ['headers' => ['x-auth-token' => $request['token']], 'body' => $request['body']]);
        } else if ($request['method'] == 'delete') {
            $res = $client->delete($request['url'], ['headers' => ['x-auth-token' => $request['token']]]);
        }

        $data['message'] = $res->getBody()->getContents();

        return $data;
    }
}
