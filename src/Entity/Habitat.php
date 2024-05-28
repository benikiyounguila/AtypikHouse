<?php

namespace App\Entity;

use App\Repository\HabitatRepository;
use App\Validator\BanWord;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



#[ORM\Entity(repositoryClass: HabitatRepository::class)]
#[UniqueEntity('title')]
#[UniqueEntity('slug')]
#[Vich\Uploadable()]
class Habitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5)]
    #[BanWord]
    private string $title = '';

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    #[Assert\Positive()]
    private string $capacity = '';

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Positive()]
    private ?int $nombreDeCouchage = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    #[Assert\Positive()]
    #[Assert\LessThan(value: 2000)]
    private string $price = '';

    #[ORM\Column]
    private ?bool $en_vente = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(min: 5)]
    private string $content = '';

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 5)]
    #[Assert\Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', message: "Le slug ne peut contenir que des lettres minuscules, des chiffres et des tirets")]
    private string $slug = '';

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $file = null;

    #[Vich\UploadableField(mapping: 'habitats', fileNameProperty: 'file' )]
    #[Assert\Image()]
    private ?File $thumbnailFile = null;


    #[ORM\ManyToOne(inversedBy: 'habitats', cascade: ['persist'])]
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $titre): static
    {
        $this->title = $titre;

        return $this;
    }

    public function getCapacity(): string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getNombreDeCouchage(): int
    {
        return $this->nombreDeCouchage;
    }

    public function setNombreDeCouchage(int $nombreDeCouchage): static
    {
        $this->nombreDeCouchage = $nombreDeCouchage;

        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isEnVente(): ?bool
    {
        return $this->en_vente;
    }

    public function setEnVente(bool $en_vente): static
    {
        $this->en_vente = $en_vente;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): static
    {
        $this->file = $file;

        return $this;
    }

    
    public function getThumbnailFile(): ?File
    {
        return $this->thumbnailFile;
    }

    public function setThumbnailFile(?File $thumbnailFile): static
    {
        $this->thumbnailFile = $thumbnailFile;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    // public function getAddress(): ?Address
    // {
    //     return $this->address;
    // }

    // public function setAddress(?Address $address): static
    // {
    //     $this->address = $address;

    //     return $this;
    // }
}
