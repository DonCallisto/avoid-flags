<?php

declare(strict_types=1);

namespace Application\Exporter\Article;

use Application\Exporter\Article\Visitor\ArticleVisitor;

interface ExportableArticle
{
    public function accept(ArticleVisitor $visitor): void;
}