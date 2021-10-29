<?php

namespace Application\Exporter\Article\Visitor;

use Application\Exporter\Model\Article\ExportableDraftArticle;
use Application\Exporter\Model\Article\ExportablePublishedArticle;
use Application\Exporter\Model\Article\ExportableReadyForReviewArticle;
use Application\Exporter\Model\Article\ExportableReviewedArticle;

interface ArticleVisitor
{
    public function visitDraft(ExportableDraftArticle $draftArticle): void;

    public function visitReadyForReview(ExportableReadyForReviewArticle $readyForReviewArticle): void;

    public function visitReviewed(ExportableReviewedArticle $reviewedArticle): void;

    public function visitPublished(ExportablePublishedArticle $publishedArticle): void;

    public function visitResult(): mixed;
}