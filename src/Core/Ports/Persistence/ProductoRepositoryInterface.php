<?php
namespace App\Core\Ports\Persistence;

use App\Core\Domain\Producto;

interface ProductoRepositoryInterface
{
    public function guardar(Producto $producto): void;
    public function buscarPorId(int $id): ?Producto;
    public function listarTodos(int $pagina = 1, int $porPagina = 10, ?string $filtro = null): array;
    public function contar(?string $filtro = null): int;
}