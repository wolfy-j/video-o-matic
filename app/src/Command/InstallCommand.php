<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Command;

use Spiral\Console\Command;
use Spiral\Console\Console;

class InstallCommand extends Command
{
    protected const NAME        = "install";
    protected const DESCRIPTION = "Install application (run migrations and download application server)";

    /**
     * @param Console $console
     *
     * @throws \Throwable
     */
    public function perform(Console $console)
    {
        $this->writeln("Installing video-o-gate");

        $console->run("configure", [], $this->output);
        $console->run("migrate:init", [], $this->output);
        $console->run("migrate", [], $this->output);
        $console->run("update", [], $this->output);
    }
}