<?php

namespace App;

use Spatie\WebhookClient\ProcessWebhookJob;

class WebHookHandler extends ProcessWebhookJob
{
    public function handler()
    {
        logger($this->webhookCall);
        return $this->webhookCall;
    }
}
