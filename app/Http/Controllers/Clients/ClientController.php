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
        try {
            $clients = Http::get(env('API_URL') . env('API_CLIENTS') . '/' . auth()->user()->empresa_id)->json(0);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la solicitud HTTP: ' . $e->getMessage()], 500);
        }

        return view('clients.index', compact('clients'));
        // return 'hola';
    }

    public function edit($id)
    {
        try {
            $client = Http::get(env('API_URL') . env('API_CLIENT') . '/' . $id)->json(0)[0];
            $estructura = Http::get(env('API_URL') .  env('API_ESTRUCTURA') . '/' . $client['id'])->json(0);
            $channels = Http::get(env('API_URL') . env('API_CHANNELS'))->json(0);
            $channels_config = json_decode($client['channels'], true);
            $listas = Http::get(env('API_URL') . '/listas-discador/' . $client['prefix'])->json(0);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la solicitud HTTP: ' . $e->getMessage()], 500);
        }


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
        try {
            $client = Http::get(env('API_URL') . env('API_CLIENT') . '/' . $id)->json(0)[0];
            return json_decode($client['channels'], true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la solicitud HTTP: ' . $e->getMessage()], 500);
        }
    }

    public function editChannels(Request $request)
    {

        $channels_config = self::getClientConfigChannelStructure($request->client_id);
        $channels_config["channels"] = $request->configuracion['channels'];
        $update = [];
        $update['idClient'] = intval($request->client_id);
        $update['channels'] = json_encode($channels_config, JSON_FORCE_OBJECT);

        try {
            $updated = Http::put(env('API_URL') . env('API_CLIENT') . "/canales", $update);
            if ($updated != 'false') {
                return redirect(route('clients.edit', $request->client_id));
            } else {
                return $updated;
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la solicitud HTTP: ' . $e->getMessage()], 500);
        }
    }

    public function editStructure(Request $request)
    {
        $channels_config = self::getClientConfigChannelStructure($request->client_id);

        $config_request = $request->configuracion['estructura'];
        $xs = [];
        foreach ($config_request as $clave => $valor) {
            // Verificar si la clave actual tiene una propiedad "nombre"
            if (isset($valor["nombre"])) {
                // Convertir a mayúsculas y asignar de nuevo
                $config_request[$clave]["nombre"] = $valor["nombre"] ? strtoupper($valor["nombre"]) : null;
            }
        }

        $channels_config["estructura"] = $config_request;
        $update = [];
        $update['idClient'] = intval($request->client_id);
        $update['channels'] = json_encode($channels_config, JSON_FORCE_OBJECT);
        // return $update;

        try {
            $updated = Http::put(env('API_URL') . env('API_CLIENT') . "/canales", $update);
            if ($updated != 'false') {
                return redirect(route('clients.edit', $request->client_id));
            } else {
                return $updated;
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la solicitud HTTP: ' . $e->getMessage()], 500);
        }
    }
}
