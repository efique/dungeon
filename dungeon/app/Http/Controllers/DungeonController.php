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

    public function genericRequest($url, $token, $method, $body = null)
    {
        $client = new Guzzle;
        if ($method == 'get') {
            $res = $client->get($url, ['headers' => ['x-auth-token' => $token]]);
        } else if ($method == 'post') {
            $res = $client->post($url, ['headers' => ['x-auth-token' => $token], 'body' => $body]);
        } else if ($method == 'delete') {
            $res = $client->delete($url, ['headers' => ['x-auth-token' => $token]]);
        }

        $data['message'] = $res->getBody()->getContents();

        return $data;
    }
}
