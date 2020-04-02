<?php
declare(strict_types=1);

namespace Dailymotion\Application\Query;

use Dailymotion\Domain\VideoCollection;
use Dailymotion\Domain\VideoRepository;

class GetAllVideosHandler
{
    /** @var VideoRepository */
    private $videosRepository;

    public function __construct(VideoRepository $videosRepository)
    {
        $this->videosRepository = $videosRepository;
    }

    public function getAllVideos(): VideoCollection
    {
        return $this->videosRepository->getAllVideos();
    }
}
