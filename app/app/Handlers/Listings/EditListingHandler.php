<?php

namespace Handlers\Listings;

use App\Repositories\ListingRepository;
use Casper\Exceptions\FormNotValidatedException;
use Exception;
use Exceptions\DatabaseException;
use Handlers\BaseHandler;
use JsonException;
use Models\Dtos\Listings\ListingDto;
use UseCases\Listings\EditListingUseCase;
use UseCases\Listings\GetListingsUseCase;

class EditListingHandler extends BaseHandler
{
    protected ListingRepository $listingRepository;
    protected EditListingUseCase $editListingUseCase;
    protected GetListingsUseCase $getListingsUseCase;
    protected ListingDto $listingDto;

    public function __construct(
        ?ListingRepository $listingRepository = null,
        ?EditListingUseCase $editListingUseCase = null,
        ?GetListingsUseCase $getListingsUseCase = null,
        ?ListingDto $listingDto = null
    )
    {
        $this->listingRepository =
            is_null($listingRepository)
                ? new ListingRepository()
                : $listingRepository;

        $this->editListingUseCase =
            is_null($editListingUseCase)
                ? new EditListingUseCase($this->listingRepository)
                : $editListingUseCase;

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
        $dto = $this->listingDto::editListingDto($args);
        $this->data = $dto->getData();
        $this->errors = $dto->getErrors();
        if($dto->isValid()){
            try{
                return $this->editListingUseCase->handle($dto->id->data(), $dto->getCleanedData())->toArray();
            }catch (DatabaseException $databaseException){
                $this->errors['error'] = $databaseException->getMessage();
            }
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