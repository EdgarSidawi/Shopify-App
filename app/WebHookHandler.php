<?php

namespace App;

use Spatie\WebhookClient\ProcessWebhookJob;

class WebHookHandler extends ProcessWebhookJob
{
    public function handler()
    {
        logger("i am here");
        logger($this->webhookCall);
        return $this->webhookCall;
    }
}
