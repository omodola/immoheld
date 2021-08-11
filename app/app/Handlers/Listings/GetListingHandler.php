<?php

namespace Handlers\Listings;


use App\Repositories\ListingRepository;
use Casper\Exceptions\FormNotValidatedException;
use Exceptions\DatabaseException;
use Handlers\BaseHandler;
use JsonException;
use Models\Dtos\Listings\ListingDto;
use Models\Entities\Listing;
use UseCases\Listings\GetListingsUseCase;

/**
 * Class GetListingHandler
 * @package Handlers\Listings
 */
class GetListingHandler extends BaseHandler
{
    protected ListingRepository $listingRepository;
    protected GetListingsUseCase $getListingsUseCase;
    protected ListingDto $listingDto;

    public function __construct(
        ?ListingRepository $listingRepository = null,
        ?GetListingsUseCase $getListingsUseCase = null,
        ?ListingDto $listingDto = null

    )
    {
        $this->listingRepository =
            is_null($listingRepository)
                ? new ListingRepository()
                : $listingRepository;
        $this->listingDto = is_null($listingDto) ? new ListingDto() : $listingDto;

        $this->getListingsUseCase =
            is_null($getListingsUseCase)
                ? new GetListingsUseCase($this->listingRepository)
                : $getListingsUseCase;
    }

    /**
     * @param array $args
     * @return array
     * @throws FormNotValidatedException
     * @throws JsonException
     * @throws DatabaseException
     */
    public function handle(array $args = []): array
    {
        // validation
        $dto = $this->listingDto::getListingsDto($args);
        $this->errors = $dto->getErrors();
        $this->data = $dto->getData();

        // sorting
        $order = Listing::LISTING_SORTING;
        $orderBy = $dto->getCleanedData()['order']  ?? 'newest_first';
        $this->data['order'] = $orderBy;
        $orderBy = $order[$orderBy];

        // fetch results
        $listings = $this->getListingsUseCase->handle(
            $dto->getCleanedData(),
            $orderBy['orderBy'],
            $orderBy['order']
        );

        // set result to array for view
        $data = [];
        foreach ($listings as $listing){
            $data[] = $listing->toArray();
        }

        return $data;
    }

}