<?php

namespace Application\Exporter\Article\Visitor\Factory;

use Application\Exporter\Article\Visitor\ArticleVisitor;
use Application\Exporter\Aggregator\ResultAggregatorInterface;

interface VisitorAbstractFactory
{
    public function createVisitor(): ArticleVisitor;

    public function createAggregator(): ResultAggregatorInterface;
}