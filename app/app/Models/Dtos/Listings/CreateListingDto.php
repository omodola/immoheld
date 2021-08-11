<?php

namespace Models\Dtos\Listings;

use Casper\Fields\CharField;
use Casper\Fields\ChoiceField;
use Casper\Fields\FloatField;
use Casper\Fields\IntegerField;
use Casper\Fields\TextField;
use Models\Dtos\BaseDto;
use Models\Entities\Listing;

class CreateListingDto extends BaseDto
{
    public TextField $url;
    public TextField $address;
    public IntegerField $rooms;
    public FloatField $size;
    public FloatField $price;
    public ChoiceField $type;
    public CharField $year;

    protected function build(): void
    {
        $this->url = $this->textField();
        $this->address = $this->textField();
        $this->rooms = $this->integerField()->minValue(0);
        $this->size =  $this->floatField()->minValue(0);
        $this->price = $this->floatField()->minValue(0);
        $this->type = $this->choiceField()->choices(Listing::LISTING_TYPES)->default(Listing::LISTING_TYPES['apartment']);
        $this->year = $this->charField()->maxLength(4)->minLength(4);
    }

}