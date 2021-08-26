<?php

namespace Tests\Unit\Adapters;

use App\Adapters\DistanceAdapter;
use PHPUnit\Framework\TestCase;

class DistanceAdapterTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function it_can_throw_an_exception_for_invalid_parameters(): void
    {
        $this->expectException(\TypeError::class);
        DistanceAdapter::calculate(null, '0.0', '0.0', '0.0');
    }

    /**
     * @test
     * @dataProvider provideCoordinateData
     *
     * @return void
     */
    public function it_can_return_always_a_positive_value($coordinates): void
    {
        $distance = DistanceAdapter::calculate(
            $coordinates['latitiudeFrom'],
            $coordinates['longitudeFrom'],
            $coordinates['latitudeTo'],
            $coordinates['longitudeTo']
        );
        $this->assertGreaterThanOrEqual(0,  $distance);
    }

    public function provideCoordinateData()
    {
        return [
            'negative locations' => [[
                'latitiudeFrom' => -1,
                'longitudeFrom' => -1,
                'latitudeTo' => -1,
                'longitudeTo' => -1,
            ]],
            'positive locations' => [[
                'latitiudeFrom' => 1,
                'longitudeFrom' => 1,
                'latitudeTo' => 1,
                'longitudeTo' => 1,
            ]],
            'mixed random locations' => [[
                'latitiudeFrom' => -12,
                'longitudeFrom' => 113,
                'latitudeTo' => -11,
                'longitudeTo' => 12,
            ]],
        ];
    }


}
