<?php

namespace Tests\Unit\Adapters;

use App\Adapters\StripeAdapter;
use PHPUnit\Framework\TestCase;
use Stripe\Exception\UnexpectedValueException;

class StripeAdapterTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function it_can_return_a_static_instance_of_itself(): void
    {
        $this->assertInstanceOf(StripeAdapter::class, StripeAdapter::make('test_secret_key'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_throws_an_exception_when_charging_null_customer(): void
    {
        $this->expectException(UnexpectedValueException::class);
        StripeAdapter::make('test_secret_key')->charge(10, 'test');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_throws_an_exception_when_refunding_null_charge_id(): void
    {
        $this->expectException(UnexpectedValueException::class);
        StripeAdapter::make('test_secret_key')->refund(10);
    }
}
