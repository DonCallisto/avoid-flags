<?php

declare(strict_types=1);

namespace Application\Exporter\Article\Visitor\Factory;

use Application\Exporter\Article\Visitor\ArticleArrayVisitor;
use Application\Exporter\Aggregator\NoOpAggregator;
use JetBrains\PhpStorm\Pure;

class ArrayVisitorFactory implements VisitorAbstractFactory
{
    #[Pure] public function createVisitor(): ArticleArrayVisitor
    {
        return new ArticleArrayVisitor();
    }

    #[Pure] public function createAggregator(): NoOpAggregator
    {
        return new NoOpAggregator();
    }
}