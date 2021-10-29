<?php

declare(strict_types=1);

namespace Tests\Application\Exporter\Aggregator;

use Application\Exporter\Aggregator\JsonAggregator;
use PHPUnit\Framework\TestCase;

class JsonAggregatorTest extends TestCase
{
    public function test_does_aggregate_json_array(): void
    {
        $result = [
            json_encode(['foo' => 'fooVal1']),
            json_encode(['foo' => 'fooVal2']),
        ];

        $aggregator = new JsonAggregator();

        $this->assertEquals(json_encode([
            ['foo' => 'fooVal1'],
            ['foo' => 'fooVal2']
        ]), $aggregator->aggregate($result));
    }
}