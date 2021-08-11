<?php

namespace UseCases\Listings;

use App\Repositories\ListingRepository;
use Exceptions\DatabaseException;
use Models\Entities\Listing;

class GetListingsUseCase
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
     * @param string|null $orderBy
     * @param string|null $order
     * @return Listing[]
     * @throws DatabaseException
     */
    public function handle(array $args=[], ?string $orderBy='id',?string $order='asc'): array
    {
        // defaults for sorting
        $orderBy = empty($orderBy) ? 'id' : $orderBy;
        $order   = empty($order) ? 'asc' : $order;

        // filter searchable fields
        $args = $this->getListingFields($args);

        // get data from db
        return $this->listingRepository->get($args, $orderBy, $order);

    }

    /**
     * @param array $givenFields
     * @return array
     */
    protected function getListingFields(array $givenFields): array
    {
        if (empty($givenFields)) {
            return [];
        }

        $rowToSearch = [];
        $allowedFields = [
            'minPrice' => 'min_price',
            'maxPrice' => 'max_price',
            'minSize' => 'min_size',
            'maxSize' => 'max_size',
            'id'       => 'listings.id',
        ];

        foreach ($allowedFields as $row => $value) {
            if(array_key_exists($row, $givenFields) && !is_null($givenFields[$row])){
                $rowToSearch[$value] = $givenFields[$row];
            }
        }

        $rowToSearch = $this->adjustPrice($rowToSearch);
        return $this->adjustSize($rowToSearch);
    }

    /**
     * @param array $rows
     * @return array
     */
    private function adjustPrice(array $rows): array
    {
        if(array_key_exists('min_price', $rows)){
            $minPrice = sprintf("price >= '%s'",$rows['min_price']);
            $rows[$minPrice] = null;
            unset($rows['min_price']);
        }

        if(array_key_exists('max_price', $rows)){
            $maxPrice = sprintf("price <= '%s'",$rows['max_price']);
            $rows[$maxPrice] = null;
            unset($rows['max_price']);
        }

        return $rows;
    }

    /**
     * @param array $rows
     * @return array
     */
    private function adjustSize(array $rows): array
    {
        if(array_key_exists('min_size', $rows)){
            $minSize = sprintf("size >= '%s'",$rows['min_size']);
            $rows[$minSize] = null;
            unset($rows['min_size']);
        }

        if(array_key_exists('max_size', $rows)){
            $maxSize = sprintf("size <= '%s'",$rows['max_size']);
            $rows[$maxSize] = null;
            unset($rows['max_size']);
        }

        return $rows;
    }
}