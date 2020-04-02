<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

class UpdatePlaylistCommand
{
    private int $playlistId;
    private string $name;

    public function __construct(int $playlistId, string $name)
    {
        $this->playlistId = $playlistId;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPlaylistId(): int
    {
        return $this->playlistId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
