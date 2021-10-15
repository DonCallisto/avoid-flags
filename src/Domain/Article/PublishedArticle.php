<?php

declare(strict_types=1);

namespace Domain\Article;

use Domain\User\User;
use JetBrains\PhpStorm\Pure;

class PublishedArticle implements ArticleInterface
{
    private User $author;

    private string $content;

    private \DateTimeImmutable $publicationDate;

    public function __construct(ReviewedArticle $reviewed, \DateTimeInterface $publicationDate)
    {
        $this->author = $reviewed->getAuthor();
        $this->content = $reviewed->getContent();
        $this->publicationDate = \DateTimeImmutable::createFromInterface($publicationDate);
    }

    #[Pure] public function getAuthor(): User
    {
        return $this->author;
    }

    #[Pure] public function getContent(): string
    {
        return $this->content;
    }

    #[Pure] public function getPublicationDate(): \DateTimeImmutable
    {
        return $this->publicationDate;
    }
}