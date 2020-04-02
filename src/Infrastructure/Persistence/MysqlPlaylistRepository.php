<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Persistence;

use Dailymotion\Domain\Playlist;
use Dailymotion\Domain\PlaylistCollection;
use Dailymotion\Domain\PlaylistRepository;
use Dailymotion\Infrastructure\Persistence\Exception\MysqlQueryException;

class MysqlPlaylistRepository implements PlaylistRepository
{
    public function addPlaylist(string $name): Playlist
    {
        $pdo = $this->getPDO();

        $sql = 'INSERT INTO dailymotion.playlist(name) VALUES (:name)';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':name' => $name,
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }

        $playlistId = (int)$pdo->lastInsertId();

        return new Playlist($playlistId, $name);
    }

    public function getAllPlaylist(): PlaylistCollection
    {
        $pdo = $this->getPDO();

        $sql = 'SELECT id, name FROM dailymotion.playlist';

        $statement = $pdo->query($sql);

        $playlists = $statement->fetchAll();

        $playlistCollection = new PlaylistCollection();
        foreach ($playlists as $playlist) {
            $playlistCollection->add(new Playlist((int)$playlist['id'], $playlist['name']));
        }

        return $playlistCollection;
    }

    public function deletePlaylist(int $playlistId):void
    {
        $pdo = $this->getPDO();

        $sql = 'DELETE FROM dailymotion.playlist WHERE id = :id';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':id' => $playlistId
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }
    }

    private function getPDO(): \PDO
    {
        return new \PDO(
            'mysql:host=mysql;dbname=dailymotion',
            'dailymotion',
            'dailymotion'
        );
    }
}
