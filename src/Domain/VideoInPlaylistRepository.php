<?php
declare(strict_types=1);

namespace Dailymotion\Domain;

use Dailymotion\Domain\Exception\PlaylistNotFoundException;

interface VideoInPlaylistRepository
{
    /**
     * @param int $videoId
     * @param int $playlistId
     *
     * @return int
     */
    public function addVideoToPlaylist(int $videoId, int $playlistId): void;

    /**
     * @param int $videoId
     * @param int $playlistId
     */
    public function removeVideoFromPlaylist(int $videoId, int $playlistId): void;

    /**
     * @param int $playlistId
     *
     * @return VideoCollection
     *
     * @throws PlaylistNotFoundException
     */
    public function getAllVideoForPlaylist(int $playlistId): VideoCollection;
}
