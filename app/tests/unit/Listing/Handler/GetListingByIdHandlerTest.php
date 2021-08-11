<?php

use Handlers\Listings\GetListingByIdHandler;
use Models\Entities\Listing;
use UnitTests\Listing\BaseListingTest;
use UseCases\Listings\GetListingByIdUseCase;
use UseCases\Listings\GetListingsUseCase;

class GetListingByIdHandlerTest extends BaseListingTest
{

    public function testGetListingById()
    {
        $handler = new GetListingByIdHandler(
            $this->listRepository,
            new GetListingByIdUseCase($this->listRepository),
            new GetListingsUseCase($this->listRepository),
            $this->listingDto
        );

        $listing = $handler->handle($this->faker->numberBetween(1,50));
        self::assertIsArray($listing);
    }
}