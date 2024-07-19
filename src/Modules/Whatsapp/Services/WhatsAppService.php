<?php

namespace Controlla\Core\Modules\Whatsapp\Services;

use Twilio\Rest\Client;

class WhatsAppService
{
  protected $client;
  protected $waNumber;

  /**
   * Constructor de la clase WhatsAppService.
   *
   * @return void
   */
  public function __construct()
  {
    $sid = config('whatsapp.sid');
    $token = config('whatsapp.token');
    $this->waNumber = config('whatsapp.wa_number');
    $this->client = new Client($sid, $token);
  }

  /**
   * Enviar un mensaje de WhatsApp.
   *
   * @param string $to El número de teléfono de destino en formato E.164.
   * @param string $message El mensaje que se va a enviar.
   * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
   */
  public function sendMessage(string $to, string $message)
  {
    return $this->client->messages->create(
      "whatsapp:$to",
      [
        'from' => "whatsapp:$this->waNumber",
        'body' => $message
      ]
    );
  }
}
