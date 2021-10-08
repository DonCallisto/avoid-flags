<?php

declare(strict_types=1);

namespace Tests\src\Domain\Article;

use Domain\Article\Article;
use Domain\Article\Exception\ArticleException;
use Domain\User\User;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function test_article_creation(): void
    {
        $user = new User('DonCallisto', 'samuele.lilli@gmail.com');
        $article = new Article($user, 'foo');

        $this->assertTrue($article->isInDraft());
        $this->assertEquals('foo', $article->getContent());
        $this->assertSame($user, $article->getAuthor());
        $this->assertNull($article->getReviewer());
        $this->assertNull($article->getPublicationDate());
    }

    public function test_put_article_in_review(): void
    {
        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();

        $this->assertTrue($article->isReadyForReview());
        $this->assertEquals('foo', $article->getContent());
        $this->assertNull($article->getReviewer());
        $this->assertNull($article->getPublicationDate());
    }

    public function test_put_article_in_review_a_ready_for_review_article(): void
    {
        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->readyForReview();

        $this->assertTrue($article->isReadyForReview());
    }

    public function test_article_cant_be_ready_for_reviewed_if_reviewed(): void
    {
        $this->expectExceptionObject(ArticleException::cantBeReadyForReview());

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->reviewed(new User('OtosillacNod', 'samuele.lilli@madisoft.it'));
        $article->readyForReview();
    }

    public function test_article_cant_be_ready_for_review_if_published(): void
    {
        $this->expectExceptionObject(ArticleException::cantBeReadyForReview());

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->reviewed(new User('OtosillacNod', 'samuele.lilli@madisoft.it'));
        $article->publish(new \DateTime());
        $article->readyForReview();
    }

    public function test_article_reviewed(): void
    {
        $reviewer = new User('OtosillacNod', 'samuele.lilli@madisoft.it');
        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->reviewed($reviewer);

        $this->assertTrue($article->isReviewed());
        $this->assertEquals('foo', $article->getContent());
        $this->assertSame($reviewer, $article->getReviewer());
        $this->assertNull($article->getPublicationDate());
    }

    public function test_reviewer_cant_be_same_as_author(): void
    {
        $this->expectExceptionObject(ArticleException::reviewedByAuthor());

        $author = new User('OtosillacNod', 'samuele.lilli@madisoft.it');
        $article = new Article($author, 'foo');
        $article->readyForReview();
        $article->reviewed($author);
    }

    public function test_reviewed_a_reviewed_article(): void
    {
        $reviewer = new User('OtosillacNod', 'samuele.lilli@madisoft.it');

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->reviewed($reviewer);
        $article->reviewed($reviewer);

        $this->assertTrue($article->isReviewed());
    }

    public function test_article_cant_be_reviewed_if_is_a_draft(): void
    {
        $this->expectExceptionObject(ArticleException::cantBeReviewed());

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->reviewed(new User('OtosillacNod', 'samuele.lilli@madisoft.it'));
    }

    public function test_article_cant_be_reviewed_if_published(): void
    {
        $reviewer = new User('OtosillacNod', 'samuele.lilli@madisoft.it');

        $this->expectExceptionObject(ArticleException::cantBeReviewed());

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->reviewed($reviewer);
        $article->publish(new \DateTime());
        $article->reviewed($reviewer);
    }

    public function test_publish_article(): void
    {
        $publicationDate = new \DateTime();

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->reviewed(new User('OtosillacNod', 'samuele.lilli@madisoft.it'));
        $article->publish($publicationDate);

        $this->assertTrue($article->isPublished());
        $this->assertEquals('foo', $article->getContent());
        $this->assertEquals($publicationDate, $article->getPublicationDate());
    }

    public function test_publish_a_published_articled(): void
    {
        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->reviewed(new User('OtosillacNod', 'samuele.lilli@madisoft.it'));
        $article->publish(new \DateTime());
        $article->publish(new \DateTime());

        $this->assertTrue($article->isPublished());
    }

    public function test_article_cant_be_published_if_is_a_draft(): void
    {
        $this->expectExceptionObject(ArticleException::cantBePublished());

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->publish(new \DateTime());
    }

    public function test_article_cant_be_published_if_is_ready_for_review(): void
    {
        $this->expectExceptionObject(ArticleException::cantBePublished());

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->publish(new \DateTime());
    }

    public function test_change_content_of_draft_article(): void
    {
        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->changeContentTo('bar');

        $this->assertEquals('bar', $article->getContent());
    }

    public function test_cant_change_content_of_article_ready_for_review(): void
    {
        $this->expectExceptionObject(ArticleException::contentCantBeChanged());

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->changeContentTo('bar');
    }

    public function test_cant_change_content_of_reviewed_article(): void
    {
        $this->expectExceptionObject(ArticleException::contentCantBeChanged());

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->reviewed(new User('OtosillacNod', 'samuele.lilli@madisoft.it'));
        $article->changeContentTo('bar');
    }

    public function test_cant_change_content_of_published_article(): void
    {
        $this->expectExceptionObject(ArticleException::contentCantBeChanged());

        $article = new Article(new User('DonCallisto', 'samuele.lilli@gmail.com'), 'foo');
        $article->readyForReview();
        $article->reviewed(new User('OtosillacNod', 'samuele.lilli@madisoft.it'));
        $article->publish(new \DateTime());
        $article->changeContentTo('bar');
    }
}