<?php

declare(strict_types=1);

namespace Tests\Application\Exporter\Aggregator;

use Application\Exporter\Aggregator\ArrayAuthorAggregator;
use Application\Exporter\Aggregator\JsonAggregator;
use Application\Exporter\Aggregator\JsonAuthorAggregator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Json;

class JsonAuthorAggregatorTest extends TestCase
{
    public function test_it_aggregates_by_author(): void
    {
        $result = [
            json_encode([
                'author' => [
                    'username' => 'DonCallisto',
                     'email' => 'samuele.lilli@gmail.com',
                ],
                'content' => 'foo',
                'status' => 'a status',
            ]),
            json_encode([
                'author' => [
                    'username' => 'OtsillacNod',
                    'email' => 'samuele.lilli@madisoft.it',
                ],
                'content' => 'foo',
                'status' => 'another Status status',
            ]),
            json_encode([
                'author' => [
                    'username' => 'DonCallisto',
                    'email' => 'samuele.lilli@gmail.com',
                ],
                'content' => 'foo',
                'status' => 'a third status',
            ]),
        ];

        $aggregator = new JsonAuthorAggregator(new ArrayAuthorAggregator(), new JsonAggregator());

        $this->assertEquals(json_encode([
            'DonCallisto' => [
                'articles' => [
                    [
                        'author' => [
                            'username' => 'DonCallisto',
                            'email' => 'samuele.lilli@gmail.com',
                        ],
                        'content' => 'foo',
                        'status' => 'a status',
                    ],
                    [
                        'author' => [
                            'username' => 'DonCallisto',
                            'email' => 'samuele.lilli@gmail.com',
                        ],
                        'content' => 'foo',
                        'status' => 'a third status',
                    ],
                ],
           ],
            'OtsillacNod' => [
                'articles' => [
                    [
                        'author' => [
                            'username' => 'OtsillacNod',
                            'email' => 'samuele.lilli@madisoft.it',
                        ],
                        'content' => 'foo',
                        'status' => 'another Status status',
                    ],
                ],
            ],
        ]), $aggregator->aggregate($result));
    }
}