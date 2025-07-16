<?php
namespace App\Core\Application\UseCase;


use App\Core\Domain\Model\Product;
use App\Core\Domain\Repository\ProductRepositoryInterface;

class ListarProductosUseCase
{

    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function executeList(int $pagina = 1, int $limite = 10): array
    {
        // Validación de parámetros
        $pagina = max(1, $pagina);
        $limite = min(max(1, $limite), 100); // Límite entre 1 y 100

        $productos = $this->repository->findAllPaginated($pagina, $limite);
        $total = $this->repository->countAll();
      

        return [
            'datos' => $productos,
            'paginacion' => [
                'total_elementos' => $total,
                'pagina_actual' => $pagina,
                'elementos_por_pagina' => $limite,
                'total_paginas' => ceil($total / $limite)
            ]
        ];
    }

  }   