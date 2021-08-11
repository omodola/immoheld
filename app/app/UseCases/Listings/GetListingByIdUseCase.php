<?php

namespace UseCases\Listings;

use App\Repositories\ListingRepository;
use Exceptions\DatabaseException;
use Models\Entities\Listing;

class GetListingByIdUseCase
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
     * @param int $id
     * @return Listing
     * @throws DatabaseException
     */
    public function handle(int $id): Listing
    {
        return $this->listingRepository->getById($id);
    }
}