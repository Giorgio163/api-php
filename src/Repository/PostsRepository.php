<?php

namespace Project4\Repository;

use Project4\Entity\Posts;
use Ramsey\Uuid\UuidInterface;

interface PostsRepository
{
//    public function storePost(Posts $post): void;
    public function store(Posts $posts): void;
    /**
     * 
     *
     * @return Posts[] 
     */
    public function findAll(): array;
    public function find(UuidInterface $id): Posts;
    public function delete(UuidInterface $id): string;
    public function update(UuidInterface $id, array $data): void;
    public function findBySlug($slug): array;
}
