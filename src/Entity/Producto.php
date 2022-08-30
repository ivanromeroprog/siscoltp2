<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Descripcion = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2)]
    private ?string $Precio = null;

    #[ORM\OneToMany(mappedBy: 'producto', targetEntity: DetalleVenta::class)]
    
    private Collection $DetallesVentas;

    #[ORM\Column]
    private ?int $Stock = null;

    public function __construct(?int $id=null, ?string $Nombre=null, ?string $Descripcion=null, ?string $Precio=null, ?int $Stock=null) {
        $this->id = $id;
        $this->Nombre = $Nombre;
        $this->Descripcion = $Descripcion;
        $this->Precio = $Precio;
        $this->Stock = $Stock;
        $this->DetallesVentas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    public function setDescripcion(?string $Descripcion): self
    {
        $this->Descripcion = $Descripcion;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->Precio;
    }

    public function setPrecio(string $Precio): self
    {
        $this->Precio = $Precio;

        return $this;
    }

    /**
     * @return Collection<int, DetalleVenta>
     */
    public function getDetallesVentas(): Collection
    {
        return $this->DetallesVentas;
    }

    public function addDetallesVenta(DetalleVenta $detallesVenta): self
    {
        if (!$this->DetallesVentas->contains($detallesVenta)) {
            $this->DetallesVentas->add($detallesVenta);
            $detallesVenta->setProducto($this);
        }

        return $this;
    }

    public function removeDetallesVenta(DetalleVenta $detallesVenta): self
    {
        if ($this->DetallesVentas->removeElement($detallesVenta)) {
            // set the owning side to null (unless already changed)
            if ($detallesVenta->getProducto() === $this) {
                $detallesVenta->setProducto(null);
            }
        }

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(int $Stock): self
    {
        $this->Stock = $Stock;

        return $this;
    }

    
    public function __toString() {
        return $this->Nombre . ' - $' . $this->Precio ;
    }
}
