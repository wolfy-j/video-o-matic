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
use Spiral\Bootloader\ConsoleBootloader;
use Spiral\Twig\Bootloader\TwigBootloader;

class AppBootloader extends Bootloader
{
    public function boot(ConsoleBootloader $console, TwigBootloader $twig)
    {
        $twig->addExtension(Filters::class);
    }
}