<?php

declare(strict_types=1);

namespace Application\Exporter\Article\Visitor;

use Application\Exporter\Model\Article\ExportableDraftArticle;
use Application\Exporter\Model\Article\ExportablePublishedArticle;
use Application\Exporter\Model\Article\ExportableReadyForReviewArticle;
use Application\Exporter\Model\Article\ExportableReviewedArticle;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class ArticleArrayVisitor implements ArticleVisitor
{
    #[ArrayShape([
        'author' => [
            'username' => 'string',
            'email' => 'string',
        ],
        '?reviewer' => [
            'username' => 'string',
            'email' => 'string',
        ],
        'content' => 'string',
        '?publicationDate' => \DateTimeImmutable::class,
        'status' => 'string'
    ])]
    private array $visitResult = [];

    public function visitDraft(ExportableDraftArticle $draftArticle): void
    {
        $this->visitResult = [
            'author' => [
                'username' => $draftArticle->getAuthor()->getUsername(),
                'email' => $draftArticle->getAuthor()->getEmail(),
            ],
            'content' => $draftArticle->getContent(),
            'status' => $draftArticle->getStatus()->value,
        ];
    }

    public function visitReadyForReview(ExportableReadyForReviewArticle $readyForReviewArticle): void
    {
        $this->visitResult = [
            'author' => [
                'username' => $readyForReviewArticle->getAuthor()->getUsername(),
                'email' => $readyForReviewArticle->getAuthor()->getEmail(),
            ],
            'content' => $readyForReviewArticle->getContent(),
            'status' => $readyForReviewArticle->getStatus()->value,
        ];
    }

    public function visitReviewed(ExportableReviewedArticle $reviewedArticle): void
    {
        $this->visitResult = [
            'author' => [
                'username' => $reviewedArticle->getAuthor()->getUsername(),
                'email' => $reviewedArticle->getAuthor()->getEmail(),
            ],
            'reviewer' => [
                'username' => $reviewedArticle->getReviewer()->getUsername(),
                'email' => $reviewedArticle->getReviewer()->getEmail(),
            ],
            'content' => $reviewedArticle->getContent(),
            'status' => $reviewedArticle->getStatus()->value,
        ];
    }

    public function visitPublished(ExportablePublishedArticle $publishedArticle): void
    {
        $this->visitResult = [
            'author' => [
                'username' => $publishedArticle->getAuthor()->getUsername(),
                'email' => $publishedArticle->getAuthor()->getEmail(),
            ],
            'content' => $publishedArticle->getContent(),
            'publicationDate' => $publishedArticle->getPublicationDate(),
            'status' => $publishedArticle->getStatus()->value,
        ];
    }

    #[Pure] public function visitResult(): array
    {
        return $this->visitResult;
    }
}