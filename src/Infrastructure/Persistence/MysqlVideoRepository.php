<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Persistence;

use Dailymotion\Domain\Video;
use Dailymotion\Domain\VideoCollection;
use Dailymotion\Domain\VideoRepository;
use Dailymotion\Infrastructure\Persistence\Exception\MysqlQueryException;

class MysqlVideoRepository implements VideoRepository
{
    public function addVideo(string $title, string $thumbnail): Video
    {
        $pdo = new \PDO(
            'mysql:host=mysql;dbname=dailymotion',
            'dailymotion',
            'dailymotion'
        );

        $sql = 'INSERT INTO dailymotion.video(title, thumbnail) VALUES (:title, :thumbnail)';

        $statement = $pdo->prepare($sql);
        $res = $statement->execute([
            ':title' => $title,
            ':thumbnail' => $thumbnail
        ]);

        if (!$res) {
            throw new MysqlQueryException($statement->errorInfo()[2], $statement->errorCode());
        }

        $videoId = (int)$pdo->lastInsertId();

        return new Video($videoId, $title, $thumbnail);
    }

    public function getAllVideos(): VideoCollection
    {
        $pdo = new \PDO(
            'mysql:host=mysql;dbname=dailymotion',
            'dailymotion',
            'dailymotion'
        );

        $sql = 'SELECT id, title, thumbnail FROM dailymotion.video';

        $statement = $pdo->query($sql);

        $videos = $statement->fetchAll();

        $videoCollection = new VideoCollection();
        foreach ($videos as $video) {
            $videoCollection->add(new Video((int)$video['id'], $video['title'], $video['thumbnail']));
        }

        return $videoCollection;
    }
}
