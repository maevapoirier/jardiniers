<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $postCode = null;

    #[ORM\Column(nullable:true)]
    private ?float $latitude = null;

    #[ORM\Column(nullable:true)]
    private ?float $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Department $department = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Localization::class)]
    private Collection $localizations;

    public function __construct()
    {
        $this->localizations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPostCode(): ?int
    {
        return $this->postCode;
    }

    public function setPostCode(int $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection<int, Localization>
     */
    public function getLocalizations(): Collection
    {
        return $this->localizations;
    }

    public function addLocalization(Localization $localization): self
    {
        if (!$this->localizations->contains($localization)) {
            $this->localizations->add($localization);
            $localization->setCity($this);
        }

        return $this;
    }

    public function removeLocalization(Localization $localization): self
    {
        if ($this->localizations->removeElement($localization)) {
            // set the owning side to null (unless already changed)
            if ($localization->getCity() === $this) {
                $localization->setCity(null);
            }
        }

        return $this;
    }
}
