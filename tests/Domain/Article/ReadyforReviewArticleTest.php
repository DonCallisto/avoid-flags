<?php

declare(strict_types=1);

namespace Tests\Domain\Article;

use Domain\Article\DraftArticle;
use Domain\Article\ReadyForReviewArticle;
use Domain\Article\ReviewedArticle;
use Domain\User\User;
use PHPUnit\Framework\TestCase;

class ReadyforReviewArticleTest extends TestCase
{
    public function test_it_produce_a_reviewed_article_once_reviewed(): void
    {
        $author = new User('DonCallisto', 'samuele.lilli@gmail.com');
        $content = 'article content';

        $readyForReviewArticle = new ReadyForReviewArticle(new DraftArticle($author, $content));

        $reviewedArticle = $readyForReviewArticle->reviewed(new User('OtsillacNod', 'samuele.lilli@madisoft.it'));

        $this->assertInstanceOf(ReviewedArticle::class, $reviewedArticle);
        $this->assertSame($author, $reviewedArticle->getAuthor());
        $this->assertSame($content, $reviewedArticle->getContent());
    }
}