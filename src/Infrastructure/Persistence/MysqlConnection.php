<?php
declare(strict_types=1);

namespace Dailymotion\Infrastructure\Persistence;

class MysqlConnection
{
    private string $hostname;
    private string $dbname;
    private string $username;
    private string $password;

    private bool $isConnected = false;
    private \PDO $pdo;

    /**
     * @param string $hostname
     * @param string $dbname
     * @param string $username
     * @param string $password
     */
    public function __construct(string $hostname, string $dbname, string $username, string $password)
    {
        $this->hostname = $hostname;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function getPDO(): \PDO
    {
        if ($this->isConnected) {
            return $this->pdo;
        }

        $this->pdo = new \PDO(
            sprintf('mysql:host=%s;dbname=%s', $this->hostname, $this->dbname),
            $this->username,
            $this->password,
            [
                \PDO::ATTR_TIMEOUT => 1,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]
        );

        $this->isConnected = true;

        return $this->pdo;
    }
}
