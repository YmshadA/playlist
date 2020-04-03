<?php

namespace Dailymotion\Domain;

use Dailymotion\Domain\Exception\PlaylistNotFoundException;

/**
 * This interface lists all the possibilities about a Playlist. It is used in Application layer.
 * So the Application and Domain layer does not know about the concrete implementation.
 *
 * Interface PlaylistRepository
 * @package Dailymotion\Domain
 */
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
     *
     * @return Playlist
     */
    public function updatePlaylist(int $playlistId, string $name): Playlist;
}
