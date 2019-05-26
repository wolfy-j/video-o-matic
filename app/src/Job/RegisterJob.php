<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace App\Job;

use App\Database\Stream;
use App\Database\Video;
use App\Downloads\VideoProbe;
use Codedungeon\PHPCliColors\Color;
use Cycle\ORM\Transaction;
use Khill\Duration\Duration;
use Spiral\Jobs\AbstractJob;
use Spiral\Jobs\QueueInterface;

class RegisterJob extends AbstractJob
{
    /**
     * @param string         $filename
     * @param Transaction    $transaction
     * @param QueueInterface $queue
     *
     * @throws \Throwable
     */
    public function do(string $filename, Transaction $transaction, QueueInterface $queue)
    {
        $probe = new VideoProbe($filename);
        $this->log($probe);

        $video = new Video();
        $video->created_at = new \DateTime();
        $video->filename = $probe->getFilename();
        $video->size = filesize($filename);
        $video->title = $probe->getTitle();
        $video->duration = $probe->getDuration();

        foreach ($probe->getStreams() as $stream) {
            $stream = self::mapFF($stream);
            if ($stream === null) {
                continue;
            }

            $video->streams->add($stream);
        }

        $transaction->persist($video)->run();
        $queue->push(new ThumbnailJob(compact('filename')));
    }

    /**
     * @param VideoProbe $reader
     */
    private function log(VideoProbe $reader)
    {
        $duration = new Duration();

        error_log(sprintf(
            "found %s%s%s: duration %s%s%s, dimensions %s%sx%s%s",
            Color::LIGHT_YELLOW,
            $reader->getTitle(),
            Color::RESET,
            Color::LIGHT_RED,
            $duration->formatted($reader->getDuration()),
            Color::RESET,
            Color::CYAN,
            $reader->getDimensions()->getWidth(),
            $reader->getDimensions()->getHeight(),
            Color::RESET
        ));
    }

    /**
     * @param \FFMpeg\FFProbe\DataMapping\Stream $p
     * @return Stream|null
     */
    public static function mapFF(\FFMpeg\FFProbe\DataMapping\Stream $p): ?Stream
    {
        if ($p->get("codec_type") === "data" || $p->get("codec_type") === "subtitle") {
            return self::mapSubtitle($p);
        }

        $s = new Stream();
        $s->index = $p->get('index');
        $s->type = $p->get("codec_type");
        $s->title = $p->get('tags')['title'] ?? null;
        $s->codecName = $p->get('codec_name');
        $s->language = $p->get("tags")['language'] ?? null;

        return $s;
    }

    /**
     * @param \FFMpeg\FFProbe\DataMapping\Stream $p
     * @return Stream|null
     */
    protected static function mapSubtitle(\FFMpeg\FFProbe\DataMapping\Stream $p): ?Stream
    {
        if ($p->get("codec_type") === "data") {
            $handler = $p->get("tags")["handle_name"] ?? null;
            if ($handler !== 'SubtitleHandler') {
                return null;
            }
        }

        $language = $p->get("tags")['language'] ?? null;
        if ($language === null) {
            return null;
        }

        $s = new Stream();
        $s->index = $p->get('index');
        $s->type = 'subtitle';
        $s->title = $p->get('tags')['title'] ?? null;
        $s->language = $language;

        return $s;
    }
}