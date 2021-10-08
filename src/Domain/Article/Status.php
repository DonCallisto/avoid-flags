<?php

declare(strict_types=1);

namespace Domain\Article;

use JetBrains\PhpStorm\Pure;

enum Status
{
    case DRAFT;
    case REVIEW;
    case REVIEWED;
    case PUBLISHED;

    #[Pure] public function isDraft(): bool
    {
        return $this == self::DRAFT;
    }

    #[Pure] public function isReview(): bool
    {
        return $this == self::REVIEW;
    }

    #[Pure] public function isReviewed(): bool
    {
        return $this == self::REVIEWED;
    }

    #[Pure] public function isPublished(): bool
    {
        return $this == self::PUBLISHED;
    }
}