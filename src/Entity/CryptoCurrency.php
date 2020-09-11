<?php

namespace App\Entity;

use App\Repository\CryptoCurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CryptoCurrencyRepository::class)
 */
class CryptoCurrency
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cryptoName;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $marketData = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $marketPrice = [];

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cryptoTag;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCryptoName(): ?string
    {
        return $this->cryptoName;
    }

    public function setCryptoName(string $cryptoName): self
    {
        $this->cryptoName = $cryptoName;

        return $this;
    }

    public function getMarketData(): ?string
    {
        return $this->marketData;
    }

    public function setMarketData(?string $marketData): self
    {
        $this->marketData = $marketData;

        return $this;
    }

    public function getMarketPrice(): ?string
    {
        return $this->marketPrice;
    }

    public function setMarketPrice(?string $marketPrice): self
    {
        $this->marketPrice = $marketPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getCryptoTag(): ?string
    {
        return $this->cryptoTag;
    }

    public function setCryptoTag(?string $cryptoTag): self
    {
        $this->cryptoTag = $cryptoTag;

        return $this;
    }
}
