<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmailTemplateController extends Controller
{
    public function store(Request $request)
    {
        $saveConfig = [
            'nombreTemplate' =>  $request->nombreTemplate,
            'prefix' => $request->prefix,
            'body' => base64_encode(file_get_contents($request->file('template'))),
            'emailFrom' => $request->emailFrom,
            'nombreFrom' => $request->nombreFrom,
            'asunto' => $request->asunto,
            'emailReply' => $request->emailReply,
            'columnas' => json_encode([]),
            'columnasCalc' => json_encode([]),

        ];


        // return $saveConfig;


        $getConfigMails = Http::post(env('API_URL') . env('API_EMAIL') . '/store-template', $saveConfig);

        $result = $getConfigMails->json();

        if ($result !== 0) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }


    public static function getEmailTemplates($prefix)
    {
        $getEmailTemplates = Http::get(env('API_URL') . env('API_EMAIL') . "/template-client/{$prefix}")->json()[0];

        return $getEmailTemplates;
    }

    public function getTemplateId(Request $request)
    {
        $getEmailTemplate = Http::get(env('API_URL') . env('API_EMAIL') . "/template/{$request->template_id}")->json()[0][0];

        return response()->json($getEmailTemplate, 200);
    }

    public function updateTemplate(Request $request)
    {
        // ! POR HACER
        return $request;
    }
}
