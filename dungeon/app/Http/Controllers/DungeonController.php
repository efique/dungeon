<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException as GuzzleError;

class DungeonController extends Controller
{
    public function inscription(Request $request)
    {
        $client = new Guzzle;
        $res = $client->get($request['url'], ['headers' => ['Authorization' => 'Basic ' . $request['token']]]);

        $data['x-auth-token'] = $res->getHeaders()['x-subject-token'];
        $data['message'] = $res->getBody()->getContents();

        return response()->json($data);
    }

    public function genericRequest(Request $request)
    {
        $client = new Guzzle;

        try {
            if ($request['method'] == 'get') {
                $res = $client->get($request['url'], ['headers' => ['x-auth-token' => $request['token']]]);
            } else if ($request['method'] == 'post') {
                $res = $client->post($request['url'], ['headers' => ['x-auth-token' => $request['token']], 'body' => $request['body']]);
            } else if ($request['method'] == 'delete') {
                $res = $client->delete($request['url'], ['headers' => ['x-auth-token' => $request['token']]]);
            }

            $data = $res->getBody()->getContents();

            return response()->json($data);
        } catch (GuzzleError $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return response()->json($responseBodyAsString);
        }
    }
}
