<?php

namespace UseCases\Listings;

use App\Repositories\ListingRepository;
use Exceptions\DatabaseException;
use Models\Entities\Listing;

class CreateListingUseCase
{

    protected ListingRepository $listingRepository;

    /**
     * @param ListingRepository $listingRepository
     */
    public function __construct(ListingRepository $listingRepository)
    {
        $this->listingRepository = $listingRepository;
    }

    /**
     * @param array $args
     * @return Listing
     * @throws DatabaseException
     */
    public function handle(array $args): Listing
    {
        $listing = (new Listing())->setAttributes($args);
        return $this->listingRepository->save($listing);
    }

}