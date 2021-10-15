<?php

declare(strict_types=1);

namespace Tests\Domain\Article;

use Domain\Article\DraftArticle;
use Domain\Article\PublishedArticle;
use Domain\Article\ReadyForReviewArticle;
use Domain\Article\ReviewedArticle;
use Domain\User\User;
use PHPUnit\Framework\TestCase;

class ReviewedArticleTest extends TestCase
{
    public function test_it_produce_a_published_article_when_ready_for_publishing(): void
    {
        $author = new User('DonCallisto', 'samuele.lilli@gmail.com');
        $reviewer = new User('OtsillacNod', 'samuele.lilli@madisoft.it');
        $content = 'article content';

        $reviewedArticle = new ReviewedArticle(
            new ReadyForReviewArticle(
                new DraftArticle($author, $content),
            ),
            $reviewer
        );

        $publishedArticle = $reviewedArticle->publish(new \DateTime());

        $this->assertInstanceOf(PublishedArticle::class, $publishedArticle);
        $this->assertSame($author, $reviewedArticle->getAuthor());
        $this->assertSame($content, $reviewedArticle->getContent());
    }
}