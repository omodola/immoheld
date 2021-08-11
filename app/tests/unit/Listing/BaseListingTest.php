<?php
namespace UnitTests\Listing;
use App\Repositories\ListingRepository;
use Faker\Factory;
use Models\Dtos\Listings\ListingDto;
use Models\Entities\Listing;
use PHPUnit\Framework\TestCase;

class BaseListingTest extends TestCase
{

    protected $listRepository;
    protected Listing $listing;
    protected ListingDto $listingDto;
    protected \Faker\Generator $faker;
    
    public function setUp(): void
    {
        $this->listing = new Listing();
        $this->faker = Factory::create();

        $this->listRepository = ($this->createMock(ListingRepository::class));
        $this->listRepository->method('get')->willReturn([$this->listing]);
        $this->listRepository->method('getById')->willReturn($this->listing);
        $this->listRepository->method('save')->willReturn($this->listing);
        $this->listRepository->method('edit')->willReturn($this->listing);
        $this->listRepository->method('delete');

        $this->listingDto = new ListingDto();
//        $this->listingDto = ($this->createMock(ListingDto::class));
//        $this->listingDto->method('getListingsDto');

    }
    
    public function testAssert()
    {
        self::assertEmpty([]);
    }
}