<?php

declare(strict_types=1);

namespace Application\Exporter\Model\Article;

use Application\Exporter\Article\ExportableArticle;
use Application\Exporter\Article\Visitor\ArticleVisitor;
use Application\Exporter\Model\User\ExportableUser;
use Domain\Article\PublishedArticle;
use Domain\Article\Status;
use JetBrains\PhpStorm\Pure;

class ExportablePublishedArticle implements ExportableArticle
{
    public function __construct(private PublishedArticle $publishedArticle)
    {
    }

    #[Pure] public function getAuthor(): ExportableUser
    {
        return new ExportableUser($this->publishedArticle->getAuthor());
    }

    #[Pure] public function getContent(): string
    {
        return $this->publishedArticle->getContent();
    }

    #[Pure] public function getPublicationDate(): \DateTimeImmutable
    {
        return $this->publishedArticle->getPublicationDate();
    }

    #[Pure] public function getStatus(): Status
    {
        return Status::PUBLISHED;
    }

    public function accept(ArticleVisitor $visitor): void
    {
        $visitor->visitPublished($this);
    }
}