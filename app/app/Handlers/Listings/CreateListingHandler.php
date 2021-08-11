<?php

namespace Handlers\Listings;

use App\Repositories\ListingRepository;
use Casper\Exceptions\FormNotValidatedException;
use Exception;
use Exceptions\DatabaseException;
use Handlers\BaseHandler;
use JsonException;
use Models\Dtos\Listings\ListingDto;
use UseCases\Listings\CreateListingUseCase;
use UseCases\Listings\GetListingsUseCase;

/**
 * Class CreateListingHandler
 * @package Handlers\Listings
 */
class CreateListingHandler extends BaseHandler
{
    protected ListingRepository $listingRepository;
    protected CreateListingUseCase $createListingUseCase;
    protected GetListingsUseCase $getListingsUseCase;
    protected ListingDto $listingDto;

    public function __construct(
        ?ListingRepository $listingRepository = null,
        ?CreateListingUseCase $createListingUseCase = null,
        ?GetListingsUseCase $getListingsUseCase = null,
        ?ListingDto $listingDto = null
    )

    {
        $this->listingRepository =
            is_null($listingRepository)
                ? new ListingRepository()
                : $listingRepository;

        $this->createListingUseCase =
            is_null($createListingUseCase)
                ? new CreateListingUseCase($this->listingRepository)
                : $createListingUseCase;

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
     * @throws DatabaseException
     * @throws JsonException
     * @throws Exception
     */
    public function handle(array $args): array
    {
        //validation
        $dto = $this->listingDto::createListingDto($args);
        $this->data = $dto->getData();
        $this->errors = $dto->getErrors();
        if($dto->isValid()){
            return $this->createListingUseCase->handle($dto->getCleanedData())->toArray();
        }

        $listings = $this->getListingsUseCase->handle([]);

        // set result to array for view
        $data = [];
        foreach ($listings as $listing){
            $data[] = $listing->toArray();
        }

        return $data;
    }

}