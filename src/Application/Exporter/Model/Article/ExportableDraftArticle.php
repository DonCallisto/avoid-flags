<?php

declare(strict_types=1);

namespace Application\Exporter\Model\Article;

use Application\Exporter\Article\ExportableArticle;
use Application\Exporter\Article\Visitor\ArticleVisitor;
use Application\Exporter\Model\User\ExportableUser;
use Domain\Article\DraftArticle;
use Domain\Article\Status;
use JetBrains\PhpStorm\Pure;

class ExportableDraftArticle implements ExportableArticle
{
    public function __construct(private DraftArticle $draftArticle)
    {

    }

    #[Pure] public function getAuthor(): ExportableUser
    {
        return new ExportableUser($this->draftArticle->getAuthor());
    }

    #[Pure] public function getContent(): string
    {
        return $this->draftArticle->getContent();
    }

    #[Pure] public function getStatus(): Status
    {
        return Status::DRAFT;
    }

    public function accept(ArticleVisitor $visitor): void
    {
        $visitor->visitDraft($this);
    }
}