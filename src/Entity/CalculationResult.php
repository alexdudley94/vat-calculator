<?php

namespace App\Entity;

use App\Repository\CalculationResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CalculationResultRepository::class)
 */
class CalculationResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $originalValue;

    /**
     * @ORM\Column(type="float")
     */
    private $vatPercentage;

    /**
     * @ORM\Column(type="float")
     */
    private $valueIncVat;

    /**
     * @ORM\Column(type="float")
     */
    private $valueExclVat;

    /**
     * @ORM\Column(type="float")
     */
    private $amountOfVatAdded;

    /**
     * @ORM\Column(type="float")
     */
    private $amountOfVatExcluded;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalValue(): ?float
    {
        return $this->originalValue;
    }

    public function setOriginalValue(float $originalValue): self
    {
        $this->originalValue = $originalValue;

        return $this;
    }

    public function getVatPercentage(): ?float
    {
        return $this->vatPercentage;
    }

    public function setVatPercentage(float $vatPercentage): self
    {
        $this->vatPercentage = $vatPercentage;

        return $this;
    }

    public function getValueIncVat(): ?float
    {
        return $this->valueIncVat;
    }

    public function setValueIncVat(float $valueIncVat): self
    {
        $this->valueIncVat = $valueIncVat;

        return $this;
    }

    public function getValueExclVat(): ?float
    {
        return $this->valueExclVat;
    }

    public function setValueExclVat(float $valueExclVat): self
    {
        $this->valueExclVat = $valueExclVat;

        return $this;
    }

    public function getAmountOfVatAdded(): ?float
    {
        return $this->amountOfVatAdded;
    }

    public function setAmountOfVatAdded(float $amountOfVatAdded): self
    {
        $this->amountOfVatAdded = $amountOfVatAdded;

        return $this;
    }

    public function getAmountOfVatExcluded(): ?float
    {
        return $this->amountOfVatExcluded;
    }

    public function setAmountOfVatExcluded(float $amountOfVatExcluded): self
    {
        $this->amountOfVatExcluded = $amountOfVatExcluded;

        return $this;
    }
}
