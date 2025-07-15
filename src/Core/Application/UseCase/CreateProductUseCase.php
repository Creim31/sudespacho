<?php
// src/Core/Application/UseCase/Product/CreateProductUseCase.php
namespace App\Core\Application\UseCase\Product;

use App\Core\Domain\Model\Product;
use App\Core\Domain\Repository\ProductRepositoryInterface;

class CreateProductUseCase
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(
        string $nombre,
        string $descripcion,
        float $precioSinIva,
        int $tipoIva
    ): Product {
        $product = new Product($nombre, $descripcion, $precioSinIva, $tipoIva);
        $this->repository->save($product);
        
        return $product;
    }
}