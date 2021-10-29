<?php

declare(strict_types=1);

namespace Application\Exporter\Model\Article;

use Application\Exporter\Article\ExportableArticle;
use Application\Exporter\Article\Visitor\ArticleVisitor;
use Application\Exporter\Model\User\ExportableUser;
use Domain\Article\ReviewedArticle;
use Domain\Article\Status;
use JetBrains\PhpStorm\Pure;

class ExportableReviewedArticle implements ExportableArticle
{
    #[Pure] public function __construct(private ReviewedArticle $reviewedArticle)
    {
    }

    #[Pure] public function getAuthor(): ExportableUser
    {
        return new ExportableUser($this->reviewedArticle->getAuthor());
    }

    #[Pure] public function getReviewer(): ExportableUser
    {
        return new ExportableUser($this->reviewedArticle->getReviewer());
    }

    #[Pure] public function getContent(): string
    {
        return $this->reviewedArticle->getContent();
    }

    #[Pure] public function getStatus(): Status
    {
        return Status::REVIEWED;
    }

    public function accept(ArticleVisitor $visitor): void
    {
        $visitor->visitReviewed($this);
    }
}