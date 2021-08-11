<?php

namespace UseCases\Listings;

use App\Repositories\ListingRepository;
use Exceptions\DatabaseException;
use Models\Entities\Listing;

class EditListingUseCase
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
    public function handle(int $listingId, array $args): Listing
    {
        $dataToEdit = $this->getListingEditableDbFields($args);
        return $this->listingRepository->edit($listingId, $dataToEdit);
    }

    /**
     * @param array $givenFields
     * @return array
     */
    protected function getListingEditableDbFields(array $givenFields): array
    {
        if (empty($givenFields)) {
            return [];
        }

        $rowToSearch = [];
        $editableFields = [
            'url' => 'url',
            'type' => 'type',
            'address' => 'address',
            'price' => 'price',
            'size' => 'size',
            'year' => 'year',
            'rooms' => 'rooms'
        ];

        foreach ($editableFields as $row => $value) {
            if(array_key_exists($row, $givenFields) && !is_null($givenFields[$row])){
                $rowToSearch[$value] = $givenFields[$row];
            }
        }

        return $rowToSearch;
    }

}