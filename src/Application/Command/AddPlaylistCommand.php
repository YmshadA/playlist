<?php
declare(strict_types=1);

namespace Dailymotion\Application\Command;

/**
 * This class represents the intention of the user, and what it should be handled.
 *
 * Class AddPlaylistCommand
 * @package Dailymotion\Application\Command
 */
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
