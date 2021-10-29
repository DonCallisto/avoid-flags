<?php

declare(strict_types=1);

namespace Application\Exporter\Aggregator;

class ArrayAuthorAggregator implements ResultAggregatorInterface
{
    public function aggregate(array $result): array
    {
        $aggregateResult = [];
        foreach ($result as $article) {
            $aggregateResult[$article['author']['username']]['articles'][] = $article;
        }

        return $aggregateResult;
    }
}