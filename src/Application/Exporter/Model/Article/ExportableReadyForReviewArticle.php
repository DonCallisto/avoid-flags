<?php

declare(strict_types=1);

namespace Application\Exporter\Model\Article;

use Application\Exporter\Article\ExportableArticle;
use Application\Exporter\Article\Visitor\ArticleVisitor;
use Application\Exporter\Model\User\ExportableUser;
use Domain\Article\ReadyForReviewArticle;
use Domain\Article\Status;
use JetBrains\PhpStorm\Pure;

class ExportableReadyForReviewArticle implements ExportableArticle
{
    #[Pure] public function __construct(private ReadyForReviewArticle $readyForReviewArticle)
    {
    }

    #[Pure] public function getAuthor(): ExportableUser
    {
        return new ExportableUser($this->readyForReviewArticle->getAuthor());
    }

    #[Pure] public function getContent(): string
    {
        return $this->readyForReviewArticle->getContent();
    }

    #[Pure] public function getStatus(): Status
    {
        return Status::REVIEW;
    }

    public function accept(ArticleVisitor $visitor): void
    {
        $visitor->visitReadyForReview($this);
    }
}