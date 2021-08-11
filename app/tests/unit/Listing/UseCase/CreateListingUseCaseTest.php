<?php

use Models\Entities\Listing;
use UnitTests\Listing\BaseListingTest;
use UseCases\Listings\CreateListingUseCase;

class CreateListingUseCaseTest extends BaseListingTest
{

    public function testCreateListings()
    {
        $useCase = new CreateListingUseCase($this->listRepository);
        $filterArgs = [
            'size' => $this->faker->numberBetween(0,50),
            'price' => $this->faker->numberBetween(100,2000)
        ];
        $listing = $useCase->handle($filterArgs);
        self::assertInstanceOf(Listing::class, $listing);
    }
}