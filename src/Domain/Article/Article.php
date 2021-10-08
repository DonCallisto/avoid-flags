<?php

declare(strict_types=1);

namespace Domain\Article;

use Domain\Article\Exception\ArticleException;
use Domain\User\User;
use JetBrains\PhpStorm\Pure;

class Article
{
    private Status $status;

    private ?User $reviewer;

    private ?\DateTimeImmutable $publicationDate;

    public function __construct(private User $author, private string $content)
    {
        $this->status = Status::DRAFT;
        $this->reviewer = null;
        $this->publicationDate = null;
    }

    #[Pure] public function isInDraft(): bool
    {
        return $this->status->isDraft();
    }

    /**
     * @throws ArticleException
     */
    public function readyForReview(): void
    {
        if ($this->isReadyForReview()) {
            return;
        }

        if (!$this->isInDraft()) {
            throw ArticleException::cantBeReadyForReview();
        }

        $this->status = Status::REVIEW;
    }

    #[Pure] public function isReadyForReview(): bool
    {
        return $this->status->isReview();
    }

    /**
     * @throws ArticleException
     */
    public function reviewed(User $reviewer): void
    {
        if ($this->isReviewed()) {
            return;
        }

        if (!$this->isReadyForReview()) {
            throw ArticleException::cantBeReviewed();
        }

        if ($reviewer === $this->author) {
            throw ArticleException::reviewedByAuthor();
        }

        $this->status = Status::REVIEWED;
        $this->reviewer = $reviewer;
    }

    #[Pure] public function isReviewed(): bool
    {
        return $this->status->isReviewed();
    }

    /**
     * @throws ArticleException
     */
    public function publish(\DateTimeInterface $publicationDate): void
    {
        if ($this->isPublished()) {
            return;
        }

        if (!$this->isReviewed()) {
            throw ArticleException::cantBePublished();
        }

        $this->status = Status::PUBLISHED;
        $this->publicationDate = \DateTimeImmutable::createFromInterface($publicationDate);
    }

    #[Pure] public function isPublished(): bool
    {
        return $this->status->isPublished();
    }

    #[Pure] public function getAuthor(): User
    {
        return $this->author;
    }

    #[Pure] public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $newContent
     *
     * @throws ArticleException
     */
    public function changeContentTo(string $newContent): void
    {
        if (!$this->isInDraft()) {
            throw ArticleException::contentCantBeChanged();
        }

        $this->content = $newContent;
    }

    // We can also throw an exception...
    #[Pure] public function getReviewer(): ?User
    {
        return $this->reviewer;
    }

    // We can also throw an exception...
    #[Pure] public function getPublicationDate(): ?\DateTimeImmutable
    {
        return $this->publicationDate;
    }
}