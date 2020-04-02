<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

class AddPlaylistCommand
{
    private string $name;

    public function __construct(string $title)
    {
        $this->name = $title;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }
}
