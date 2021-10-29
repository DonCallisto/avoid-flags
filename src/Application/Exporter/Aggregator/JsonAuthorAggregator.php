<?php

declare(strict_types=1);

namespace Application\Exporter\Aggregator;

class JsonAuthorAggregator implements ResultAggregatorInterface
{
    public function __construct(private ArrayAuthorAggregator $arrayAuthorAggregator)
    {
    }

    /**
     * @param array $result
     *
     * @return string
     *
     * @throws \JsonException
     */
    public function aggregate(array $result): string
    {
        $result = array_map(function ($element) {
            return json_decode($element, true);
        }, $result);

        $aggregatedResult = $this->arrayAuthorAggregator->aggregate($result);
        $aggregatedResult = array_map(function ($element) {
            return json_encode($element, JSON_THROW_ON_ERROR);
        }, $aggregatedResult);

        $flatResult = [];
        foreach ($aggregatedResult as $author => $jsonEntry) {
            $flatResult[$author] = json_decode($jsonEntry, true);
        }

        return json_encode($flatResult, JSON_THROW_ON_ERROR);
    }
}