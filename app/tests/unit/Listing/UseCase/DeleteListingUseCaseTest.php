<?php

use UnitTests\Listing\BaseListingTest;
use UseCases\Listings\DeleteListingUseCase;

class DeleteListingUseCaseTest extends BaseListingTest
{

    public function testDeleteListings()
    {
        $useCase = new DeleteListingUseCase($this->listRepository);
        $listing = $useCase->handle($this->faker->numberBetween(0,50));
        self::assertEmpty($listing);
    }
}