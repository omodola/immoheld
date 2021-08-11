<?php

use Models\Entities\Listing;
use UnitTests\Listing\BaseListingTest;
use UseCases\Listings\GetListingByIdUseCase;

class GetByIdUseCaseTest extends BaseListingTest
{

    public function testGetById()
    {
        $useCase = new GetListingByIdUseCase($this->listRepository);

        $id = $this->faker->numberBetween(1, 50);
        $listing = $useCase->handle($id);
        self::assertInstanceOf(Listing::class, $listing);
    }
}