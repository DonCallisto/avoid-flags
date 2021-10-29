<?php

namespace Application\Exporter\Aggregator;

interface ResultAggregatorInterface
{
    public function aggregate(array $result): mixed;
}