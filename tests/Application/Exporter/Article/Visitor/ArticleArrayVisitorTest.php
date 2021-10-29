<?php

declare(strict_types=1);

namespace Tests\Application\Exporter\Article\Visitor;

use Application\Exporter\Article\Visitor\ArticleArrayVisitor;
use Application\Exporter\Model\Article\ExportableDraftArticle;
use Application\Exporter\Model\Article\ExportablePublishedArticle;
use Application\Exporter\Model\Article\ExportableReadyForReviewArticle;
use Application\Exporter\Model\Article\ExportableReviewedArticle;
use Domain\Article\DraftArticle;
use Domain\Article\PublishedArticle;
use Domain\Article\ReadyForReviewArticle;
use Domain\Article\ReviewedArticle;
use Domain\Article\Status;
use Domain\User\User;
use PHPUnit\Framework\TestCase;

class ArticleArrayVisitorTest extends TestCase
{
    public function test_it_visit_draft(): void
    {
        $visitor = new ArticleArrayVisitor();

        $draft = new ExportableDraftArticle(
            new DraftArticle(
                new User('DonCallisto', 'samuele.lilli@gmail.com'),
                'foo'
            )
        );
        $visitor->visitDraft($draft);

        $this->assertEquals([
            'author' => [
                'username' => 'DonCallisto',
                'email' => 'samuele.lilli@gmail.com',
            ],
            'content' => 'foo',
            'status' => Status::DRAFT->value,
        ], $visitor->visitResult());
    }

    public function test_it_visit_ready_for_review(): void
    {
        $visitor = new ArticleArrayVisitor();

        $readyForReview = new ExportableReadyForReviewArticle(
            new ReadyForReviewArticle(
                new DraftArticle(
                    new User('DonCallisto', 'samuele.lilli@gmail.com'),
                    'foo'
                )
            )
        );
        $visitor->visitReadyForReview($readyForReview);

        $this->assertEquals([
            'author' => [
                'username' => 'DonCallisto',
                'email' => 'samuele.lilli@gmail.com',
            ],
            'content' => 'foo',
            'status' => Status::REVIEW->value,
        ], $visitor->visitResult());
    }

    public function test_it_visit_reviewed_article(): void
    {
        $visitor = new ArticleArrayVisitor();

        $reviewedArticle = new ExportableReviewedArticle(
            new ReviewedArticle(
                new ReadyForReviewArticle(
                    new DraftArticle(
                        new User('DonCallisto', 'samuele.lilli@gmail.com'),
                        'foo'
                    ),
                ),
                new User('OtsillacNod', 'samuele.lilli@madisoft.it'),
            )
        );
        $visitor->visitReviewed($reviewedArticle);

        $this->assertEquals([
            'author' => [
                'username' => 'DonCallisto',
                'email' => 'samuele.lilli@gmail.com',
            ],
            'reviewer' => [
                'username' => 'OtsillacNod',
                'email' => 'samuele.lilli@madisoft.it',
            ],
            'content' => 'foo',
            'status' => Status::REVIEWED->value,
        ], $visitor->visitResult());
    }

    public function test_it_visit_published_article(): void
    {
        $visitor = new ArticleArrayVisitor();

        $publicationDate = new \DateTime();
        $publishedArticle = new ExportablePublishedArticle(
            new PublishedArticle(
                new ReviewedArticle(
                    new ReadyForReviewArticle(
                        new DraftArticle(
                            new User('DonCallisto', 'samuele.lilli@gmail.com'),
                            'foo'
                        )
                    ),
                    new User('OtsillacNod', 'samuele.lilli@madisoft.it')
                ),
                $publicationDate
            ),
        );
        $visitor->visitPublished($publishedArticle);

        $this->assertEquals([
            'author' => [
                'username' => 'DonCallisto',
                'email' => 'samuele.lilli@gmail.com',
            ],
            'content' => 'foo',
            'publicationDate' => \DateTimeImmutable::createFromMutable($publicationDate),
            'status' => Status::PUBLISHED->value,
        ], $visitor->visitResult());
    }
}