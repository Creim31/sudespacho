<?php
// src/Core/Domain/Model/Product.php
namespace App\Core\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

// #[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Entity]
#[ORM\Table(name: 'productos')]  // Nombre exacto de tu tabla
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'nombre', type: 'string', length: 255)]
    private string $nombre;

    #[ORM\Column(name: 'descripcion', type: 'text')]
    private string $descripcion;

    #[ORM\Column(name: 'precio_sin_iva', type: 'float')]
    private float $precioSinIva;

    #[ORM\Column(name: 'precio_con_iva', type: 'float')]
    private float $precioConIva;

    #[ORM\Column(name: 'tipo_iva', type: 'integer')]
    private int $tipoIva; // 4, 10 o 21

    #[ORM\Column(name: 'fecha_creacion', type: 'datetime_immutable')]
    private DateTimeImmutable $fechaCreacion;

    #[ORM\Column(name: 'fecha_actualizacion', type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $fechaActualizacion = null;

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
        $this->fechaCreacion = new DateTimeImmutable();
        $this->calcularIva();
    }

    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $this->fechaActualizacion = new DateTimeImmutable();
    }

    private function calcularIva(): void
    {
        $multiplicadorIva = 1 + ($this->tipoIva / 100);
        $this->precioConIva = $this->precioSinIva * $multiplicadorIva;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function getPrecioSinIva(): float {
        return $this->precioSinIva;
    }

    public function getPrecioConIva(): float {
        return $this->precioConIva;
    }

    public function getTipoIva(): int {
        return $this->tipoIva;
    }

    public function getFechaCreacion(): DateTimeImmutable {
        return $this->fechaCreacion;
    }

    public function getFechaActualizacion(): ?DateTimeImmutable {
        return $this->fechaActualizacion;
    }
}