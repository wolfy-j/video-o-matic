<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Video;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\FFProbe;

class Probe
{
    /** @var string */
    private $filename;

    /** @var FFProbe */
    private $ffprobe;

    /** @var FFProbe\DataMapping\Format */
    private $format;

    /** @var FFProbe\DataMapping\StreamCollection */
    private $streams;

    /**
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->ffprobe = FFProbe::create();

        $this->format = $this->ffprobe->format($filename);
        $this->streams = $this->ffprobe->streams($filename);
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return FFProbe\DataMapping\Format
     */
    public function getFormat(): FFProbe\DataMapping\Format
    {
        return $this->format;
    }

    /**
     * @return FFProbe\DataMapping\StreamCollection
     */
    public function getStreams(): FFProbe\DataMapping\StreamCollection
    {
        return $this->streams;
    }

    /**
     * @return FFProbe\DataMapping\Stream
     */
    public function getVideo(): FFProbe\DataMapping\Stream
    {
        return $this->streams->videos()->first();
    }

    /**
     * @return Dimension
     */
    public function getDimensions(): Dimension
    {
        return $this->getVideo()->getDimensions();
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return (float)$this->getFormat()->get('duration');
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getFormat()->get("tags")['title'] ?? basename($this->filename);
    }
}