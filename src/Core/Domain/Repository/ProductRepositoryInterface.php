<?php
// src/Core/Domain/Repository/ProductRepositoryInterface.php
namespace App\Core\Domain\Repository;

use App\Core\Domain\Model\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;
    public function searchByName(string $name, int $page, int $limit): array;
    public function findById(int $id): ?Product; 
}