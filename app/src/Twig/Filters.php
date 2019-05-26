<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Twig;

use Khill\Duration\Duration;
use Spiral\Helpers\Strings;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Filters extends AbstractExtension
{
    /**
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('basename', [$this, 'basename']),
            new TwigFilter('duration', [$this, 'duration']),
            new TwigFilter('filesize', [$this, 'filesize']),
            new TwigFilter('dump', [$this, 'dump']),
        ];
    }

    /**
     * @param string $filename
     * @return string
     */
    public function basename(string $filename): string
    {
        return basename($filename);
    }

    /**
     * @param float $duration
     * @return string
     */
    public function duration(float $duration): string
    {
        $d = new Duration();

        return $d->formatted(round($duration));
    }

    /**
     * @param $value
     * @return string
     */
    public function filesize($value): string
    {
        return Strings::bytes($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function dump($value): string
    {
        return print_r($value, true);
    }
}