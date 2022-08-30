<?php

namespace App\Entity;

use App\Repository\DetalleVentaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetalleVentaRepository::class)]
class DetalleVenta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Cantidad = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2)]
    private ?string $CostoUnitario = null;

    #[ORM\ManyToOne(inversedBy: 'detalles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Venta $venta = null;

    #[ORM\ManyToOne(inversedBy: 'DetallesVentas')]
    #[ORM\JoinColumn(nullable: false)]
    //#[ORM\OrderBy({"name" = "ASC"})]
    private ?Producto $producto = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __construct(?int $id = null, ?int $Cantidad = null, ?string $CostoUnitario = null, ?Venta $venta = null, ?Producto $producto = null) {
        $this->id = $id;
        $this->Cantidad = $Cantidad;
        $this->CostoUnitario = $CostoUnitario;
        $this->venta = $venta;
        $this->producto = $producto;
    }

    public function getCantidad(): ?int
    {
        return $this->Cantidad;
    }

    public function setCantidad(int $Cantidad): self
    {
        $this->Cantidad = $Cantidad;

        return $this;
    }

    public function getCostoUnitario(): ?string
    {
        return $this->CostoUnitario;
    }

    public function setCostoUnitario(string $CostoUnitario): self
    {
        $this->CostoUnitario = $CostoUnitario;

        return $this;
    }

    public function getVenta(): ?Venta
    {
        return $this->venta;
    }

    public function setVenta(?Venta $venta): self
    {
        $this->venta = $venta;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }
}
