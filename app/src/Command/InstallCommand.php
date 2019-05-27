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
            $this->sprintf("<error>Please specify the directory.</error>\n");
            return;
        }

        if (!$files->isDirectory($directory)) {
            $this->sprintf("<error>No such directory `%s`</error>\n", $directory);
            return;
        }

        // configure the env
        $envData = $files->read('.env.sample');
        $envData = str_replace('{downloads-directory}', $directory, $envData);
        $files->write('.env', $envData);

        $console->run("encrypt:key", ['-m' => '.env'], $this->output);

        $console->run("configure", [], $this->output);
        $console->run("cycle:sync", [], $this->output);
    }
}