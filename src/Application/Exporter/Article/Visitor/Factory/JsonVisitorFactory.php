<?php

declare(strict_types=1);

namespace Application\Exporter\Article\Visitor\Factory;

use Application\Exporter\Article\Visitor\ArticleArrayVisitor;
use Application\Exporter\Article\Visitor\ArticleJsonVisitor;
use Application\Exporter\Aggregator\JsonAggregator;
use JetBrains\PhpStorm\Pure;

class JsonVisitorFactory implements VisitorAbstractFactory
{
    #[Pure] public function createVisitor(): ArticleJsonVisitor
    {
        return new ArticleJsonVisitor(new ArticleArrayVisitor());
    }

    #[Pure] public function createAggregator(): JsonAggregator
    {
        return new JsonAggregator();
    }
}