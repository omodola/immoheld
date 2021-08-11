<?php

namespace Models\Dtos\Listings;

use Casper\Fields\ChoiceField;
use Casper\Fields\FloatField;
use Casper\Fields\IntegerField;
use Casper\Fields\TextField;
use Models\Dtos\BaseDto;
use Models\Entities\Listing;

class GetListingsDto extends BaseDto
{
    public IntegerField $id;
    public FloatField $minPrice;
    public FloatField $maxPrice;
    public FloatField $minSize;
    public FloatField $maxSize;
    public TextField $address;
    public ChoiceField $order;

    protected function build(): void
    {
        $sortKeys = array_keys(Listing::LISTING_SORTING);
        $this->id = $this->integerField()->minValue(1)->required(false);
        $this->minPrice = $this->floatField()->required(false);
        $this->maxPrice = $this->floatField()->required(false);
        $this->minSize = $this->floatField()->required(false);
        $this->maxSize = $this->floatField()->required(false);
        $this->address = $this->textField()->required(false);
        $this->order = $this->choiceField()->choices($sortKeys)->default(Listing::LISTING_SORTING['newest_first']);
    }
}