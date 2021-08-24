<?php
namespace App\Handler;

use App\Models\User;
use Rinvex\Subscriptions\Models\Plan;

class FakeProvider extends PaymentProvider
{
    private $payload;

    public $user;

    public function __construct($payload)
    {
        $this->payload = $payload;
        $this->findUser();
    }

    public function perfomAction()
    {
        switch ($this->payload['status']) {
            case "new":
                $this->createSubscription();
                break;
            case "canceled":
                $this->cancelSubscription();
                break;
            case "renewed":
                $this->renewSubscription();
                break;
            case "failed":
                $this->failSubscription();
                break;
        }
    }

    public function findUser() {
        try {
            $this->user = User::findOrFail($this->payload['user_id']);
            return $this->user;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function createSubscription() {

        $activeSubscription = $this->user->activeSubscriptions();
        $toSubscribe = true;
        foreach($activeSubscription as $item){
            if($item->plan_id == $this->payload['plan_id'] &&
                $this->user->subscription($item->slug)->active()
            ) {
                $toSubscribe = false;
            }
        }

        if($toSubscribe) {
            $plan = Plan::findOrFail($this->payload['plan_id']);
            $this->user->newSubscription($plan->slug, $plan);
            print_r("Subscribed to plan " . $plan->slug);
        } else {
            print_r("Already subscribed");
            return "Already subscribed";
        }
    }

    public function renewSubscription() {

        $activeSubscription = $this->user->activeSubscriptions();
        $toRenew = false;
        $slug = '';
        foreach($activeSubscription as $item){
            if($item->plan_id == $this->payload['plan_id'] &&
                $this->user->subscription($item->slug)->active() &&
                !$this->user->subscription($item->slug)->canceled() &&
                !$this->user->subscription($item->slug)->ended()
            ) {
                $slug = $item->slug;
                $toRenew = true;
            }
        }
        if($toRenew) {
            $plan = Plan::findOrFail($this->payload['plan_id']);
            $this->user->subscription($slug)->renew();
            print_r("Renewed plan " . $plan->slug);
        } else {
            print_r("Hasn't been subscribed before or can't renew because of cancelled");
            return "Hasn't been subscribed before or can't renew because of cancelled";
        }

    }

    public function failSubscription() {

        $activeSubscription = $this->user->activeSubscriptions();
        $toCancel = false;
        $slug = '';
        foreach($activeSubscription as $item){
            if($item->plan_id == $this->payload['plan_id'] &&
                $this->user->subscription($item->slug)->active()
            ) {
                $slug = $item->slug;
                $toCancel = true;
            }
        }

        if($toCancel) {
            $plan = Plan::findOrFail($this->payload['plan_id']);
            $this->user->subscription($slug)->cancel();
            print_r("Cancelled plan ". $plan->slug . " because something failed" );
        } else {
            print_r("Can't process request");
            return "Can't process request";
        }

    }

    public function cancelSubscription() {
        $activeSubscription = $this->user->activeSubscriptions();
        $toCancel = false;
        $slug = '';
        foreach($activeSubscription as $item){
            if($item->plan_id == $this->payload['plan_id']) {
                $slug = $item->slug;
                $toCancel = true;
            }
        }
        if($toCancel) {
            $plan = Plan::findOrFail($this->payload['plan_id']);
            $this->user->subscription($slug)->cancel();
            print_r("Cancelled from plan " . $plan->slug);
        } else {
            print_r("Already cancelled subscription or hasn't been subscribed");
            return "Already cancelled subscription or hasn't been subscribed";
        }
    }

}
