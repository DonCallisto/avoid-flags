<?php

declare(strict_types=1);

namespace Application\Exporter\Aggregator;

use JetBrains\PhpStorm\Pure;

class NoOpAggregator implements ResultAggregatorInterface
{
    #[Pure] public function aggregate(array $result): array
    {
        return $result;
    }
}