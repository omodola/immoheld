<?php
namespace Models\Entities;

class Listing extends BaseEntity
{
    public const LISTING_TYPES = [
        'apartment' => 'apartment',
        'bungalow' => 'bungalow',
        'cabin' => 'cabin',
        'castle' => 'castle',
        'condo' => 'condo',
        'cottage' => 'cottage',
        'duplex' => 'duplex',
        'mansion' => 'mansion',
        'villa' => 'villa',
    ];

    public const LISTING_SORTING = [
        'cheapest_first' => [
            'orderBy' => 'price',
            'order' => 'asc'
        ],
        'expensive_first' => [
            'orderBy' => 'price',
            'order' => 'desc'
        ],
        'newest_first' => [
            'orderBy' => 'id',
            'order' => 'desc'
        ],
        'oldest_first' => [
            'orderBy' => 'id',
            'order' => 'asc'
        ],
    ];

    private ?int $id = null;
    private ?string $address = null;
    private ?float $price = null;
    private ?int $rooms = null;
    private ?float $size = null;
    private ?string $year = null;
    private ?string $url = null;
    private ?string $type = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Listing
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return Listing
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return Listing
     */
    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    /**
     * @param int|null $rooms
     * @return Listing
     */
    public function setRooms(?int $rooms): self
    {
        $this->rooms = $rooms;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getSize(): ?float
    {
        return $this->size;
    }

    /**
     * @param float|null $size
     * @return Listing
     */
    public function setSize(?float $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * @param string|null $year
     * @return Listing
     */
    public function setYear(?string $year): self
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return Listing
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Listing
     */
    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function toArray(): array
    {
        return array_merge([
            'id' => $this->getId(),
            'price' => $this->getPrice(),
            'address' => $this->getAddress(),
            'rooms' => $this->getRooms(),
            'url' => $this->getUrl(),
            'size' => $this->getSize(),
            'year' => $this->getYear(),
            'type' => $this->getType()
        ],parent::toArray()
        );
    }
}