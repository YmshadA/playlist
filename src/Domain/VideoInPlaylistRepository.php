<?php
declare(strict_types=1);

namespace Dailymotion\Domain;

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
}
