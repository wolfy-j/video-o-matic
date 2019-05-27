<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Command;

use Spiral\Boot\EnvironmentInterface;
use Spiral\Console\Command;
use Spiral\Console\Console;
use Spiral\Files\FilesInterface;
use Symfony\Component\Console\Question\Question;

class InstallCommand extends Command
{
    protected const NAME        = "install";
    protected const DESCRIPTION = "Install application (run migrations and download application server)";

    /**
     * @param Console              $console
     * @param FilesInterface       $files
     * @param EnvironmentInterface $env
     *
     * @throws \Throwable
     */
    public function perform(Console $console, FilesInterface $files, EnvironmentInterface $env)
    {
        $this->writeln("Installing video-o-gate...");

        $helper = $this->getHelper('question');

        $question = new Question(
            'Please enter the location of videos directory: ',
            $env->get('DOWNLOADS_DIR')
        );

        if (!$directory = $helper->ask($this->input, $this->output, $question)) {
            return;
        }

        if (!$files->isDirectory($directory)) {
            $this->sprintf("<error>No such directory `%s`</error>", $directory);
            return;
        }

        $console->run("configure", [], $this->output);
        $console->run("migrate:init", [], $this->output);
        $console->run("migrate", [], $this->output);
        $console->run("update", [], $this->output);

        // configure the env
        $env = $files->read('.env.sample');
        $env = str_replace('{downloads-directory}', $directory, $env);
        $files->write('.env', $env);

        $console->run("encrypt:key", ['-m' => '.env'], $this->output);
    }
}