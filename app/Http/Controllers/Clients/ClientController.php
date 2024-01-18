<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Configuration\EmailTemplateController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Http::get(env('API_URL') . env('API_CLIENTS') . '/' . auth()->user()->empresa_id)->collect()[0];
        return view('clients.index', compact('clients'));
        // return 'hola';
    }

    public function edit($id)
    {
        $client = Http::get(env('API_URL') . env('API_CLIENT') . '/' . $id)->collect()[0][0];
        $estructura = Http::get(env('API_URL') .  env('API_ESTRUCTURA') . '/' . $client['id'])->collect()[0];
        $channels = Http::get(env('API_URL') . env('API_CHANNELS'))->collect()[0];
        $channels_config = json_decode($client['channels'], true);
        $listas = Http::get(env('API_URL') . '/listas-discador/' . $client['prefix'])->json(0);


        $est = array_values($channels_config['estructura']);
        $est2 = [];

        for ($i = 0; $i < count($est); $i++) {
            if (array_key_exists('utilizar', $est[$i])) {
                $est2[] = $est[$i]['nombre'];
            }
        }

        // return $est2;

        $emailsTemplates = EmailTemplateController::getEmailTemplates($client['prefix']);

        return view('clients.edit', compact('est2', 'client', 'estructura', 'channels', 'channels_config', 'emailsTemplates', 'listas'));
        return $channels_config;
    }

    public function update(Request $request, $id)
    {
        // ! REVISAR


        $update = [];
        $update['idClient'] = intval($id);
        $update['channels'] = json_encode($request['configuracion'], JSON_FORCE_OBJECT);
        // return $update;

        // return $update;
        $updated = Http::put(env('API_URL') . env('API_CLIENT') . "/canales", $update);



        if ($updated != 'false') {
            return redirect(route('clients.index'));
        } else {
            return $updated;
        }
    }

    private function getClientConfigChannelStructure($id)
    {
        $client = Http::get(env('API_URL') . env('API_CLIENT') . '/' . $id)->collect()[0][0];
        return json_decode($client['channels'], true);
    }

    public function editChannels(Request $request)
    {

        $channels_config = self::getClientConfigChannelStructure($request->client_id);

        $channels_config["channels"] = $request->configuracion['channels'];
        $update = [];
        $update['idClient'] = intval($request->client_id);
        $update['channels'] = json_encode($channels_config, JSON_FORCE_OBJECT);
        // return $update;

        // return $update;
        $updated = Http::put(env('API_URL') . env('API_CLIENT') . "/canales", $update);

        if ($updated != 'false') {
            return redirect(route('clients.edit', $request->client_id));
        } else {
            return $updated;
        }
    }

    public function editStructure(Request $request)
    {
        $channels_config = self::getClientConfigChannelStructure($request->client_id);

        $channels_config["estructura"] = $request->configuracion['estructura'];
        $update = [];
        $update['idClient'] = intval($request->client_id);
        $update['channels'] = json_encode($channels_config, JSON_FORCE_OBJECT);
        // return $update;

        // return $update;
        $updated = Http::put(env('API_URL') . env('API_CLIENT') . "/canales", $update);

        if ($updated != 'false') {
            return redirect(route('clients.edit', $request->client_id));
        } else {
            return $updated;
        }
    }
}
