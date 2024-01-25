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
        $strategies = Http::timeout(3600)->get(env('API_URL') . env('API_ESTRATEGIAS') . '/' . strtoupper($id))->json(0);
        $data_client = self::getClientData($id);
        $channels = $data_client['channels'];
        $channels_config = json_decode($data_client['client']['channels'], true);

        $total_cartera = 0;
        $suma_total = 0;
        $porcentaje_total = 0;

        foreach ($strategies as &$d3) {
            unset($d3['registros']);
        }


        $data_counter = count($strategies);

        if ($data_counter > 0) {
            foreach ($strategies as $key => $data) {
                if (isset($channels[$data['channels']])) {
                    $strategies[$key]['canal'] = strtoupper($channels[$data['channels']]['name']);
                }


                if ($data['type'] === 2 && $data['inProcess'] == 1) {
                    if ($data['repeatUsers'] === 0) {
                        $suma_total += $data['registros_unicos'];
                    } else {
                        $suma_total += $data['total_registros'];
                    }
                    $porcentaje_total += $data['cobertura'];
                }
            }
        }

        $data_client = [
            'prefix_client' => $data_client['client']['prefix'],
            'client_id' => $data_client['client']['id']
        ];

        // return $strategies;

        return view('strategy.index', compact('strategies', 'data_client', 'suma_total', 'porcentaje_total'));
    }

    protected static function getClientData($prefix, $diseno = false)
    {
        $clients = Http::get(env('API_URL') . env('API_CLIENTS') . '/' . auth()->user()->empresa_id)->collect()[0];
        $client = [];

        foreach ($clients as $clien) {
            if ($prefix == $clien['prefix']) {
                $client = $clien;
            }
        }

        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('template_client')->get(env('API_URL') . env('API_EMAIL') . "/template-client/{$prefix}"),
            $pool->as('structure_client')->get(env('API_URL') .  env('API_ESTRUCTURA') . '/' . $client['id']),
            $pool->as('listas')->get(env('API_URL') . '/listas-discador/' . $client['prefix']),
            $pool->as('channels')->get(env('API_URL') . env('API_CHANNELS')),
            $diseno === true ? $pool->as('stategies')->get(env('API_URL') . env('API_ESTRATEGIAS') . '/diseno/' . strtoupper($client['prefix'])) : '',
            $pool->as('better_structure')->get(env('API_URL') .  '/better-structure/' . $client['id']),

        ]);

        return [
            'client' => $client,
            'structure_client' => $responses['structure_client']->json(0),
            'listas' => $responses['listas']->json(0),
            'channels' => $responses['channels']->json(0),
            'template_client' => $responses['template_client']->json(0),
            'stategies' => $diseno === true ? $responses['stategies']->json(0) : [],
            'better_structure' => $responses['better_structure']->json(0),
        ];
    }


    public function desing($id)
    {
        $estrc = [];

        $ch_approve = [];
        $suma_total = 0;
        $porcentaje_total = 0;


        //Datos del cliente
        $data_client = self::getClientData($id, true);


        $client = $data_client['client'];
        $channels = $data_client['channels'];
        $channels_config = json_decode($data_client['client']['channels'], true);
        $estructura = $data_client['structure_client'];
        $lista_discadores = $data_client['listas'];
        $template_client = $data_client['template_client'];
        $better_structure = $data_client['better_structure'];



        $estrc = [];
        if (isset($channels_config['estructura'])) {
            foreach ($estructura as $ki => $vi) {
                if (in_array($vi['COLUMN_NAME'], array_keys($channels_config['estructura']))) {
                    if (isset($channels_config['estructura'][$vi['COLUMN_NAME']]['utilizar'])) {
                        $vi['NAME'] = $channels_config['estructura'][$vi['COLUMN_NAME']]['nombre'];
                        $vi['TABLA'] = 'CA';
                        $estrc[] = $vi;
                    }
                }
            }
        } else {
            $estrc = null;
        }
        $mejor = [];
        if (isset($channels_config['mejor'])) {
            foreach ($better_structure as $ki => $vi) {
                if (in_array($vi['COLUMN_NAME'], array_keys($channels_config['mejor']))) {
                    if (isset($channels_config['mejor'][$vi['COLUMN_NAME']]['utilizar'])) {
                        $vi['NAME'] = $channels_config['mejor'][$vi['COLUMN_NAME']]['nombre'];
                        $vi['TABLA'] = 'MG';
                        $mejor[] = $vi;
                    }
                }
            }
        } else {
            $mejor = null;
        }

        $datas = $data_client['stategies'];

        foreach ($datas as &$d3) {
            unset($d3['registros']);
        }

        if (count($datas) > 0) {
            $canales = [];
            foreach ($datas as $key => $data) {
                if ($data['type'] === 1) {
                    $canales[] = $data['channels'];
                }

                foreach ($lista_discadores as  $valuess) {
                    if ($valuess['idlista'] == $data['idEmailTemplate']) {
                        $datas[$key]['listaTemplate'] = strtoupper($valuess['descripcion']);
                    }
                }

                if (isset($channels[$data['channels']])) {
                    $datas[$key]['canal'] = strtoupper($channels[$data['channels']]['name']);
                }

                if ($channels_config != null) {
                    if ($data['type'] === 1) {
                        $key_active_channels = array_keys($channels_config['channels']);
                        $ch_approve = array_diff($key_active_channels, $canales);
                    } else {
                        $ch_approve = array_keys($channels_config['channels']);
                    }
                }

                if ($data['type'] === 1) {
                    if ($data['repeatUsers'] === 0) {
                        $suma_total += $data['registros_unicos'];
                    } else {
                        $suma_total += $data['total_registros'];
                    }
                    $porcentaje_total += $data['cobertura'];
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

        $estrc = array_merge($estrc, $mejor);

        // return $estrc;

        return view('strategy/diseno', compact('template_client', 'lista_discadores', 'client', 'datas', 'porcentaje_total',  'suma_total', 'channels', 'estrc', 'ch_approve', 'channels_config'));
    }

    public function testStrategy(Request $request)
    {

        $tipos_masivos = [];
        $full_merge = [];

        $data_client = self::getClientData($request->prefix, true);


        $estrategias_cache = $data_client['stategies'];
        $config_channels = json_decode($data_client['client']['channels'], true);

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

        try {
            $result_query = Http::post(env('API_URL') . env('API_ESTRATEGIA') . "/records", $param);

            if ($result_query) {
                if ($result_query == 'false') {
                    return response()->json(['error' => 'Error de timeout', 'param' => $param], 404);
                }

                $rst = json_decode($result_query, true);
                if (array_key_exists('status', $rst)) {

                    if ($rst['status'] == false) {
                        return response()->json(['error' => "Error en la consulta por favor contacte a soporte tecnico, con el siguiente mensaje: \nError de tipo: Bases de datos\n Problema: Error en la consulta"], 404);
                    }
                }

                if ($rst[0][0]['total_records'] == 0) {
                    return response()->json(['error' => "Lo sentimos pero los parametros utilizados no cumplen con ningun criterio de busqueda, por favor verifique sus criterios"], 400);
                }
            }

            $coleccion = $result_query->collect()[0];
            $response_ruts = array_values(json_decode($coleccion[0]['detail_records'], true));


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
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la solicitud HTTP: ' . $e->getMessage()], 500);
        }
    }


    public function saveStrategy(Request $request)
    {

        // return $request;
        $getEstrategiasCliente = Http::get(env('API_URL') . env('API_ESTRATEGIAS') . '/diseno/' . $request->prefix);

        $data = $getEstrategiasCliente->json(0);
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

        // $exist_record = []; // ! Quitar me estoy saltando la validacion

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
            $saveQuery['channels'] = $request->channels;
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

    public function acceptedStrategy(Request $request)
    {

        $actived = Http::put(env('API_URL') . env('API_ESTRATEGIA') . "/activar/" . $request->id);
        return ['message' => 'Puesto en produccion', 'result' => $actived['status']];
    }

    public function deleteStrategy(Request $request)
    {

        // return $request;
        $actived = Http::delete(env('API_URL') . env('API_ESTRATEGIA') . "/eliminar/" . $request->id);
        return ['message' => 'Estrategia eliminada', 'result' => $actived['status']];
    }

    public function history($client, $type)
    {
        $param = ["prefix" => $client, "type" => $type];
        $historical = Http::withBody(json_encode($param))->get(env('API_URL') . env('API_ESTRATEGIA') . "/tipo", $param)->json(0);

        $data_client = self::getClientData($client, false);
        $channels = $data_client['channels'];
        $channels_config = json_decode($data_client['client']['channels'], true);

        $total_cartera = 0;
        $suma_total = 0;
        $porcentaje_total = 0;

        foreach ($historical as &$d3) {
            unset($d3['registros']);
        }


        $data_counter = count($historical);

        if ($data_counter > 0) {
            foreach ($historical as $key => $data) {
                if (isset($channels[$data['channels']])) {
                    $historical[$key]['canal'] = strtoupper($channels[$data['channels']]['name']);
                }


                if ($data['type'] === 3 && $data['inProcess'] == 2) {
                    if ($data['repeatUsers'] === 0) {
                        $suma_total += $data['registros_unicos'];
                    } else {
                        $suma_total += $data['total_registros'];
                    }
                    $porcentaje_total += $data['cobertura'];
                }
            }
        }

        $data_client = [
            'prefix_client' => $data_client['client']['prefix'],
            'client_id' => $data_client['client']['id']
        ];

        // return $historical;

        return view('strategy.history', compact('historical', 'data_client', 'suma_total', 'porcentaje_total'));
    }
}
