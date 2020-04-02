<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Controller;

use Dailymotion\Application\Command\AddVideoCommand;
use Dailymotion\Application\Command\AddVideoCommandHandler;
use Dailymotion\Application\Query\GetAllVideosHandler;
use Dailymotion\Domain\Video;
use Dailymotion\Domain\VideoCollection;
use Dailymotion\Infrastructure\Http\Request;
use Dailymotion\Infrastructure\Http\Response;

class VideoController
{
    private AddVideoCommandHandler $addVideoCommandHandler;
    private GetAllVideosHandler $getAllVideosHandler;

    public function __construct(
        AddVideoCommandHandler $addVideoCommandHandler,
        GetAllVideosHandler $getAllVideosHandler
    ) {
        $this->addVideoCommandHandler = $addVideoCommandHandler;
        $this->getAllVideosHandler = $getAllVideosHandler;
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

    private function normalizeVideoCollection(VideoCollection $videoCollection): array
    {
        $normalizedVideos = [];

        foreach ($videoCollection as $video) {
            $normalizedVideos[] = $this->normalizeVideo($video);
        }

        return $normalizedVideos;
    }

    private function normalizeVideo(Video $video): array
    {
        return [
            'id' => $video->getId(),
            'title' => $video->getTitle(),
            'thumbnail' => $video->getThumbnail(),
        ];
    }
}
