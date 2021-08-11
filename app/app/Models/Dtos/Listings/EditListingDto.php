<?php

namespace Models\Dtos\Listings;

use Casper\Fields\CharField;
use Casper\Fields\ChoiceField;
use Casper\Fields\FloatField;
use Casper\Fields\IntegerField;
use Casper\Fields\TextField;
use Models\Dtos\BaseDto;
use Models\Entities\Listing;

class EditListingDto extends BaseDto
{
    public IntegerField $id;
    public TextField $url;
    public TextField $address;
    public IntegerField $rooms;
    public FloatField $size;
    public FloatField $price;
    public ChoiceField $type;
    public CharField $year;

    protected function build(): void
    {
        $this->id = $this->integerField()->minValue(1);
        $this->url = $this->textField()->required(false);
        $this->address = $this->textField()->required(false);
        $this->rooms = $this->integerField()->minValue(0)->required(false);
        $this->size =  $this->floatField()->minValue(0)->required(false);
        $this->price = $this->floatField()->minValue(0)->required(false);
        $this->type = $this->choiceField()->choices(Listing::LISTING_TYPES)->required(false);
        $this->year = $this->charField()->maxLength(4)->minLength(4)->required(false);
    }

}