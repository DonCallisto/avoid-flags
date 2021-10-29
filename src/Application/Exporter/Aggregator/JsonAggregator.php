<?php

declare(strict_types=1);

namespace Application\Exporter\Aggregator;

class JsonAggregator implements ResultAggregatorInterface
{
    /**
     * @param array $result
     *
     * @return string
     *
     * @throws \JsonException
     */
    public function aggregate(array $result): string
    {
        $flatResult = [];
        foreach ($result as $jsonEntry) {
            $flatResult = array_merge($flatResult, [json_decode($jsonEntry, true)]);
        }

        return json_encode($flatResult, JSON_THROW_ON_ERROR);
    }
}