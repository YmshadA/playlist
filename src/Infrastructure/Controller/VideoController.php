<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Controller;

use Dailymotion\Application\Command\AddVideoCommand;
use Dailymotion\Application\Command\AddVideoCommandHandler;
use Dailymotion\Application\Command\DeleteVideoCommand;
use Dailymotion\Application\Command\DeleteVideoCommandHandler;
use Dailymotion\Application\Query\GetAllVideosHandler;
use Dailymotion\Infrastructure\Http\Request;
use Dailymotion\Infrastructure\Http\Response;
use Dailymotion\Infrastructure\Normalizer\VideoCollectionNormalizer;
use Dailymotion\Infrastructure\Normalizer\VideoNormalizer;

class VideoController
{
    use VideoCollectionNormalizer, VideoNormalizer;

    private AddVideoCommandHandler $addVideoCommandHandler;
    private GetAllVideosHandler $getAllVideosHandler;
    private DeleteVideoCommandHandler $deleteVideoCommandHandler;

    public function __construct(
        AddVideoCommandHandler $addVideoCommandHandler,
        GetAllVideosHandler $getAllVideosHandler,
        DeleteVideoCommandHandler $deleteVideoCommandHandler
    ) {
        $this->addVideoCommandHandler = $addVideoCommandHandler;
        $this->getAllVideosHandler = $getAllVideosHandler;
        $this->deleteVideoCommandHandler = $deleteVideoCommandHandler;
    }

    public function createVideoAction(Request $request): Response
    {
        $data = json_decode($request->getBody(), true);

        if (!array_key_exists('title', $data) || !array_key_exists('thumbnail', $data)) {
            $error = ['error' => 'One of this field [title, thumbnail] is missing'];
            return new Response(json_encode($error, JSON_THROW_ON_ERROR), Response::STATUS_BAD_REQUEST);
        }

        $video = $this->addVideoCommandHandler->addVideo(new AddVideoCommand($data['title'], $data['thumbnail']));

        return new Response(
            json_encode([
                'data' => $this->normalizeVideo($video)
            ], JSON_THROW_ON_ERROR),
            Response::STATUS_CREATED
        );
    }

    public function getVideosAction(Request $request): Response
    {
        $videos = $this->getAllVideosHandler->getAllVideos();

        return new Response(
            json_encode([
                'data' => $this->normalizeVideoCollection($videos)
            ], JSON_THROW_ON_ERROR),
            Response::STATUS_OK
        );
    }

    public function deleteVideoAction(Request $request, int $videoId): Response
    {
        $this->deleteVideoCommandHandler->deleteVideo(new DeleteVideoCommand($videoId));

        return new Response('', Response::STATUS_NO_CONTENT);
    }
}
