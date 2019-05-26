<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace App\Database\Repository;

use App\Database\Video;
use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository;

class VideoRepository extends Repository
{
    /**
     * @return iterable|Video
     */
    public function findRecent(): iterable
    {
        return $this->select()->orderBy('created_at', 'DESC')->fetchAll();
    }

    /**
     * @return iterable|Video
     */
    public function findSorted(): iterable
    {
        return $this->select()->orderBy('filename', 'ASC')->fetchAll();
    }

    /**
     * @param string $filename
     * @return Video|null
     */
    public function findByFilename(string $filename): ?Video
    {
        return $this->findOne(compact('filename'));
    }

    /**
     * @return Select
     */
    public function select(): Select
    {
        return parent::select()->load('streams')->load('thumbnail');
    }
}