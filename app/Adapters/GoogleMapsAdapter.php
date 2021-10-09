<?php

namespace App\Adapters;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use joshtronic\GooglePlaces;

class GoogleMapsAdapter
{
    /** @var GooglePlaces */
    protected $google;

    public function __construct(?float $latitude, ?float $longitude, float $radius = 1.0)
    {
        $this->google = new GooglePlaces(config('services.google.key'));
        $this->google->location = [$latitude, $longitude];
        $this->google->radius = $radius;
    }

    /**
     * Returns a static instance
     *
     * @param float|null $latitude
     * @param float|null $longitude
     * @param float $radius
     * @return static
     */
    public static function make(?float $latitude, ?float $longitude, float $radius = 0.1)
    {
        return new static($latitude, $longitude, $radius);
    }

    /**
     * Search the location provided and return a collection
     *
     * @return Collection
     */
    public function search(): Collection
    {
        return collect(Arr::get($this->google->nearbySearch(), 'results', []));
    }

    public function searchWithDetails(): Collection
    {
        return $this->search()
            ->map(function ($result) {
                $this->google->placeid = Arr::get($result, 'place_id');
                $result['details'] = Arr::get($this->google->details(), 'result', []);
                return $result;
            });
    }
}
