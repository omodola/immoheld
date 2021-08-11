<?php

namespace Handlers\Listings;

use App\Repositories\ListingRepository;
use Exception;
use Exceptions\DatabaseException;
use Handlers\BaseHandler;
use JsonException;
use Models\Dtos\Listings\ListingDto;
use UseCases\Listings\GetListingByIdUseCase;
use UseCases\Listings\GetListingsUseCase;

class GetListingByIdHandler extends BaseHandler
{

    protected ListingRepository $listingRepository;
    protected GetListingByIdUseCase $getListingByIdUseCase;
    protected ListingDto $listingDto;
    protected GetListingsUseCase $getListingsUseCase;


    public function __construct(
        ?ListingRepository $listingRepository = null,
        ?GetListingByIdUseCase $getListingByIdUseCase = null,
        ?GetListingsUseCase $getListingsUseCase = null,
        ?ListingDto $listingDto = null
    )
    {
        $this->listingRepository =
            is_null($listingRepository)
                ? new ListingRepository()
                : $listingRepository;

        $this->getListingByIdUseCase =
            is_null($getListingsUseCase)
                ? new GetListingByIdUseCase($this->listingRepository)
                : $getListingByIdUseCase;

        $this->listingDto = is_null($listingDto) ? new ListingDto() : $listingDto;

        $this->getListingsUseCase =
            is_null($getListingsUseCase)
                ? new GetListingsUseCase($this->listingRepository)
                : $getListingsUseCase;
    }


    /**
     * @param int $id
     * @return array
     * @throws DatabaseException
     * @throws JsonException
     * @throws Exception
     */
    public function handle(int $id): array
    {
        //validation
        $dto = $this->listingDto::getListingByIdDto(['id' => $id]);
        $this->data = $dto->getData();
        $this->errors = $dto->getErrors();
        if($dto->isValid()){
            return $this->getListingByIdUseCase->handle($dto->id->data())->toArray();
        }

        $listings = $this->getListingsUseCase->handle([]);

        $data = [];
        foreach ($listings as $listing){
            $data[] = $listing->toArray();
        }
        return $data;
    }
}