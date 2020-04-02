<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

class AddVideoToPlaylistCommand
{
    private int $videoId;
    private int $playlistId;

    public function __construct(int $videoId, int $playlistId)
    {
        $this->videoId = $videoId;
        $this->playlistId = $playlistId;
    }

    /**
     * @return int
     */
    public function getVideoId():int
    {
        return $this->videoId;
    }

    /**
     * @return int
     */
    public function getPlaylistId():int
    {
        return $this->playlistId;
    }
}