<?php

namespace Tests\Traits;

use App\Adapters\StripeAdapter;

trait StripeMockable
{
    /**
     * This will require the test to have stripe configured
     *
     * @return void
     */
    protected function requireStripeToBeConfigured(): void
    {
        if (empty(config('services.stripe.secret'))) {
            $this->markTestSkipped('Skipping test as Stripe secret key is unavailable');
        }
    }

    /**
     * Mock a stripe token
     *
     * @return array
     * @throws \Stripe\Exception\ApiErrorException
     */
    protected function mockStripeCardToken(): array
    {
        return StripeAdapter::make()
            ->stripe()
            ->tokens->create([
                'card' => [
                    'number' => '4242424242424242',
                    'exp_month' => 8,
                    'exp_year' => 2022,
                    'cvc' => '314',
                ],
            ])
            ->toArray();
    }
}
