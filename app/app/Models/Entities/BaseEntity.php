<?php

namespace Models\Entities;

use JsonSerializable;

class BaseEntity implements JsonSerializable
{
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;
    protected ?string $deletedAt = null;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     * @return BaseEntity
     */
    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = empty($createdAt) ? $createdAt : gmdate('c', strtotime($createdAt));
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     * @return BaseEntity
     */
    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = empty($updatedAt) ? $updatedAt : gmdate('c', strtotime($updatedAt));
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    /**
     * @param string|null $deletedAt
     * @return BaseEntity
     */
    public function setDeletedAt(?string $deletedAt): self
    {
        $this->deletedAt = empty($deletedAt) ? $deletedAt : gmdate('c', strtotime($deletedAt));
        return $this;
    }


    /**
     * @param array $data
     * @return $this
     */
    public function setAttributes(array $data): self
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $prop = 'set'.ucfirst($key);
                if(method_exists($this, $prop)){
                    $this->$prop($value);
                }
            }
        }
        return $this;
    }

    /**
     * @return null[]|string[]
     */
    public function toArray(): array
    {
        return [
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'deleted_at' => $this->getDeletedAt()
        ];
    }

    /**
     * @return null[]|string[]
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}