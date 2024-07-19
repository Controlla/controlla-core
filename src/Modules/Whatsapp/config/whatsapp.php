<?php

/*
|--------------------------------------------------------------------------
| Configuración de Twilio para WhatsApp Business
|--------------------------------------------------------------------------
|
| Aquí puedes definir las credenciales de la cuenta de Twilio necesarias
| para la integración con WhatsApp Business. Estos valores se obtienen de
| las variables de entorno definidas en tu archivo .env.
|
| (c) Iván Sotelo <isotelo@controlla.com.mx>
*/

return [
  /*
  |--------------------------------------------------------------------------
  | SID de la Cuenta de Twilio
  |--------------------------------------------------------------------------
  |
  | Este valor es el SID de tu cuenta de Twilio. Se utiliza para autenticar
  | las solicitudes API que se hacen a Twilio. Asegúrate de definir este
  | valor en tu archivo .env.
  |
  */

  'sid' => env('TWILIO_ACCOUNT_SID'),

  /*
  |--------------------------------------------------------------------------
  | Token de Autenticación de Twilio
  |--------------------------------------------------------------------------
  |
  | Este valor es el token de autenticación de Twilio. Junto con el SID de
  | la cuenta, este token se usa para autenticar las solicitudes API que se
  | hacen a Twilio. Asegúrate de definir este valor en tu archivo .env.
  |
  */

  'token' => env('TWILIO_AUTH_TOKEN'),

  /*
  |--------------------------------------------------------------------------
  | Número de WhatsApp de Twilio
  |--------------------------------------------------------------------------
  |
  | Este es el número de WhatsApp proporcionado por Twilio. Se utiliza como
  | el número de origen al enviar mensajes de WhatsApp. Asegúrate de definir
  | este valor en tu archivo .env.
  |
  */

  'wa_number' => env('TWILIO_WA_NUMBER'),
];
