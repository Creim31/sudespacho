<?php

// src/Core/Domain/Model/Product.php
namespace App\Core\Domain\Model;

class Product
{
    private ?int $id;
    private string $nombre;
    private string $descripcion;
    private float $precioSinIva;
    private float $precioConIva;
    private int $tipoIva; // 4, 10 o 21

    public function __construct(
        string $nombre, 
        string $descripcion, 
        float $precioSinIva, 
        int $tipoIva
    ) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precioSinIva = $precioSinIva;
        $this->tipoIva = $tipoIva;
        $this->calcularIva();
    }

   private function calcularIva(): void
    {
        $multiplicadorIva = 1 + ($this->tipoIva / 100);
        $this->precioConIva = $this->precioSinIva * $multiplicadorIva;
    }

    // Getters en español
    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getPrecioConIva(): float {
        return $this->precioConIva;
    }

    // Getters...
}