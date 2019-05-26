<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace App\Config;

use Spiral\Core\InjectableConfig;

class AppConfig extends InjectableConfig
{
    public const CONFIG = 'app';

    protected $config = [
        'downloadsDir'  => '',
        'thumbnailsDir' => '',
        'outputDir'     => '',
    ];

    /**
     * @return string
     */
    public function getDownloadsDir(): string
    {
        return $this->config['downloadsDir'];
    }

    /**
     * @return string
     */
    public function getThumbnailsDir(): string
    {
        return $this->config['thumbnailsDir'];
    }

    /**
     * @return string
     */
    public function getOutputDir(): string
    {
        return $this->config['outputDir'];
    }
}