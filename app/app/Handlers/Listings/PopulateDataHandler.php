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

class PopulateDataHandler extends BaseHandler
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
     * @throws Exception
     * @throws JsonException
     */
    public function handle(array $args): array
    {
        $size = $args['itemsToAdd'] ?? 11;
        while ($size >= 0){
            $dto = $this->listingDto::populateListingDataDto($args);
            if($dto->isValid()){
                $this->createListingUseCase->handle($dto->getCleanedData());
            }
            $size--;
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