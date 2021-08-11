<?php
namespace Models\Dtos;

use Casper\Exceptions\ValidationFailedException;
use Casper\Forms;
use JsonException;
use stdClass;

abstract class BaseDto extends Forms
{
    /**
     * @param String $attribute
     * @return string
     */
    public static function toCamelCase(string $attribute): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute))));
    }

    /**
     * @param $data
     * @return array|null
     * @throws JsonException
     */
    public static function toCamelCaseRecursive($data): ?array
    {
        if(is_null($data)) {
            return null;
        }

        $data = json_decode(json_encode($data),true);

        $data = self::filterInput($data);

        if (is_array($data))
        {
            foreach ($data as $key => $value)
            {
                unset($data[$key]);
                $key = self::toCamelCase((string) $key);
                $data[$key] = $value;

                if (is_array($value))
                {
                    $data[$key] = self::toCamelCaseRecursive($value);
                }

            }
        }

        if ($data instanceof stdClass) {
            return self::toCamelCaseRecursive((array)$data);
        }

        return $data;
    }

    public static function filterInput(array $data): array
    {
        $response = [];
        foreach ($data as $key => $row){
            if(!is_null($row) && $row !== ''){
                $response[$key] = $row;
            }
        }

        return $response;
    }
    protected function validate_year()
    {
        $data = $this->getData();
        if(!empty($data['year']) && strtotime($data['year']) === false) {
            throw new ValidationFailedException('Invalid Year');
        }

        return $data['year'] ?? null;
    }
}