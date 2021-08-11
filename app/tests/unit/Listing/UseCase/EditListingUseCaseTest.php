<?php

use Models\Entities\Listing;
use UnitTests\Listing\BaseListingTest;
use UseCases\Listings\EditListingUseCase;

class EditListingUseCaseTest extends BaseListingTest
{

    public function testEditListings()
    {
        $useCase = new EditListingUseCase($this->listRepository);
        $filterArgs = [
            'size' => $this->faker->numberBetween(0,50),
            'price' => $this->faker->numberBetween(100,2000)
        ];
        $listing = $useCase->handle($this->faker->numberBetween(1,5), $filterArgs);
        self::assertInstanceOf(Listing::class, $listing);
    }
}