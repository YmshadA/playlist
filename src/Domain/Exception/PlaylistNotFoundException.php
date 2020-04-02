<?php
declare(strict_types=1);

namespace Dailymotion\Domain\Exception;

class PlaylistNotFoundException extends \RuntimeException
{
    public function __construct(int $playlistId)
    {
        parent::__construct("Playlist $playlistId not found");
    }
}
