<?php

declare(strict_types=1);

namespace Application\Exporter;

use Application\Exporter\Article\ExportableArticle;
use Application\Exporter\Article\Visitor\Factory\VisitorAbstractFactory;

class Exporter
{
    public function export(VisitorAbstractFactory $visitorAbstractFactory, ExportableArticle ...$exportableArticles)
    {
        $visitor = $visitorAbstractFactory->createVisitor();

        $results = [];
        foreach ($exportableArticles as $exportableArticle) {
            $exportableArticle->accept($visitor);
            $results[] = $visitor->visitResult();
        }

        $aggregator = $visitorAbstractFactory->createAggregator();

        return $aggregator->aggregate($results);
    }
}