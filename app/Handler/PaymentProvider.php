<?php
namespace App\Handler;

abstract class PaymentProvider
{
    private $payload;

    public $userId;

    public function __construct(string $payload)
    {
        $this->payload = $payload;
        $this->parsePayload();
    }

    abstract public function findUser();
    abstract public function createSubscription();
    abstract public function renewSubscription();
    abstract public function failSubscription();
    abstract public function cancelSubscription();
}
