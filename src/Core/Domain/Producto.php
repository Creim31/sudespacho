<?php
namespace App\Core\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'productos')]
#[ORM\HasLifecycleCallbacks]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nombre;

    #[ORM\Column(type: 'text')]
    private string $descripcion;

    #[ORM\Column(type: 'float', name: 'precio_sin_iva')]
    private float $precioSinIva;

    #[ORM\Column(type: 'float', name: 'precio_con_iva')]
    private float $precioConIva;

    #[ORM\Column(type: 'string', length: 2, name: 'tipo_iva')]
    private string $tipoIva; // '4', '10' o '21'

    #[ORM\Column(type: 'datetime_immutable', name: 'fecha_creacion')]
    private \DateTimeImmutable $fechaCreacion;

    #[ORM\Column(type: 'datetime_immutable', name: 'fecha_actualizacion')]
    private \DateTimeImmutable $fechaActualizacion;

    public function __construct(
        string $nombre,
        string $descripcion,
        float $precioSinIva,
        string $tipoIva
    ) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precioSinIva = $precioSinIva;
        $this->setTipoIva($tipoIva);
        $this->calcularIva();
        $this->fechaCreacion = new \DateTimeImmutable();
        $this->fechaActualizacion = new \DateTimeImmutable();
    }
    
    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $this->fechaActualizacion = new \DateTimeImmutable();
    }

    private function setTipoIva(string $tipoIva): void
    {
        if (!in_array($tipoIva, ['4', '10', '21'])) {
            throw new \InvalidArgumentException('Tipo de IVA no válido. Debe ser 4, 10 o 21.');
        }
        $this->tipoIva = $tipoIva;
    }

    private function calcularIva(): void
    {
        $tasaIva = (float) $this->tipoIva / 100;
        $this->precioConIva = $this->precioSinIva * (1 + $tasaIva);
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getPrecioConIva(): float
    {
        return $this->precioConIva;
    }

}