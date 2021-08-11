<?php
namespace Models\Dtos\Listings;

use Exception;
use JsonException;
use Models\Dtos\BaseDto;

class ListingDto extends BaseDto
{
    /**
     * @param array $data
     * @return GetListingByIdDto
     * @throws JsonException
     * @throws Exception
     */
    public static function getListingByIdDto(array $data): GetListingByIdDto
    {
        return (new GetListingByIdDto())->setData(self::toCamelCaseRecursive($data));
    }

    /**
     * @param array $data
     * @return GetListingsDto
     * @throws JsonException
     * @throws Exception
     */
    public static function getListingsDto(array $data): GetListingsDto
    {
        return (new GetListingsDto())->setData(self::toCamelCaseRecursive($data));
    }

    /**
     * @param array $data
     * @return CreateListingDto
     * @throws JsonException
     * @throws Exception
     */
    public static function createListingDto(array $data): CreateListingDto
    {
        return (new CreateListingDto())->setData(self::toCamelCaseRecursive($data));
    }

    /**
     * @param array $data
     * @return EditListingDto
     * @throws JsonException
     * @throws Exception
     */
    public static function editListingDto(array $data): EditListingDto
    {
        return (new EditListingDto())->setData(self::toCamelCaseRecursive($data));
    }

    /**
     * @param array $data
     * @return PopulateListingDataDto
     * @throws JsonException
     * @throws Exception
     */
    public static function populateListingDataDto(array $data): PopulateListingDataDto
    {
        return (new PopulateListingDataDto())->setData(self::toCamelCaseRecursive($data));
    }


    protected function build(): void
    {
        // TODO: Implement build() method.
    }
}