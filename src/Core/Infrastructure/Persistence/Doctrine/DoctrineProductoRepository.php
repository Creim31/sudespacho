<?php
// src/Core/Infrastructure/Persistence/Doctrine/DoctrineProductRepository.php
namespace App\Core\Infrastructure\Persistence\Doctrine;


use App\Core\Domain\Model\Product;
use App\Core\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator; 

class DoctrineProductoRepository implements ProductRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function searchByName(string $nombre, int $pagina, int $limite): array  // Cambiado nombre y parámetros
    {
        return $this->em->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')  // Cambiado de Product a Producto
            ->where('p.nombre LIKE :nombre')  // Cambiado de name a nombre
            ->setParameter('nombre', '%'.$nombre.'%')
            ->setFirstResult(($pagina - 1) * $limite)  // Cambiado de page a pagina
            ->setMaxResults($limite)  // Cambiado de limit a limite
            ->getQuery()
            ->getResult();
    }

     public function findById(int $id): ?Product  // Cambiado de findById a buscarPorId
    {
        return $this->em->getRepository(Product::class)->find($id);  // Cambiado de Product a Producto
    }

   public function findAllPaginated(int $pagina, int $limite): array
    {
        $queryBuilder = $this->em->createQueryBuilder();
        
        $query = $queryBuilder
            ->select('p')
            ->from(Product::class, 'p')
            ->orderBy('p.fechaCreacion', 'DESC')
            ->setFirstResult(($pagina - 1) * $limite)
            ->setMaxResults($limite)
            ->getQuery();

        $paginator = new Paginator($query);
        $resultados = [];
        
        foreach ($paginator as $producto) {
            $resultados[] = [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                // ... otros campos ...
            ];
        }

        return $resultados;
    }

        public function countAll(): int
    {
        return (int)$this->em->createQueryBuilder()
            ->select('COUNT(p.id)')
            ->from(Product::class, 'p')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // private function count(array $criteria): int
    // {
    //     $queryBuilder = $this->em->createQueryBuilder()
    //         ->select('COUNT(p.id)')
    //         ->from(Product::class, 'p');

    //     if (isset($criteria['nombre'])) {
    //         $queryBuilder->where('p.nombre LIKE :nombre')
    //             ->setParameter('nombre', $criteria['nombre']);
    //     }

    //     return (int)$queryBuilder->getQuery()->getSingleScalarResult();
    // }
}