<?php
// src/Core/Infrastructure/Persistence/Doctrine/DoctrineProductRepository.php
namespace App\Core\Infrastructure\Persistence\Doctrine;


use App\Core\Domain\Model\Product;
use App\Core\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

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

    // Implementa otros métodos...
}