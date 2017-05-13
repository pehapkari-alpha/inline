<?php
declare(strict_types = 1);

/*
 * This file is part of the some package.
 * (c) Jakub Janata <jakubjanata@gmail.com>
 * For the full copyright and license information, please view the LICENSE file.
 */

namespace XcoreCMS\InlineEditing\Model\PersistenceLayer;

use Nette\Database\Connection;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class NetteDatabase extends AbstractPersistenceLayer
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param string $tableName
     * @param Connection $connection
     */
    public function __construct(string $tableName, Connection $connection)
    {
        parent::__construct($tableName);
        $this->connection = $connection;
    }

    /**
     * @param string $sql
     * @param array $args
     * @return array
     */
    protected function getKeyPairResult(string $sql, array $args): array
    {
        return $this->connection->query($sql, $args[0], $args[1])->fetchPairs('name', 'content');
    }

    /**
     * @param string $sql
     * @param array $args
     * @return bool
     */
    protected function updateOrInsertRecord(string $sql, array $args): bool
    {
        return (bool) $this->connection->query($sql, $args[0], $args[1], $args[2], $args[3]);
    }

    /**
     * @return string
     */
    protected function getDriverName(): string
    {
        return $this->connection->getDsn();
    }
}
