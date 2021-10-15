<?php

declare(strict_types=1);

namespace Domain\Article;

use Domain\User\User;
use JetBrains\PhpStorm\Pure;

class DraftArticle implements ArticleInterface
{
    public function __construct(private User $author, private string $content)
    {

    }

    #[Pure] public function getAuthor(): User
    {
        return $this->author;
    }

    #[Pure] public function getContent(): string
    {
        return $this->content;
    }

    public function changeContentTo(string $newContent): void
    {
        $this->content = $newContent;
    }

    #[Pure] public function readyForReview(): ReadyForReviewArticle
    {
        return new ReadyForReviewArticle($this);
    }
}