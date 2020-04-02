<?php
declare(strict_types=1);

namespace Dailymotion\Domain;

class PlaylistCollection implements \IteratorAggregate
{
    /** @var Playlist[] */
    private array $playlists = [];

    public function add(Playlist $playlist)
    {
        $this->playlists[] = $playlist;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->playlists);
    }
}
