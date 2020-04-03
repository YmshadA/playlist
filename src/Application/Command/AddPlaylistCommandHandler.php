<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

use Dailymotion\Domain\Playlist;
use Dailymotion\Domain\PlaylistRepository;

/**
 * This class handle the AddPlaylistCommand, and knows what to do with that command.
 * In this case, it is very simple.
 *
 * Class AddPlaylistCommandHandler
 * @package Dailymotion\Application\Command
 */
class AddPlaylistCommandHandler
{
    private PlaylistRepository $playlistRepository;

    public function __construct(PlaylistRepository $playlistRepository)
    {
        $this->playlistRepository = $playlistRepository;
    }

    public function addPlaylist(AddPlaylistCommand $addPlaylistCommand): Playlist
    {
        return $this->playlistRepository->addPlaylist($addPlaylistCommand->getName());
    }
}
