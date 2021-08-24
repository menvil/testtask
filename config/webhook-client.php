<?php

return [
    'configs' => [
        [
            /*
             * This package supports multiple webhook receiving endpoints. If you only have
             * one endpoint receiving webhooks, you can use 'default'.
             */
            'name' => 'webhook-sending-app-1',

            /*
             * We expect that every webhook call will be signed using a secret. This secret
             * is used to verify that the payload has not been tampered with.
             */
            'signing_secret' => 'secret-for-webhook-sending-app-1',
            //'signing_secret' => 'whsec_mBMG207Mtle5SM1IHqWcCtSoQA4cxwys',

            /*
             * The name of the header containing the signature.
             */
            'signature_header_name' => 'Stripe-Signature',

            /*
             *  This class will verify that the content of the signature header is valid.
             *
             * It should implement \Spatie\WebhookClient\SignatureValidator\SignatureValidator
             */
            'signature_validator' => App\Handler\StripeSignatureValidator::class,
            //'signature_validator' => \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class,

            /*
             * This class determines if the webhook call should be stored and processed.
             */
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,

            /*
             * This class determines the response on a valid webhook call.
             */
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,

            /*
             * The classname of the model to be used to store call. The class should be equal
             * or extend Spatie\WebhookClient\Models\WebhookCall.
             */
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,

            /*
             * The class name of the job that will process the webhook request.
             * signature_validator
             * This should be set to a class that extends \Spatie\WebhookClient\ProcessWebhookJob.
             */
            'process_webhook_job' => App\Handler\ProcessWebhookStripe::class,
        ],

        [
            /*
             * This package supports multiple webhook receiving endpoints. If you only have
             * one endpoint receiving webhooks, you can use 'default'.
             */
            'name' => 'webhook-sending-app-2',

            /*
             * We expect that every webhook call will be signed using a secret. This secret
             * is used to verify that the payload has not been tampered with.
             */
            'signing_secret' => 'any',
            //'signing_secret' => 'whsec_mBMG207Mtle5SM1IHqWcCtSoQA4cxwys',

            /*
             * The name of the header containing the signature.
             */
            'signature_header_name' => 'Any header',

            /*
             *  This class will verify that the content of the signature header is valid.
             *
             * It should implement \Spatie\WebhookClient\SignatureValidator\SignatureValidator
             */
            'signature_validator' => App\Handler\FakeSignatureValidator::class,

            /*
             * This class determines if the webhook call should be stored and processed.
             */
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,

            /*
             * This class determines the response on a valid webhook call.
             */
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,

            /*
             * The classname of the model to be used to store call. The class should be equal
             * or extend Spatie\WebhookClient\Models\WebhookCall.
             */
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,

            /*
             * The class name of the job that will process the webhook request.
             * signature_validator
             * This should be set to a class that extends \Spatie\WebhookClient\ProcessWebhookJob.
             */
            'process_webhook_job' => App\Handler\ProcessWebhookFake::class,
        ],
    ],
];
