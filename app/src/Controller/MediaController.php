<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace App\Controller;

use App\Database\Play;
use App\Database\Repository\PlayRepository;
use App\Database\Repository\VideoRepository;
use App\Database\Stream;
use App\Job\ConvertJob;
use App\Job\IndexJob;
use App\Request\PlayRequest;
use Cycle\ORM\Transaction;
use Psr\Http\Message\ResponseInterface;
use Spiral\Core\Container\SingletonInterface;
use Spiral\Core\Controller;
use Spiral\Http\Response\ResponseWrapper;
use Spiral\Http\Uri;
use Spiral\Jobs\QueueInterface;
use Spiral\Views\ViewsInterface;

class MediaController extends Controller implements SingletonInterface
{
    /** @var ViewsInterface */
    private $views;

    /**
     * @param ViewsInterface $views
     */
    public function __construct(ViewsInterface $views)
    {
        $this->views = $views;
    }

    /**
     * @param QueueInterface  $queue
     * @param VideoRepository $repository
     * @return string
     */
    public function indexAction(QueueInterface $queue, VideoRepository $repository)
    {
        // index available videos
        $queue->push(new IndexJob());

        return $this->views->render('list', [
            'videos' => $repository->findSorted()
        ]);
    }

    /**
     * @param PlayRequest     $request
     * @param Transaction     $transaction
     * @param ResponseWrapper $response
     * @param QueueInterface  $queue
     * @param VideoRepository $repository
     * @return ResponseInterface
     *
     * @throws \Throwable
     */
    public function playAction(
        PlayRequest $request,
        Transaction $transaction,
        ResponseWrapper $response,
        QueueInterface $queue,
        VideoRepository $repository
    ) {
        $play = new Play();
        $play->created_at = new \DateTime();
        $play->ready = 0;

        $play->video = $repository->findByPK($request->getID());

        $play->audio = $play->video->streams->filter(function (Stream $s) use ($request) {
            return $s->index == $request->getAudio();
        })->first();

        if ($play->audio === null || $request->getAudio() === null) {
            $play->audio = $play->video->streams->filter(function (Stream $s) {
                return $s->type == 'audio';
            })->first();
        }

        $transaction->persist($play)->run();
        $queue->push(new ConvertJob([
            'playID' => $play->id
        ]));

        return $response->redirect(new Uri(
            '/watch/' . $play->id
        ));
    }

    /**
     * @param string         $id
     * @param PlayRepository $repository
     * @return string
     */
    public function watchAction(string $id, PlayRepository $repository): string
    {
        /** @var Play $play */
        $play = $repository->findByPK($id);
        if ($play->ready !== 100) {
            return $this->views->render('wait', ['play' => $play]);
        }

        return $this->views->render('play', ['play' => $play]);
    }
}