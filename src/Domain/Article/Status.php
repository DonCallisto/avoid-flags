<?php

declare(strict_types=1);

namespace Domain\Article;

use JetBrains\PhpStorm\Pure;

enum Status: string
{
    case DRAFT = 'draft';
    case REVIEW = 'review';
    case REVIEWED = 'reviewed';
    case PUBLISHED = 'published';

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