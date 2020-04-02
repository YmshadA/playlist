<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

use Dailymotion\Domain\Video;
use Dailymotion\Domain\VideoRepository;

class AddVideoCommandHandler
{
    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function addVideo(AddVideoCommand $addVideoCommand): Video
    {
        return $this->videoRepository->addVideo($addVideoCommand->getTitle(), $addVideoCommand->getThumbnail());
    }
}
