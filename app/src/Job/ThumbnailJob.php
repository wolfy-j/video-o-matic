<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Job;

use App\Database\Repository\VideoRepository;
use App\Downloads\ThumbnailGenerator;
use Cycle\ORM\Transaction;
use Spiral\Jobs\AbstractJob;

class ThumbnailJob extends AbstractJob
{
    /**
     * @param string             $filename
     * @param VideoRepository    $videos
     * @param ThumbnailGenerator $generator
     * @param Transaction        $transaction
     */
    public function do(
        string $filename,
        VideoRepository $videos,
        ThumbnailGenerator $generator,
        Transaction $transaction
    ) {
        $video = $videos->findByFilename($filename);

        // doing nothing for now
    }
}