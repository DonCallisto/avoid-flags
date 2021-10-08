<?php

declare(strict_types=1);

namespace Domain\Article;

use JetBrains\PhpStorm\Pure;

class Article
{
    private Status $status;

    public function __construct()
    {
        $this->status = Status::DRAFT;
    }

    #[Pure] public function isInDraft(): bool
    {
        return $this->status->isDraft();
    }

    public function readyForReview(): void
    {
        $this->status = Status::REVIEW;
    }

    #[Pure] public function isReadyForReview(): bool
    {
        return $this->status->isReview();
    }

    public function reviewed(): void
    {
        $this->status = Status::REVIEWED;
    }

    #[Pure] public function isReviewed(): bool
    {
        return $this->status->isReviewed();
    }

    public function publish(): void
    {
        $this->status = Status::PUBLISHED;
    }

    #[Pure] public function isPublished(): bool
    {
        return $this->status->isPublished();
    }
}