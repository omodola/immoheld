<?php

namespace UseCases\Listings;

use App\Repositories\ListingRepository;
use Exceptions\DatabaseException;
use Models\Entities\Listing;

class DeleteListingUseCase
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
     * @param int $listingId
     * @param array $args
     * @return Listing
     * @throws DatabaseException
     */
    public function handle(int $listingId): void
    {
        $this->listingRepository->delete($listingId);
    }

}