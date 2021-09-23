<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    const NAME_CAT0 = 'Gastronomique';
    const NAME_CAT1 = 'Bio';
    const NAME_CAT2 = 'Moderne';
    const NAME_CAT3 = "D'ailleurs";
    const NAME_CAT4 = 'Brasserie';
    const NAME_CAT5 = 'Crêperie';
    const NAME_CAT6 = 'Provencal';
    const NAME_CAT7 = 'Vegan';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="category")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public static function getNameList() {

        return [
            self:: NAME_CAT0 => 'Gastronomique',
            self:: NAME_CAT1 => 'Bio',
            self:: NAME_CAT2 => 'Moderne',
            self:: NAME_CAT3 => "D'ailleurs",
            self:: NAME_CAT4 => 'Brasserie',
            self:: NAME_CAT5 => 'Crêperie',
            self:: NAME_CAT6 => 'Provencal',
            self:: NAME_CAT7 => 'Vegan',
        ];
    }

    public function getNameLabel() {
        $list = self::getNameList();
        return ($this->name) ? $list[$this->name] : null;
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

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }
}
