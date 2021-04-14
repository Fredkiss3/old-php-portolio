<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @UniqueEntity(fields={"title"})
 * @Vich\Uploadable()
 */
class Project
{
    const TYPE_PERSONAL = 'PERSONAL';
    const TYPE_CLIENT = 'CLIENT';
    const TYPE_INTERNSHIP = 'INTERNSHIP';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string|null
     */
    private $cover;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string|null
     */
    private $type = self::TYPE_INTERNSHIP;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $yearOfRealization;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string|null
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image4;

    /**
     * @ORM\ManyToMany(targetEntity=Technology::class)
     *
     * @var Collection|Technology[]
     */
    private $technologies;

    /**
     * @Vich\UploadableField(mapping="project_images", fileNameProperty="cover")
     *
     * @var File|null
     */
    private $coverFile;

    /**
     * @Vich\UploadableField(mapping="project_images", fileNameProperty="image2")
     *
     * @var File|null
     */
    private $image2File;

    /**
     * @Vich\UploadableField(mapping="project_images", fileNameProperty="image3")
     *
     * @var File|null
     */
    private $image3File;

    /**
     * @Vich\UploadableField(mapping="project_images", fileNameProperty="image4")
     *
     * @var File|null
     */
    private $image4File;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     *
     * @var string
     */
    private $excerpt;

    public function __construct()
    {
        $this->technologies = new ArrayCollection();
    }

    public function getCoverFile(): ?File
    {
        return $this->coverFile;
    }

    public function setCoverFile(?File $coverFile): void
    {
        if ($coverFile) {
            $this->updatedAt = new \DateTime();
        }

        $this->coverFile = $coverFile;
    }

    public function setImage2File(?File $image2File): void
    {
        if ($image2File) {
            $this->updatedAt = new \DateTime();
        }

        $this->image2File = $image2File;
    }

    public function setImage3File(?File $image3File): void
    {
        if ($image3File) {
            $this->updatedAt = new \DateTime();
        }

        $this->image3File = $image3File;
    }

    public function getImage2File(): ?File
    {
        return $this->image2File;
    }

    public function getImage3File(): ?File
    {
        return $this->image3File;
    }

    public function getImage4File(): ?File
    {
        return $this->image4File;
    }

    public function setImage4File(?File $image4File): void
    {
        if ($image4File) {
            $this->updatedAt = new \DateTime();
        }

        $this->image4File = $image4File;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (in_array($type, [self::TYPE_PERSONAL, self::TYPE_CLIENT, self::TYPE_INTERNSHIP])) {
            $this->type = $type;
        }

        return $this;
    }

    public function getYearOfRealization(): ?int
    {
        return $this->yearOfRealization;
    }

    public function setYearOfRealization(int $yearOfRealization): self
    {
        $this->yearOfRealization = $yearOfRealization;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(?string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(?string $image3): self
    {
        $this->image3 = $image3;

        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image4;
    }

    public function setImage4(?string $image4): self
    {
        $this->image4 = $image4;

        return $this;
    }

    /**
     * @return Collection|Technology[]
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        $this->technologies->removeElement($technology);

        return $this;
    }

    public function getSlug(): ?string
    {
        return strtolower((new AsciiSlugger())->slug($this->title));
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
