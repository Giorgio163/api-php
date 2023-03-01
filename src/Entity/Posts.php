<?php

namespace Project4\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


#[ORM\Entity, ORM\Table(name: 'Posts')]
class Posts
{
    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'posts')]
    private Collection $category;

    #[ORM\Column(name: 'posted_at', type: 'datetimetz_immutable', nullable: false)]
    private DateTimeImmutable $posted_at;

    public function __construct(
        #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
        private UuidInterface $id,
        #[ORM\Column(type: 'string', nullable: false)]
        private string        $title,
        #[ORM\Column(type: 'string', nullable: false)]
        private string        $slug,
        #[ORM\Column(type: 'string', nullable: false)]
        private string        $content,
        #[ORM\Column(type: 'string', nullable: false)]
        private string        $thumbnail,
        #[ORM\Column(type: 'string', nullable: false)]
        private string        $author,
    )
    {
        $this->posted_at = new DateTimeImmutable('now');
        $this->category = new ArrayCollection();
    }

    /**
     * @throws Exception
     */
    public static function populate(array $data): self
    {
        return new self(
            Uuid::fromString($data['id']),
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['thumbnail'],
            $data['author'],
        );
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function thumbnail(): string
    {
        return $this->thumbnail;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function posted_at(): DateTimeImmutable
    {
        if (is_string($this->posted_at)) {
            return new DateTimeImmutable('now');
        }
        return $this->posted_at;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->category;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function toArray(): array
    {
        $categories = [];
        foreach ($this->getCategories() as $category) {
            $categories[] = $category->toArray();
        }

        return [
            'id' => $this->id(),
            'title' => $this->title(),
            'slug' => $this->slug(),
            'content' => $this->content(),
            'thumbnail' => $this->thumbnail(),
            'author' => $this->author(),
            'categories' => $categories
        ];
    }
}
