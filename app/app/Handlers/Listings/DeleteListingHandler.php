<?php

namespace Handlers\Listings;

use App\Repositories\ListingRepository;
use Casper\Exceptions\FormNotValidatedException;
use Exception;
use Exceptions\DatabaseException;
use Handlers\BaseHandler;
use JsonException;
use Models\Dtos\Listings\ListingDto;
use UseCases\Listings\DeleteListingUseCase;
use UseCases\Listings\GetListingsUseCase;

class DeleteListingHandler extends BaseHandler
{
    protected ListingRepository $listingRepository;
    protected DeleteListingUseCase $deleteListingUseCase;
    protected ListingDto $listingDto;
    protected GetListingsUseCase $getListingsUseCase;

    public function __construct(
        ?ListingRepository $listingRepository = null,
        ?DeleteListingUseCase $deleteListingUseCase = null,
        ?GetListingsUseCase $getListingsUseCase = null,
        ?ListingDto $listingDto = null
    )
    {
        $this->listingRepository =
            is_null($listingRepository)
                ? new ListingRepository()
                : $listingRepository;

        $this->deleteListingUseCase =
            is_null($deleteListingUseCase)
                ? new DeleteListingUseCase($this->listingRepository)
                : $deleteListingUseCase;

        $this->listingDto = is_null($listingDto) ? new ListingDto() : $listingDto;

        $this->getListingsUseCase =
            is_null($getListingsUseCase)
                ? new GetListingsUseCase($this->listingRepository)
                : $getListingsUseCase;
    }

    /**
     * @param int $id
     * @return array
     * @throws FormNotValidatedException
     * @throws DatabaseException
     * @throws JsonException
     * @throws Exception
     */
    public function handle(int $id): array
    {
        $dto = $this->listingDto::getListingByIdDto(['id' => $id]);
        $this->data = $dto->getData();
        $this->errors = $dto->getErrors();
        if($dto->isValid()){
            $this->deleteListingUseCase->handle($dto->id->data());
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