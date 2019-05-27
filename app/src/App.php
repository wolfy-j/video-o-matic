<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App;

use App\Bootloader\AppBootloader;
use App\Bootloader\RoutesBootloader;
use Spiral\Bootloader;
use Spiral\DotEnv\Bootloader as DotEnv;
use Spiral\Framework\Kernel;
use Spiral\Twig\Bootloader as Twig;

class App extends Kernel
{
    /*
     * List of components and extensions to be automatically registered
     * within system container on application start.
     */
    protected const LOAD = [
        // Environment configuration
        DotEnv\DotenvBootloader::class,

        // Core Services
        Bootloader\DebugBootloader::class,
        Bootloader\SnapshotsBootloader::class,

        // Security and validation
        Bootloader\Security\EncrypterBootloader::class,
        Bootloader\Security\FiltersBootloader::class,

        // HTTP extensions
        Bootloader\Http\RouterBootloader::class,
        Bootloader\Http\ErrorHandlerBootloader::class,
        Bootloader\Http\CookiesBootloader::class,
        Bootloader\Http\PaginationBootloader::class,

        // Database and ORM
        Bootloader\Database\DatabaseBootloader::class,
        Bootloader\Cycle\CycleBootloader::class,

        // Additional dispatchers
        Bootloader\Jobs\JobsBootloader::class,

        // Extensions and bridges
        Twig\TwigBootloader::class,

        // Framework commands
        Bootloader\CommandBootloader::class
    ];

    /*
     * Application specific services and extensions.
     */
    protected const APP = [
        AppBootloader::class,
        RoutesBootloader::class,
    ];
}