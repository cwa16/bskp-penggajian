<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use WaAPI\WaAPI;

class WhatsAppController extends Controller
{
    public function sendWhatsAppMessage(Request $request)
    {
        $phoneNumber = $request->input('number_phone');
        $waAPI = new WaAPI\WaAPI();
        $waAPI->sendMessage('6287878998251@c.us', 'Hello there!');
    }
}
