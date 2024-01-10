<?php

namespace App\Http\Controllers\Strategy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;

class StrategyController extends Controller
{


    public function show($id)
    {
        $strategies = Http::timeout(120)->get(env('API_URL') . env('API_ESTRATEGIAS') . '/' . strtoupper($id))->json()[0];
        $channels = Http::get(env('API_URL') . env('API_CHANNELS'))->json()[0];
        $total_cartera = 0;
        $suma_total = 0;
        $porcentaje_total = 0;

        foreach ($strategies as &$d3) {
            unset($d3['registros']);
        }


        foreach ($strategies as $key => $data) {
            if (isset($channels[$data['channels']])) {
                $strategies[$key]['canal'] = strtoupper($channels[$data['channels']]['name']);
            }
        }
        $data_client = [
            'prefix_client' => $strategies[0]['prefix_client'],
            'client_id' => $strategies[0]['id']
        ];

        // return $strategies;

        return view('strategy.index', compact('strategies', 'data_client'));
    }

    protected static function getClientData($prefix)
    {
        $clients = Http::get(env('API_URL') . env('API_CLIENTS') . '/1')->collect()[0];
        $client = [];

        foreach ($clients as $clien) {
            if ($prefix == $clien['prefix']) {
                $client = $clien;
            }
        }

        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('structure_client')->get(env('API_URL') .  env('API_ESTRUCTURA') . '/' . $client['id']),
            $pool->as('listas')->get(env('API_URL') . '/listasdiscador/' . $client['prefix']),
            $pool->as('channels')->get(env('API_URL') . env('API_CHANNELS')),
            $pool->as('stategies')->get(env('API_URL') . env('API_ESTRATEGIAS') . '/diseno/' . strtoupper($client['prefix'])),
        ]);

        return [
            'client' => $client,
            'structure_client' => $responses['structure_client']->json()[0],
            'listas' => $responses['listas']->json()[0],
            'channels' => $responses['channels']->json()[0],
            'stategies' => $responses['stategies']->json()[0],
        ];
    }


    public function desing($id)
    {
        $estrc = [];

        $ch_approve = [];
        $suma_total = 0;
        $porcentaje_total = 0;


        //Datos del cliente
        $data_client = self::getClientData($id);


        $client = $data_client['client'];
        $channels = $data_client['channels'];
        $channels_config = json_decode($data_client['client']['channels'], true);
        $estructura = $data_client['structure_client'];
        $lista_discadores = $data_client['listas'];

        $estrc = [];
        if (isset($channels_config['estructura'])) {
            foreach ($estructura as $ki => $vi) {
                if (in_array($vi['COLUMN_NAME'], array_keys($channels_config['estructura']))) {
                    if (isset($channels_config['estructura'][$vi['COLUMN_NAME']]['utilizar'])) {
                        $vi['NAME'] = $channels_config['estructura'][$vi['COLUMN_NAME']]['nombre'];
                        $estrc[] = $vi;
                    }
                }
            }
        } else {
            $estrc = null;
        }

        $datas = $data_client['stategies'];

        foreach ($datas as &$d3) {
            unset($d3['registros']);
        }

        // return $datas;

        if (count($datas) > 0) {
            $canales = [];
            foreach ($datas as $key => $data) {
                if ($data['type'] === 0) {
                    $canales[] = $data['channels'];
                }

                if (isset($channels[$data['channels']])) {
                    $datas[$key]['canal'] = strtoupper($channels[$data['channels']]['name']);
                }

                if ($channels_config != null) {
                    if ($data['type'] === 0) {
                        $key_active_channels = array_keys($channels_config['channels']);
                        $ch_approve = array_diff($key_active_channels, $canales);
                    } else {
                        $ch_approve = array_keys($channels_config['channels']);
                    }
                }
            }
        } else {
            if (isset($channels_config['channels'])) {
                $ch_approve = array_keys($channels_config['channels']);
            } else {
                $channels_config = [];
            }
            $datas = [];
        }

        // return $datas;

        return view('strategy/diseno', compact('lista_discadores', 'client', 'datas', 'porcentaje_total',  'suma_total', 'channels', 'estrc', 'ch_approve', 'channels_config'));
    }

    public function testStrategy(Request $request)
    {

        // return $request->prefix;

        $data_client = self::getClientData($request->prefix);


        $estrategias_cache = $data_client['stategies'];
        $config_channels = json_decode($data_client['client']['channels'], true);
        $tipos_masivos = [];

        foreach ($config_channels['channels'] as $o => $value) {
            if (isset($value['tipo'])) {
                $tipos_masivos[$o] = $o;
            }
        }



        $param = [
            "idCliente" => $request->id_cliente,
            "cartera" => $request->table_name,
            "criterio" => $request['query'],
            "template" => $request->template,
            "canal" => $request->channel,
        ];

        // return $param;


        $result_query = Http::post(env('API_URL') . env('API_ESTRATEGIA') . "/records", $param);

        if ($result_query == 'false') {
            return response()->json(['error' => 'Error de timeout', 'param' => $param], 404);
        }

        $coleccion = $result_query->collect()[0];

        // return $coleccion;

        if ($coleccion[0]['total_records'] !== 0) {
            $response_ruts = array_values(json_decode($coleccion[0]['detail_records'], true));
        } else {
            return response()->json(['error' => 'No existen registros con ese criterio de busqueda'], 404);
        }

        // return $response_ruts;

        $full_merge = [];

        if (in_array($request->channel, $tipos_masivos)) {
            for ($i = 0; $i < count($estrategias_cache); $i++) {
                if (in_array($estrategias_cache[$i]['channels'], $tipos_masivos)) {
                    $full_merge = array_merge($full_merge, json_decode($estrategias_cache[$i]['registros'], true));
                }
            }

            $unicos = array_diff($response_ruts, $full_merge);
            $iguales = array_intersect($response_ruts, $full_merge);

            if (isset($request->check)) {
                $cobertura = ($coleccion[0]['total_records'] / $coleccion[0]['total_cartera']) * 100;
            } else {
                $cobertura = (count($unicos) / $coleccion[0]['total_cartera']) * 100;
            }

            return $result = [
                'unicos' => array_values($unicos),
                'total_unicos' => count($unicos),
                'total_repetidos' => count($iguales),
                'total_r' => $coleccion[0]['total_records'],
                'percent_cober' => $cobertura,
                'total_enc' => $response_ruts,
            ];
        } else {
            for ($i = 0; $i < count($estrategias_cache); $i++) {
                if (!in_array($estrategias_cache[$i]['channels'], $tipos_masivos)) {
                    $full_merge = array_merge($full_merge, json_decode($estrategias_cache[$i]['registros'], true));
                }
            }

            $unicos = array_diff($response_ruts, $full_merge);
            $iguales = array_intersect($response_ruts, $full_merge);

            if (isset($request->check)) {
                $cobertura = ($coleccion[0]['total_records'] / $coleccion[0]['total_cartera']) * 100;
            } else {
                $cobertura = (count($unicos) / $coleccion[0]['total_cartera']) * 100;
            }

            return $result = [
                'unicos' => array_values($unicos),
                'total_unicos' => count($unicos),
                'total_repetidos' => count($iguales),
                'total_r' => $coleccion[0]['total_records'],
                'percent_cober' => $cobertura,
                'total_enc' => $response_ruts,
            ];
        }
    }


    public function saveStrategy(Request $request)
    {

        // return $request;
        $getEstrategiasCliente = Http::get(env('API_URL') . env('API_ESTRATEGIAS') . '/diseno/' . $request->prefix);

        $data = $getEstrategiasCliente->collect()[0];
        $exist_record = [];
        foreach ($data as $key => $value) {
            if ($value['onlyWhere'] === $request->onlyWhere) {
                if ($value['channels'] === (int)$request->channels) {
                    if (date('Y-m-d', strtotime($data[$key]['created_at'])) == date('Y-m-d')) {
                        $exist_record[] = 1;
                    }
                }
            }
        }

        $exist_record = [];

        if (count($exist_record) > 0) {
            $message = [
                'type' => 'danger',
                'message' => 'Error! existe un criterio creado el dia de hoy para ese canal, con las mismas caracteristicas. Por favor, verifíquelo e inténtelo nuevamente.',
            ];
            return back()->with('message', $message);
        } else {
            $onlyWhere = $request->onlyWhere;

            $saveQuery = [];
            $saveQuery['onlyWhere'] = str_replace("'", "''", $onlyWhere);
            $saveQuery['channels'] = 1;
            $saveQuery['table_name'] = $request->table_name;
            $saveQuery['prefix_client'] = $request->prefix;
            $saveQuery['registros_unicos'] = $request->unic;
            $saveQuery['registros_repetidos'] = $request->repe;
            $saveQuery['total_registros'] = $request->total;
            $saveQuery['cobertura'] = $request->cober;
            $saveQuery['type'] = 1;

            $saveQuery['registros'] = json_encode(json_decode($request['registros'], true));

            if (isset($request->template)) {
                $saveQuery['idEmailTemplate'] = (int) $request->template;
            } else {
                $saveQuery['idEmailTemplate'] = 0;
            }

            $save = Http::post(env('API_URL') . env('API_ESTRATEGIA'), $saveQuery);
            $result = $save->json();



            if ($result != false) {
                if ($result['serverStatus'] === 2) {
                    $message = [
                        'type' => 'success',
                        'message' => 'Exito! Se registro la estrategia con exito',
                    ];
                    return back()->with('message', $message);
                } else {
                    $message = [
                        'type' => 'danger',
                        'message' => 'Error! Hubo un problema y su estrategia no se registro correctamente. Por favor, verifíquelo e inténtelo nuevamente.',
                    ];
                    return back()->with('message', $message);
                }
            } else {
                $message = [
                    'type' => 'danger',
                    'message' => 'Error! Alguno de los campos de la estrategia no estan correctamente llenado. Por favor, verifíquelo e inténtelo nuevamente.',
                ];
                return back()->with('message', $message);
            }
        }
    }
}
