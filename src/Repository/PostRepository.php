<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Post;

interface PostRepository
{
    public function find(int $id): ?Post;
}