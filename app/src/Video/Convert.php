<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */
declare(strict_types=1);

namespace App\Video;

use App\Config\AppConfig;
use App\Database\Play;
use Codedungeon\PHPCliColors\Color;
use Cycle\ORM\Transaction;
use Khill\Duration\Duration;
use Spiral\Core\Container\SingletonInterface;
use Spiral\Files\FilesInterface;
use Symfony\Component\Process\Process;

class Convert implements SingletonInterface
{
    /** @var FilesInterface */
    private $files;

    /** @var AppConfig */
    private $config;

    /** @var Transaction */
    private $transaction;

    /**
     * @param FilesInterface $files
     * @param AppConfig      $config
     * @param Transaction    $transaction
     */
    public function __construct(FilesInterface $files, AppConfig $config, Transaction $transaction)
    {
        $this->files = $files;
        $this->config = $config;
        $this->transaction = $transaction;
    }

    /**
     * @param Play $play
     */
    public function convert(Play $play)
    {
        $this->ensureDirectory();

        $totalDuration = floor($play->video->duration);
        $dParser = new Duration();

        error_log("Executing: " . Color::LIGHT_CYAN . $this->getCommand($play) . Color::RESET);

        $process = Process::fromShellCommandline($this->getCommand($play));
        $process->setTimeout(600);
        $process->run(function ($stream, $string) use ($play, $dParser, $totalDuration) {
            //get totalDuration of source
            if (preg_match("/time=(.*?) /", $string, $matches)) {
                try {
                    $value = $dParser->parse($matches[1]);
                } catch (\Throwable $e) {
                    return;
                }

                $ready = floor(100 * $value->toSeconds() / $totalDuration);
                if ($ready > 99) {
                    $ready = 99;
                }

                // complete
                $this->setProgress($play, $ready);
            }
        });

        // todo: handle error

        // complete
        $this->setProgress($play, 100);
    }

    /**
     * Create and empty the directory.
     */
    private function ensureDirectory()
    {
        $this->files->ensureDirectory($this->getDirectory());
        $this->files->deleteDirectory($this->getDirectory(), true);
    }

    /**
     * @return string
     */
    private function getDirectory(): string
    {
        return $this->config->getOutputDir();
    }

    /**
     * @param Play $play
     * @return string
     */
    private function getCommand(Play $play): string
    {
        return sprintf(
            "ffmpeg -i %s -c:a copy -c:v copy -map 0:0 -map 0:%s %s 2>&1",
            escapeshellarg($play->video->filename),
            $play->audio->index,
            escapeshellarg($this->getDirectory() . 'play.mp4')
        );
    }

    private function setProgress(Play $play, float $ready)
    {
        $play->ready = floor($ready);
        $this->transaction->persist($play)->run();

        error_log(sprintf(
            "Converting %s%s%s: %s%s%%%s",
            Color::LIGHT_YELLOW,
            basename($play->video->filename),
            Color::RESET,
            Color::LIGHT_GREEN,
            $ready,
            Color::RESET
        ));
    }
}