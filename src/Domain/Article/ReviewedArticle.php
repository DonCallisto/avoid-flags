<?php

declare(strict_types=1);

namespace Domain\Article;

use Domain\User\User;
use JetBrains\PhpStorm\Pure;

class ReviewedArticle implements ArticleInterface
{
    private User $author;

    private string $content;

    #[Pure] public function __construct(ReadyForReviewArticle $readyForReview, private User $reviewer)
    {
        $this->author = $readyForReview->getAuthor();
        $this->content = $readyForReview->getContent();
    }

    #[Pure] public function getAuthor(): User
    {
        return $this->author;
    }

    #[Pure] public function getReviewer(): User
    {
        return $this->reviewer;
    }

    #[Pure] public function getContent(): string
    {
        return $this->content;
    }

    public function publish(\DateTimeInterface $publicationDate): PublishedArticle
    {
        return new PublishedArticle($this, $publicationDate);
    }
}