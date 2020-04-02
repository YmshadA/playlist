<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

class AddVideoCommand
{
    private string $title;
    private string $thumbnail;

    public function __construct(string $title, string $thumbnail)
    {
        $this->title = $title;
        $this->thumbnail = $thumbnail;
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
