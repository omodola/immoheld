<?php

namespace App\Repositories;

use Exceptions\DatabaseException;
use Models\Entities\Listing;

class ListingRepository extends BaseRepository
{
    /**
     * @param array $args
     * @param string $orderBy
     * @param string $order
     * @return Listing[]
     * @throws DatabaseException
     */
    public function get(array $args,  ?string $orderBy='id',?string $order='asc'): array
    {
        $response = [];
        $args['listings.deleted_at IS NULL'] = null;
        $sql = $this->getListingSql()
            .$this->buildWhere($args)
            .$this->setOrderBY($orderBy, $order)
            .$this->setLimit(24);

        $data = $this->fetchData($sql);

        foreach ($data as $row){
            $response[] = $this->createListingEntity($row);
        }

        return $response;
    }

    /**
     * @param int $id
     * @return Listing
     * @throws DatabaseException
     */
    public function getById(int $id): Listing
    {
        $sql = $this->getListingSql()
            .$this->buildWhere(['listings.id' => $id,'listings.deleted_at IS NULL' => null])
            .$this->setLimit(1);

        $data = $this->fetchOne($sql);
        if(is_null($data)){
            throw new DatabaseException('Listing not found');
        }
        return $this->createListingEntity($data);
    }

    /**
     * @param Listing $listing
     * @return Listing
     * @throws DatabaseException
     */
    public function save(Listing $listing): Listing
    {
        $listingId = $this->insert('listings', [
            'rooms' => $listing->getRooms(),
            'listing_type_id' => $this->getListingTypeId($listing->getType()),
            'size' => $listing->getSize(),
            'address' => $listing->getAddress(),
            'year' => $listing->getYear()
        ]);

        $this->saveListingPrice($listingId, $listing->getPrice());

        $this->saveListingPhoto($listingId, $listing->getUrl());

        return $this->getById($listingId);
    }

    /**
     * @param int $listingId
     * @param float $price
     * @throws DatabaseException
     */
    private function saveListingPrice(int $listingId, float $price): void
    {
        $this->update('listings_prices', [
            'listing_id' => $listingId,
            'deleted_at =' => null
        ], [
            'deleted_at' => gmdate('Y-m-d H:i:s')
        ]);

        $photoId = $this->insert('prices', [
            'price' => $price
        ]);

        $this->insert('listings_prices', [
            'listing_id' => $listingId,
            'price_id' => $photoId
        ]);
    }

    /**
     * @param int $listingId
     * @param string $url
     * @throws DatabaseException
     */
    private function saveListingPhoto(int $listingId, string $url): void
    {
        $this->update('listings_photos', [
            'listing_id' => $listingId,
            'deleted_at =' => null
        ], [
            'deleted_at' => gmdate('Y-m-d H:i:s')
        ]);

        $photoId = $this->insert('photos', [
            'url' => $url
        ]);

        $this->insert('listings_photos', [
            'listing_id' => $listingId,
            'photo_id' => $photoId
        ]);
    }

    /**
     * @param string $listingType
     * @return int
     * @throws DatabaseException
     */
    public function getListingTypeId(string $listingType): int
    {
        $sql = "SELECT id FROM listing_types WHERE type = ? LIMIT 1";
        $type = $this->fetchOne($sql,[$listingType]);

        if($type === null){
            return $this->insert('listing_types', ['type' => $listingType]);
        }

        return $type->id;
    }

    /**
     * @param int $listingId
     * @param array $args
     * @return Listing
     * @throws DatabaseException
     */
    public function edit(int $listingId, array $args): Listing
    {
        if(array_key_exists('url', $args)){
            $this->saveListingPhoto($listingId, $args['url']);
            unset($args['url']);
        }

        if(array_key_exists('price', $args)){
            $this->saveListingPhoto($listingId, $args['url']);
            unset($args['price']);
        }

        if(array_key_exists('type', $args)){
            $args['list_type_id'] = $this->getListingTypeId($args['type']);
            unset($args['type']);
        }

        if(!empty($args)){
            $this->update('listings', [
                'id' => $listingId,
                'deleted_at !=' => null
            ], $args);
        }

        return $this->getById($listingId);
    }

    public function delete(int $listingId): void
    {
        $this->update('listings', [
            'id' => $listingId,
            'deleted_at =' => null
        ], [
            'deleted_at' => gmdate('Y-m-d H:i:s')
        ]);
    }

    /**
     * @param object $data
     * @return Listing
     */
    private function createListingEntity(object $data): Listing
    {
        return (new Listing())->setAttributes((array) $data)
            ->setCreatedAt($data->created_at)
            ->setUpdatedAt($data->updated_at)
            ->setDeletedAt($data->deleted_at);
    }

    /**
     * @return string
     */
    private function getListingSql(): string
    {
        return "SELECT
                    listings.id id , size,rooms, address,price, year, type, url,
                    listings.created_at,listings.updated_at,
                    listings.deleted_at
                FROM listings
                INNER JOIN listing_types lt ON (
                    lt.id = listings.listing_type_id
                    AND lt.deleted_at IS NULL
                )
                INNER JOIN listings_photos lp ON (
                    listings.id = lp.listing_id
                    AND lp.deleted_at IS NULL
                )
                INNER JOIN photos photo ON (
                    lp.photo_id = photo.id
                    AND photo.deleted_at IS NULL
                )
                INNER JOIN listings_prices lpr ON (
                    listings.id = lpr.listing_id
                    AND lpr.deleted_at IS NULL
                )
                INNER JOIN prices pricing ON (
                    pricing.id = lpr.price_id
                    AND pricing.deleted_at IS NULL
                )";
    }
}