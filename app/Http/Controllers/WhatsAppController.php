<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    // public function sendWhatsAppMessage()
    // {
    //     $twilioSid = getenv("TWILIO_AUTH_SID");
    //     $twilioToken = getenv("TWILIO_AUTH_TOKEN");
    //     $twilioWhatsAppNumber = getenv("TWILIO_WHATSAPP_FROM");
    //     $recipientNumber = '+6287878998251';
    //     $message = "Hello from Twilio WhatsApp API in Laravel! 🚀";

    //     $twilio = new Client($twilioSid, $twilioToken);

    //     try {
    //         $twilio->messages->create(
    //             $recipientNumber,
    //             [
    //                 "from" => $twilioWhatsAppNumber,
    //                 "body" => $message,
    //             ]
    //         );

    //         return response()->json(['message' => 'WhatsApp message sent successfully']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function sendWhatsAppMessage(Request $request)
    {
        $twilio = app('twilio');

        $message = $twilio->messages
            ->create(
                "whatsapp:" . $request->input('number_phone'),
                [
                    "from" => "whatsapp:" . config('services.twilio.whatsapp_from'),
                    "body" => 'Your Twilio code is 1238432'
                ]
            );

        return response()->json(['message_id' => $message->sid]);
    }
}
