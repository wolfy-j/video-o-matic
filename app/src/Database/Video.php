<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace App\Database;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @entity(
 *     repository="Repository/VideoRepository"
 * )
 * @table(
 *     indexes={@index(columns={filename}, unique=true)}
 * )
 */
class Video
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
     * @column(type=string)
     * @var string
     */
    public $filename;

    /**
     * @column(type=int)
     * @var int
     */
    public $size;

    /**
     * @column(type=string)
     * @var string
     */
    public $title;

    /**
     * @column(type=float)
     * @var float
     */
    public $duration;

    /**
     * @hasMany(target=Stream)
     * @var Stream[]|Collection
     */
    public $streams;

    /**
     * @hasOne(target=Thumbnail)
     * @var Thumbnail[]
     */
    public $thumbnail;

    /**
     * Video constructor.
     */
    public function __construct()
    {
        $this->streams = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function getAudio(): array
    {
        $languages = [];
        foreach ($this->streams as $stream) {
            if ($stream->type == 'audio') {
                $languages[$stream->index] = $stream;
            }
        }

        return $languages;
    }

    /**
     * @return array
     */
    public function getSubtitles(): array
    {
        $languages = [];
        foreach ($this->streams as $stream) {
            if ($stream->type == 'subtitle') {
                $languages[$stream->index] = $stream;
            }
        }

        return $languages;
    }
}