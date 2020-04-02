<?php

namespace Dailymotion\Domain;

interface PlaylistRepository
{
    /**
     * @param string $name
     *
     * @return Playlist
     */
    public function addPlaylist(string $name): Playlist;

    /**
     * @return PlaylistCollection
     */
    public function getAllPlaylist(): PlaylistCollection;

    /**
     * @param int $playlistId
     */
    public function deletePlaylist(int $playlistId): void;
}