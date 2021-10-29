<?php

declare(strict_types=1);

namespace Application\Exporter\Article\Visitor\Factory;

use Application\Exporter\Aggregator\ArrayAuthorAggregator;
use Application\Exporter\Article\Visitor\ArticleArrayVisitor;
use JetBrains\PhpStorm\Pure;

class ArrayAuthorAggregatedVisitorFactory implements VisitorAbstractFactory
{
    #[Pure] public function createVisitor(): ArticleArrayVisitor
    {
        return new ArticleArrayVisitor();
    }

    #[Pure] public function createAggregator(): ArrayAuthorAggregator
    {
        return new ArrayAuthorAggregator();
    }
}