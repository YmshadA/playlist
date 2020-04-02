<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

class DeleteVideoCommand
{
    private int $videoId;

    public function __construct(int $videoId)
    {
        $this->videoId = $videoId;
    }

    /**
     * @return int
     */
    public function getVideoId():int
    {
        return $this->videoId;
    }
}
