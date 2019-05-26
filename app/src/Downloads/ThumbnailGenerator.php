<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Downloads;

use App\Config\AppConfig;

/**
 * @package App\Downloads
 */
class ThumbnailGenerator
{
    /** @var AppConfig */
    private $config;

    /**
     * @param AppConfig $config
     */
    public function __construct(AppConfig $config)
    {
        $this->config = $config;
    }
}