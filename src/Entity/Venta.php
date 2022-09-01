<?php

namespace App\Entity;

use App\Repository\VentaRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: VentaRepository::class)]
//#[UniqueEntity('Factura')]
class Venta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Factura = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $Fecha = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 2)]
    private ?string $Total = null;

    #[ORM\Column(length: 15)]
    private ?string $Estado = null;

    #[ORM\OneToMany(mappedBy: 'venta', targetEntity: DetalleVenta::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $detalles;

    #[ORM\ManyToOne(inversedBy: 'Ventas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cliente $cliente = null;

    #[ORM\ManyToOne(inversedBy: 'Ventas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\Column(length: 10)]
    private ?string $TipoFactura = null;

    public function __construct()
    {
        $this->detalles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactura(): ?string
    {
        return $this->Factura;
    }

    public function setFactura(string $Factura): self
    {
        $this->Factura = $Factura;

        return $this;
    }

    public function getFecha(): ?DateTimeInterface
    {
        return $this->Fecha;
    }

    public function setFecha(DateTimeInterface $Fecha): self
    {
        $this->Fecha = $Fecha;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->Total;
    }

    public function setTotal(string $Total): self
    {
        $this->Total = $Total;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->Estado;
    }

    public function setEstado(string $Estado): self
    {
        $this->Estado = $Estado;

        return $this;
    }

    /**
     * @return Collection<int, DetalleVenta>
     */
    public function getDetalles(): Collection
    {
        return $this->detalles;
    }

    public function addDetalle(DetalleVenta $detalle): self
    {
        if (!$this->detalles->contains($detalle)) {
            $this->detalles->add($detalle);
            $detalle->setVenta($this);
        }

        return $this;
    }

    public function removeDetalle(DetalleVenta $detalle): self
    {
        if ($this->detalles->removeElement($detalle)) {
            // set the owning side to null (unless already changed)
            if ($detalle->getVenta() === $this) {
                $detalle->setVenta(null);
            }
        }

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getTipoFactura(): ?string
    {
        return $this->TipoFactura;
    }

    public function setTipoFactura(string $TipoFactura): self
    {
        $this->TipoFactura = $TipoFactura;

        return $this;
    }
}
