<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

class DeletePlaylistCommand
{
    private int $playlistId;

    public function __construct(int $playlistId)
    {
        $this->playlistId = $playlistId;
    }

    /**
     * @return int
     */
    public function getPlaylistId():int
    {
        return $this->playlistId;
    }
}
