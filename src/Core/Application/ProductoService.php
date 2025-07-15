<?php
namespace App\Core\Application;

use App\Core\Domain\Producto;
use App\Core\Ports\Persistence\ProductoRepositoryInterface;

class ProductoService
{
    public function __construct(
        private ProductoRepositoryInterface $productoRepository
    ) {}

    public function crearProducto(
        string $nombre,
        string $descripcion,
        float $precioSinIva,
        string $tipoIva
    ): Producto {
        $producto = new Producto($nombre, $descripcion, $precioSinIva, $tipoIva);
        $this->productoRepository->guardar($producto);
        return $producto;
    }

    public function listarProductos(
        int $pagina = 1,
        int $porPagina = 10,
        ?string $filtro = null
    ): array {
        return [
            'data' => $this->productoRepository->listarTodos($pagina, $porPagina, $filtro),
            'total' => $this->productoRepository->contar($filtro),
            'pagina' => $pagina,
            'porPagina' => $porPagina
        ];
    }
}