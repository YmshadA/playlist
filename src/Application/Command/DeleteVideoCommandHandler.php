<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

use Dailymotion\Domain\Video;
use Dailymotion\Domain\VideoRepository;

class DeleteVideoCommandHandler
{
    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function deleteVideo(DeleteVideoCommand $deleteVideoCommand): void
    {
        $this->videoRepository->deleteVideo($deleteVideoCommand->getVideoId());
    }
}
