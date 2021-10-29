<?php

declare(strict_types=1);

include('vendor/autoload.php');

use Application\Exporter\Article\Visitor\Factory\ArrayAuthorAggregatedVisitorFactory;
use Application\Exporter\Article\Visitor\Factory\ArrayVisitorFactory;
use Application\Exporter\Article\Visitor\Factory\JsonAuthorAggregatedVisitorFactory;
use Application\Exporter\Article\Visitor\Factory\JsonVisitorFactory;
use Application\Exporter\Exporter;
use Application\Exporter\Model\Article\ExportableDraftArticle;
use Application\Exporter\Model\Article\ExportablePublishedArticle;
use Application\Exporter\Model\Article\ExportableReadyForReviewArticle;
use Application\Exporter\Model\Article\ExportableReviewedArticle;
use Domain\Article\DraftArticle;
use Domain\Article\PublishedArticle;
use Domain\Article\ReadyForReviewArticle;
use Domain\Article\ReviewedArticle;
use Domain\User\User;

$donCallisto = new User('DonCallisto', 'samuele.lilli@gmail.com');
$johnDoe = new User('JohnDoe', 'john.doe@gmail.com');
$otsillacNod = new User('OtsillacNod', 'samuele.lilli@madisoft.it');

$a1 = new ExportableDraftArticle(
    new DraftArticle($donCallisto, 'foo')
);
$a2 = new ExportableReadyForReviewArticle(
    new ReadyForReviewArticle(
        new DraftArticle($donCallisto, 'foo')
    )
);
$a3 = new ExportableReviewedArticle(
    new ReviewedArticle(
        new ReadyForReviewArticle(
            new DraftArticle($donCallisto, 'foo'),
        ),
        $otsillacNod
    )
);

$a4 = new ExportablePublishedArticle(
    new PublishedArticle(
        new ReviewedArticle(
            new ReadyForReviewArticle(
                new DraftArticle($donCallisto, 'foo'),
            ),
            $otsillacNod
        ),
        new \DateTime()
    )
);

$a5 = new ExportableDraftArticle(
    new DraftArticle($johnDoe, 'foo')
);
$a6 = new ExportableReadyForReviewArticle(
    new ReadyForReviewArticle(
        new DraftArticle($johnDoe, 'foo')
    )
);

echo 'Start array exporting...' . PHP_EOL;
$exporter = new Exporter();
$result = $exporter->export(new ArrayVisitorFactory(), $a1, $a2, $a3, $a4, $a5, $a6);
echo 'Results: ' . PHP_EOL;
echo print_r($result, true) . PHP_EOL;
echo 'Finish array exporting' . PHP_EOL;

echo 'Start json exporting...' . PHP_EOL;
$exporter = new Exporter();
$result = $exporter->export(new JsonVisitorFactory(), $a1, $a2, $a3, $a5, $a6);
echo 'Results: ' . PHP_EOL;
echo print_r($result, true) . PHP_EOL;
echo 'Finish array exporting' . PHP_EOL;

echo 'Start array (author aggregated) exporting...' . PHP_EOL;
$exporter = new Exporter();
$result = $exporter->export(new ArrayAuthorAggregatedVisitorFactory(), $a1, $a2, $a3, $a4, $a5, $a6);
echo 'Results: ' . PHP_EOL;
echo print_r($result, true) . PHP_EOL;
echo 'Finish array exporting' . PHP_EOL;

echo 'Start json (author aggregated) exporting...' . PHP_EOL;
$exporter = new Exporter();
$result = $exporter->export(new JsonAuthorAggregatedVisitorFactory(), $a1, $a2, $a3, $a5, $a6);
echo 'Results: ' . PHP_EOL;
echo print_r($result, true) . PHP_EOL;
echo 'Finish array exporting' . PHP_EOL;