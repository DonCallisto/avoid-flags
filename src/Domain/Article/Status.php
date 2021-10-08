<?php

declare(strict_types=1);

namespace Domain\Article;

enum Status
{
    case DRAFT;
    case REVIEW;
    case REVIEWED;
    case PUBLISHED;

    public function isDraft(): bool
    {
        return $this == self::DRAFT;
    }

    public function isReview(): bool
    {
        return $this == self::REVIEW;
    }

    public function isReviewed(): bool
    {
        return $this == self::REVIEWED;
    }

    public function isPublished(): bool
    {
        return $this == self::PUBLISHED;
    }
}