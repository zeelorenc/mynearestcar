<?php

namespace App\Adapters;

use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\StripeClient;
use Throwable;

class StripeAdapter
{
    /** @var StripeClient */
    protected $stripe;

    /** @var Customer */
    protected $customer;

    public function __construct(?string $secretKey = null)
    {
        $this->stripe = new StripeClient($secretKey ?? config('services.stripe.secret'));
        $this->customer = null;
    }

    /**
     * Return static instance of the adapter itself
     *
     * @return self
     */
    public static function make(?string $secretKey = null): self
    {
        return new static($secretKey);
    }

    /**
     * Return the Stripe client
     *
     * @return StripeClient
     */
    public function stripe(): StripeClient
    {
        return $this->stripe;
    }

    /**
     * Create a customer in stripe
     *
     * @return $this
     * @throws ApiErrorException
     */
    public function customer(array $info): self
    {
        $this->customer = $this->stripe->customers->create($info);
        return $this;
    }

    /**
     * Charge the customer a dollar amount
     *
     * @param float $amount
     * @return array
     * @throws UnexpectedValueException|Throwable
     */
    public function charge(float $amount, string $description): array
    {
        throw_if($this->customer === null, UnexpectedValueException::class);
        return $this->stripe->charges
            ->create([
                'customer' => $this->customer->id,
                'amount' => $amount * 100,
                'currency' => 'aud',
                'description' => $description,
            ])
            ->toArray();
    }
}
