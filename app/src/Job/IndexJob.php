<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace App\Job;

use App\Database\Repository\VideoRepository;
use App\Downloads\Indexer;
use Spiral\Jobs\AbstractJob;
use Spiral\Jobs\QueueInterface;

class IndexJob extends AbstractJob
{
    /**
     * @param Indexer         $indexer
     * @param VideoRepository $videos
     * @param QueueInterface  $queue
     */
    public function do(Indexer $indexer, VideoRepository $videos, QueueInterface $queue)
    {
        foreach ($indexer->getFiles() as $file) {
            if ($videos->findByFilename($file->getFilename()) !== null) {
                continue;
            }

            $queue->push(new RegisterJob([
                'filename' => $file->getFilename()
            ]));
        }
    }
}