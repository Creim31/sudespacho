<?php

// src/Core/Domain/Model/Product.php
namespace App\Core\Domain\Model;

class Product
{
    private ?int $id;
    private string $name;
    private string $description;
    private float $priceWithoutVat;
    private float $priceWithVat;
    private int $vatType; // 4, 10 o 21

    public function __construct(
        string $name, 
        string $description, 
        float $priceWithoutVat, 
        int $vatType
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->priceWithoutVat = $priceWithoutVat;
        $this->vatType = $vatType;
        $this->calculateVat();
    }

    private function calculateVat(): void
    {
        $vatMultiplier = 1 + ($this->vatType / 100);
        $this->priceWithVat = $this->priceWithoutVat * $vatMultiplier;
    }

    // Getters...
}