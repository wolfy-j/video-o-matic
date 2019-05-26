<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace App\Database;

/**
 * @entity
 */
class Stream
{
    /**
     * @column(type=primary)
     * @var int
     */
    public $id;

    /**
     * @column(type=int)
     * @var int
     */
    public $index;

    /**
     * @column(type="enum(video,audio,subtitle)")
     * @var string
     */
    public $type;

    /**
     * @column(type=string,nullable=true)
     * @var string
     */
    public $title;

    /**
     * @column(type=string,nullable=true)
     * @var string
     */
    public $codecName;

    /**
     * @column(type=string,nullable=true)
     * @var string
     */
    public $language;
}