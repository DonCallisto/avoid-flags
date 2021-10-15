<?php

declare(strict_types=1);

namespace Domain\Article;

use Domain\User\User;
use JetBrains\PhpStorm\Pure;

class ReadyForReviewArticle implements ArticleInterface
{
    private User $author;

    private string $content;

    #[Pure] public function __construct(DraftArticle $draft)
    {
        $this->author = $draft->getAuthor();
        $this->content = $draft->getContent();
    }

    #[Pure] public function getAuthor(): User
    {
        return $this->author;
    }

    #[Pure] public function getContent(): string
    {
        return $this->content;
    }

    #[Pure] public function reviewed(User $reviewer): ReviewedArticle
    {
        return new ReviewedArticle($this, $reviewer);
    }
}