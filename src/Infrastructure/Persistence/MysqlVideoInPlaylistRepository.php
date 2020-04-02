<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Persistence;

use Dailymotion\Domain\VideoInPlaylistRepository;
use Dailymotion\Infrastructure\Persistence\Exception\MysqlQueryException;

class MysqlVideoInPlaylistRepository implements VideoInPlaylistRepository
{
    public function removeVideoFromPlaylist(int $videoId, int $playlistId):void
    {
        $pdo = $this->getPDO();

        $sql = 'DELETE FROM dailymotion.video_playlist 
                WHERE playlist_id = :playlist_id
                AND video_id = :video_id';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':video_id' => $videoId,
            ':playlist_id' => $playlistId,
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }
    }

    public function addVideoToPlaylist(int $videoId, int $playlistId): void
    {
        $pdo = $this->getPDO();

        $nextPosition = $this->getNextPositionFor($pdo, $playlistId);

        $sql = 'INSERT INTO dailymotion.video_playlist(video_id, playlist_id, position) 
                VALUES (:video_id, :playlist_id, :position)';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':video_id' => $videoId,
            ':playlist_id' => $playlistId,
            ':position' => $nextPosition,
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }
    }

    private function getNextPositionFor(\PDO $pdo, int $playlistId): int
    {
        $sql = 'select
                CASE
                    WHEN max(position) is null THEN 1
                    ELSE max(position) + 1
                END as next_position
                from dailymotion.video_playlist
                where playlist_id = :playlist_id';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':playlist_id' => $playlistId,
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }

        $nextPosition = $statement->fetch();

        return (int)$nextPosition['next_position'];
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
