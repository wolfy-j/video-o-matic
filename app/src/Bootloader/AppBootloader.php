<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Bootloader;

use App\Twig\Filters;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Twig\Bootloader\TwigBootloader;

class AppBootloader extends Bootloader
{
    /**
     * @param TwigBootloader $twig
     */
    public function boot(TwigBootloader $twig)
    {
        $twig->addExtension(Filters::class);
    }
}