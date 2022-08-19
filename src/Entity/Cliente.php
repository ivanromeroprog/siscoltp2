<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 9)]
    private ?string $Dni = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $Apellido = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Telefono = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Direccion = null;

    #[ORM\OneToMany(mappedBy: 'cliente', targetEntity: Venta::class)]
    private ?Collection $Ventas;

    /**
     * Cliente constructor.
     * @param int|null $id
     * @param string|null $Dni
     * @param string|null $Nombre
     * @param string|null $Apellido
     * @param string|null $Telefono
     * @param string|null $Direccion
     * @param Collection $Ventas
     */
    public function __construct(?string $Dni = null, ?string $Nombre = null, ?string $Apellido = null, ?string $Telefono = null, ?string $Direccion = null, ?int $id = null, Collection $Ventas = null)
    {
        $this->id = $id;
        $this->Dni = $Dni;
        $this->Nombre = $Nombre;
        $this->Apellido = $Apellido;
        $this->Telefono = $Telefono;
        $this->Direccion = $Direccion;
        $this->Ventas = $Ventas;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->Dni;
    }

    public function setDni(string $Dni): self
    {
        $this->Dni = $Dni;

        return $this;
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

    public function getApellido(): ?string
    {
        return $this->Apellido;
    }

    public function setApellido(string $Apellido): self
    {
        $this->Apellido = $Apellido;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->Telefono;
    }

    public function setTelefono(?string $Telefono): self
    {
        $this->Telefono = $Telefono;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->Direccion;
    }

    public function setDireccion(?string $Direccion): self
    {
        $this->Direccion = $Direccion;

        return $this;
    }

    /**
     * @return Collection<int, Venta>
     */
    public function getVentas(): Collection
    {
        return $this->Ventas;
    }

    public function addVenta(Venta $venta): self
    {
        if (!$this->Ventas->contains($venta)) {
            $this->Ventas->add($venta);
            $venta->setCliente($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): self
    {
        if ($this->Ventas->removeElement($venta)) {
            // set the owning side to null (unless already changed)
            if ($venta->getCliente() === $this) {
                $venta->setCliente(null);
            }
        }

        return $this;
    }
}
