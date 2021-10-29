<?php

declare(strict_types=1);

namespace Application\Exporter\Article\Visitor\Factory;

use Application\Exporter\Aggregator\ArrayAuthorAggregator;
use Application\Exporter\Aggregator\JsonAuthorAggregator;
use Application\Exporter\Article\Visitor\ArticleArrayVisitor;
use Application\Exporter\Article\Visitor\ArticleJsonVisitor;
use JetBrains\PhpStorm\Pure;

class JsonAuthorAggregatedVisitorFactory implements VisitorAbstractFactory
{
    #[Pure] public function createVisitor(): ArticleJsonVisitor
    {
        return new ArticleJsonVisitor(new ArticleArrayVisitor());
    }

    #[Pure] public function createAggregator(): JsonAuthorAggregator
    {
        return new JsonAuthorAggregator(new ArrayAuthorAggregator());
    }
}