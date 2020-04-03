<?php
declare(strict_types=1);

namespace Dailymotion\Domain;

/**
 * This class represents what is a Playlist, without any infrastructure informations.
 *
 * Class Playlist
 * @package Dailymotion\Domain
 */
class Playlist
{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getName():string
    {
        return $this->name;
    }
}
