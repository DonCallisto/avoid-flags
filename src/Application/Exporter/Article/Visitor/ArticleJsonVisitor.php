<?php

declare(strict_types=1);

namespace Application\Exporter\Article\Visitor;

use Application\Exporter\Model\Article\ExportableDraftArticle;
use Application\Exporter\Model\Article\ExportablePublishedArticle;
use Application\Exporter\Model\Article\ExportableReadyForReviewArticle;
use Application\Exporter\Model\Article\ExportableReviewedArticle;

class ArticleJsonVisitor implements ArticleVisitor
{
    private string $visitResult;

    public function __construct(private ArticleArrayVisitor $visitor)
    {

    }

    public function visitDraft(ExportableDraftArticle $draftArticle): void
    {
        $this->visitor->visitDraft($draftArticle);

        $this->visitResult = json_encode($this->visitor->visitResult(), JSON_THROW_ON_ERROR);
    }

    public function visitReadyForReview(ExportableReadyForReviewArticle $readyForReviewArticle): void
    {
        $this->visitor->visitReadyForReview($readyForReviewArticle);

        $this->visitResult = json_encode($this->visitor->visitResult(), JSON_THROW_ON_ERROR);
    }

    public function visitReviewed(ExportableReviewedArticle $reviewedArticle): void
    {
        $this->visitor->visitReviewed($reviewedArticle);

        $this->visitResult = json_encode($this->visitor->visitResult(), JSON_THROW_ON_ERROR);
    }

    public function visitPublished(ExportablePublishedArticle $publishedArticle): void
    {
        $this->visitor->visitPublished($publishedArticle);

        $this->visitResult = json_encode($this->visitor->visitResult(), JSON_THROW_ON_ERROR);
    }

    public function visitResult(): string
    {
        return $this->visitResult;
    }
}