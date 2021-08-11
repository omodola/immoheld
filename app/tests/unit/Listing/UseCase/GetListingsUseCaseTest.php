<?php

use UnitTests\Listing\BaseListingTest;
use UseCases\Listings\GetListingsUseCase;

class GetListingsUseCaseTest extends BaseListingTest
{

    public function testGetListings()
    {
        $useCase = new GetListingsUseCase($this->listRepository);
        $filterArgs = [
            'minPrice' => $this->faker->numberBetween(0,50),
            'maxPrice' => $this->faker->numberBetween(100,2000)
        ];
        $listings = $useCase->handle($filterArgs);
        self::assertTrue(is_array($listings));
    }
}