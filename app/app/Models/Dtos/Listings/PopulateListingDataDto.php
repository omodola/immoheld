<?php

namespace Models\Dtos\Listings;

use Casper\Fields\CharField;
use Casper\Fields\ChoiceField;
use Casper\Fields\FloatField;
use Casper\Fields\IntegerField;
use Casper\Fields\TextField;
use Faker\Factory;
use Models\Dtos\BaseDto;
use Models\Entities\Listing;

class PopulateListingDataDto extends BaseDto
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

        $faker = Factory::create();
        $imageList = ['https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/637181/610bc019ac942573767474.jpg',
                        'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/636850/60f6e68192c19486975392.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/636736/60ed98bf6dc55861882758.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/637219/610d429c2c372931090075.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/637201/610d1e11635ab066208995.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/637017/610a877e6ac60174835493.jpg',
            'https://cdn.asunnot.oikotie.fi/s7RTXdqciUUmUR-wgpRsfKUiNPw=/full-fit-in/616x386/filters:background_color(white):format(webp):quality(60)/ot-real-estate-mediabank-prod/322/902/source/194209223',
            'https://cdn.asunnot.oikotie.fi/f1J4XUEbo8Yc4eN-IUtE8fo3IgY=/full-fit-in/616x386/filters:background_color(white):format(webp):quality(60)/ot-real-estate-mediabank-prod/549/298/source/197892945',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/637118/610b88584b67e607918775.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/637108/6107f220a8180607034740.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/635624/6108fcc40879a019081669.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/637085/610a2326a762a901869270.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/637084/6106364574daf382709364.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/636789/60fe91e738556434107246.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/636856/6101809a77cc7733297498.jpg',
            'https://s3-eu-west-1.amazonaws.com/wwwimages-habita-com/propertyList/637038/6101c944d891e303160204.jpeg',];
        $this->url = $this->textField()->default($faker->randomElement($imageList));
        $this->address = $this->textField()
            ->default(sprintf("%s, %s", $faker->city, $faker->country));

        $this->rooms = $this->integerField()
            ->minValue(0)
            ->default($faker->numberBetween(1,9));

        $this->size =  $this->floatField()
            ->minValue(0)
            ->default($faker->randomFloat(2,12, 1200));

        $this->price = $this->floatField()
            ->minValue(0)
            ->default($faker->randomFloat(0,48000, 9000000));

        $this->type = $this->choiceField()
            ->choices(Listing::LISTING_TYPES)
            ->default($faker->randomElement(Listing::LISTING_TYPES));

        $this->year = $this->charField()
            ->maxLength(4)
            ->minLength(4)
            ->default($faker->year);
    }
}