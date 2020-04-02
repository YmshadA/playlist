<?php

namespace Dailymotion\Domain;

use Dailymotion\Domain\Exception\PlaylistNotFoundException;

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
     *
     * @return Playlist
     *
     * @throws PlaylistNotFoundException
     */
    public function getPlaylist(int $playlistId): Playlist;

    /**
     * @param int $playlistId
     */
    public function deletePlaylist(int $playlistId): void;

    /**
     * @param int    $playlistId
     * @param string $name
     */
    public function updatePlaylist(int $playlistId, string $name): void;
}
