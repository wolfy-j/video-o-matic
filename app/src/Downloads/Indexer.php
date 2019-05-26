<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace App\Downloads;

use App\Config\AppConfig;
use Spiral\Core\Container\SingletonInterface;
use Spiral\Files\FilesInterface;

class Indexer implements SingletonInterface
{
    protected const EXTENSIONS = ['mp4', 'mkv', 'mov', 'm4v'];

    /** @var FilesInterface */
    private $files;

    /** @var AppConfig */
    private $config;

    /**
     * @param AppConfig      $config
     * @param FilesInterface $files
     */
    public function __construct(AppConfig $config, FilesInterface $files)
    {
        $this->config = $config;
        $this->files = $files;
    }

    /**
     * @return \Generator|File[]
     */
    public function getFiles(): \Generator
    {
        foreach ($this->files->getFiles($this->config->getDownloadsDir()) as $file) {
            if (!in_array($this->files->extension($file), self::EXTENSIONS)) {
                continue;
            }

            yield new File($file);
        }
    }
}