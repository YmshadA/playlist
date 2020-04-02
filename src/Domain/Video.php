<?php
declare(strict_types=1);

namespace Dailymotion\Domain;

class Video
{
    private int $id;
    private string $title;
    private string $thumbnail;

    public function __construct(int $id, string $title, string $thumbnail)
    {
        $this->id = $id;
        $this->title = $title;
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle():string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getThumbnail():string
    {
        return $this->thumbnail;
    }
}
