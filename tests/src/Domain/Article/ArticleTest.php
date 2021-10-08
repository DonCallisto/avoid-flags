<?php

declare(strict_types=1);

namespace Tests\src\Domain\Article;

use Domain\Article\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function test_article_creation(): void
    {
        $article = new Article();

        $this->assertTrue($article->isInDraft());
    }

    public function test_put_article_in_review(): void
    {
        $article = new Article();
        $article->readyForReview();

        $this->assertTrue($article->isReadyForReview());
    }

    public function test_article_reviewed(): void
    {
        $article = new Article();
        $article->reviewed();

        $this->assertTrue($article->isReviewed());
    }

    public function test_publish_article(): void
    {
        $article = new Article();
        $article->publish();

        $this->assertTrue($article->isPublished());
    }
}