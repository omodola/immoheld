<?php

namespace Models\Dtos\Listings;

use Casper\Fields\IntegerField;
use Models\Dtos\BaseDto;

class GetListingByIdDto extends BaseDto
{
    public IntegerField $id;

    protected function build(): void
    {
        $this->id = $this->integerField()->minValue(1);
    }
}