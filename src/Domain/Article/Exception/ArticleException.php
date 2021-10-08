<?php

declare(strict_types=1);

namespace Domain\Article\Exception;

use JetBrains\PhpStorm\Pure;

class ArticleException extends \Exception
{
    #[Pure] public static function cantBeReadyForReview(): self
    {
        return new self("Article can't be ready for review");
    }

    #[Pure] public static function cantBeReviewed(): self
    {
        return new self("Article can't be reviewed");
    }

    #[Pure] public static function cantBePublished(): self
    {
        return new self("Article can't be published");
    }

    #[Pure] public static function contentCantBeChanged(): self
    {
        return new self("Non draft articles can't content");
    }

    #[Pure] public static function reviewedByAuthor(): self
    {
        return new self("Article cannot be reviewed by its author");
    }
}