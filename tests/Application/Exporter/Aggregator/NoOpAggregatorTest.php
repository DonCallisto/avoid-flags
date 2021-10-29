<?php

declare(strict_types=1);

namespace Tests\Application\Exporter\Aggregator;

use Application\Exporter\Aggregator\NoOpAggregator;
use PHPUnit\Framework\TestCase;

class NoOpAggregatorTest extends TestCase
{
    public function test_does_not_aggregate_result(): void
    {
        $result = [
            ['foo'],
            ['bar'],
        ];

        $aggregator = new NoOpAggregator();

        $this->assertEquals($result, $aggregator->aggregate($result));
    }
}