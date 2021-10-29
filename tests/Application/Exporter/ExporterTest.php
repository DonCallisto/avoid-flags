<?php

declare(strict_types=1);

namespace Tests\Application\Exporter;

use Application\Exporter\Article\Visitor\ArticleVisitor;
use Application\Exporter\Article\Visitor\Factory\VisitorAbstractFactory;
use Application\Exporter\Exporter;
use Application\Exporter\Model\Article\ExportableDraftArticle;
use Application\Exporter\Model\Article\ExportablePublishedArticle;
use Application\Exporter\Model\Article\ExportableReadyForReviewArticle;
use Application\Exporter\Model\Article\ExportableReviewedArticle;
use Application\Exporter\Aggregator\ResultAggregatorInterface;
use Domain\Article\DraftArticle;
use Domain\Article\ReadyForReviewArticle;
use Domain\Article\Status;
use Domain\User\User;
use PHPUnit\Framework\TestCase;

class ExporterTest extends TestCase
{
    public function test_exports_articles(): void
    {
        $exporter = new Exporter();

        $visitorFactory = new class implements VisitorAbstractFactory {
            public function createVisitor(): ArticleVisitor
            {
                return new class implements ArticleVisitor {
                    private Status $result;

                    public function visitDraft(ExportableDraftArticle $draftArticle): void
                    {
                        $this->result = $draftArticle->getStatus();
                    }

                    public function visitReadyForReview(ExportableReadyForReviewArticle $readyForReviewArticle): void
                    {
                        $this->result = $readyForReviewArticle->getStatus();
                    }

                    public function visitReviewed(ExportableReviewedArticle $reviewedArticle): void
                    {
                        $this->result = $reviewedArticle->getStatus();
                    }

                    public function visitPublished(ExportablePublishedArticle $publishedArticle): void
                    {
                        $this->result = $publishedArticle->getStatus();
                    }

                    public function visitResult(): Status
                    {
                        return $this->result;
                    }
                };
            }

            public function createAggregator(): ResultAggregatorInterface
            {
                return new class implements ResultAggregatorInterface {
                    public function aggregate(array $result): array
                    {
                        return $result;
                    }
                };
            }
        };

        $draft = new ExportableDraftArticle(
            new DraftArticle(
                new User('DonCallisto', 'samuele.lilli@gmail.com'),
                'foo'
            )
        );
        $readyForReview = new ExportableReadyForReviewArticle(
            new ReadyForReviewArticle(
                new DraftArticle(
                    new User('DonCallisto', 'samuele.lilli@gmail.com'),
                'foo'
                )
            )
        );

        $this->assertEquals([
            Status::DRAFT,
            Status::REVIEW,
        ], $exporter->export($visitorFactory, $draft, $readyForReview));
    }
}