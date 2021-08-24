<?php
namespace App\Handler;

use Illuminate\Http\Request;
use Log;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;


class FakeSignatureValidator implements SignatureValidator{

    public function isValid(Request $request, WebhookConfig $config): bool
    {
        return true;
        $signature = $request->header($config->signatureHeaderName);

        if (! $signature) {
            return false;
        }

        $signingSecret = $config->signingSecret;

        if (empty($signingSecret)) {
            throw WebhookFailed::signingSecretNotSet();
        }

        $computedSignature = hash_hmac('sha256', "", $signingSecret);

        return hash_equals($signature, $computedSignature);
    }
}
