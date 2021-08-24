<?php
namespace App\Handler;

use \Spatie\WebhookClient\ProcessWebhookJob;


//The class extends "ProcessWebhookJob" class as that is the class
//that will handle the job of processing our webhook before we have
//access to it.
class ProcessWebhookStripe extends ProcessWebhookJob
{
    public function handle(){
        $data = json_decode($this->webhookCall, true);

        //Do something with the event
        (new StripeProvider($data['payload']))->perfomAction();
        //$provider->perfomAction();
//        exit;
//        //
//        $bookingsOfSubscriber = app('rinvex.subscriptions.plan_subscription')->ofSubscriber($user)->get();
//
//        $user->subscription('pro')->active();
//        //$user->subscription('pro')->cancel();
//        $user->subscription('pro')->onTrial();
//        $user->subscription('pro')->pending();
//        //$user->subscription('pro')->ended();
//exit;
//        print_r($user->subscription()); exit;
        logger($data['payload']);
        http_response_code(200); //Acknowledge you received the response
    }
}
