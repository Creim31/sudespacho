<?php
namespace App\Infrastructure\Persistence;

use App\Core\Domain\Producto;
use App\Core\Ports\Persistence\ProductoRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class DoctrineProductoRepository implements ProductoRepositoryInterface
{
    private ObjectRepository $repository;
    
    public function __construct(private EntityManagerInterface $em) {
        $this->repository = $em->getRepository(Producto::class);
    }

    public function guardar(Producto $producto): void {
        $this->em->persist($producto);
        $this->em->flush();
    }

    public function buscarPorId(int $id): ?Producto {
        return $this->repository->find($id);
    }

    public function listarTodos(int $pagina = 1, int $porPagina = 10, ?string $filtro = null): array {
        $qb = $this->em->createQueryBuilder()
            ->select('p')
            ->from(Producto::class, 'p')
            ->setFirstResult(($pagina - 1) * $porPagina)
            ->setMaxResults($porPagina);

        if ($filtro) {
            $qb->where('p.nombre LIKE :filtro')
               ->setParameter('filtro', '%'.$filtro.'%');
        }

        return $qb->getQuery()->getResult();
    }

    public function contar(?string $filtro = null): int {
        $qb = $this->em->createQueryBuilder()
            ->select('COUNT(p.id)')
            ->from(Producto::class, 'p');

        if ($filtro) {
            $qb->where('p.nombre LIKE :filtro')
               ->setParameter('filtro', '%'.$filtro.'%');
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}