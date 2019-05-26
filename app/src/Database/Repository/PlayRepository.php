<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Database\Repository;

use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository;

class PlayRepository extends Repository
{
    /**
     * @return Select
     */
    public function select(): Select
    {
        return parent::select()->load('video.streams')->load('audio');
    }
}