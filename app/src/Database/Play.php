<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Database;

/**
 * @entity(
 *     repository="Repository/PlayRepository"
 * )
 */
class Play
{
    /**
     * @column(type=primary)
     * @var int
     */
    public $id;

    /**
     * @column(type=datetime)
     * @var \DateTimeImmutable
     */
    public $created_at;

    /**
     * @refersTo(target=Video)
     * @var Video
     */
    public $video;

    /**
     * @refersTo(target=Stream)
     * @var Stream
     */
    public $audio;

    /**
     * @column(type=int)
     * @var int
     */
    public $ready;
}