<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmailTemplateController extends Controller
{
    public function store(Request $request)
    {

        // return $request;

        // Creamos un arreglo de datos para proceder a enviar al endpoint y almacenar.
        $saveConfig = [
            'nombreTemplate' =>  strtoupper($request->nombreTemplate),
            'prefix' => $request->prefix,
            'body' => base64_encode(file_get_contents($request->file('template'))),
            'emailFrom' => $request->emailFrom,
            'nombreFrom' => strtoupper($request->nombreFrom),
            'asunto' => strtoupper($request->asunto),
            'emailReply' => $request->emailReply,
            'columnas' => json_encode($request->columnas),
            'columnasCalc' => json_encode($request->columnas_calculadas),
        ];

        // return $saveConfig;

        try {
            // Cargamos los datos en el enpoint
            $getConfigMails = Http::post(env('API_URL') . env('API_EMAIL') . '/store-template', $saveConfig);

            //Obtenemos el resultado.
            $result = $getConfigMails->json();
            if ($result !== 0) {
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la solicitud HTTP: ' . $e->getMessage()], 500);
        }
    }


    public static function getEmailTemplates($prefix)
    {

        try {
            $getEmailTemplates = Http::get(env('API_URL') . env('API_EMAIL') . "/template-client/{$prefix}")->json(0);
            return $getEmailTemplates;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la solicitud HTTP: ' . $e->getMessage()], 500);
        }
    }

    public function getTemplateId(Request $request)
    {

        try {
            $getEmailTemplate = Http::get(env('API_URL') . env('API_EMAIL') . "/template/{$request->template_id}")->json()[0][0];
            return response()->json($getEmailTemplate, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en la solicitud HTTP: ' . $e->getMessage()], 500);
        }
    }

    public function updateTemplate(Request $request)
    {
        // ! POR HACER
        return $request;
    }
}
