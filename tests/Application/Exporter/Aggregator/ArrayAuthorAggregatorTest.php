<?php

declare(strict_types=1);

namespace Tests\Application\Exporter\Aggregator;

use Application\Exporter\Aggregator\ArrayAuthorAggregator;
use PHPUnit\Framework\TestCase;

class ArrayAuthorAggregatorTest extends TestCase
{
    public function test_it_aggregates_by_author(): void
    {
        $result = [
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
                    'username' => 'OtsillacNod',
                    'email' => 'samuele.lilli@madisoft.it',
                ],
                'content' => 'foo',
                'status' => 'another Status status',
            ],
            [
                'author' => [
                    'username' => 'DonCallisto',
                    'email' => 'samuele.lilli@gmail.com',
                ],
                'content' => 'foo',
                'status' => 'a third status',
            ],
        ];

        $aggregator = new ArrayAuthorAggregator();

        $this->assertEquals([
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
        ], $aggregator->aggregate($result));
    }
}