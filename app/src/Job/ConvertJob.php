<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Job;

use App\Database\Repository\PlayRepository;
use App\Downloads\Convert;
use Spiral\Jobs\AbstractJob;

class ConvertJob extends AbstractJob
{
    public function do(int $playID, PlayRepository $repository, Convert $convert)
    {
        $convert->convert($repository->findByPK($playID));
    }
}