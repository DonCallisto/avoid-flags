<?php

declare(strict_types=1);

namespace Domain\Article;

use Domain\User\User;

interface ArticleInterface
{
    public function getContent(): string;

    public function getAuthor(): User;
}