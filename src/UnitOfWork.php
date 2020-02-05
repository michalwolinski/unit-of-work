<?php

namespace MichalWolinski\UnitOfWork;

use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use MichalWolinski\UnitOfWork\Exceptions\UnitOfWorkException;
use MichalWolinski\UnitOfWork\Interfaces\UnitOfWorkInterface;
use Throwable;

/**
 * Class UnitOfWork
 * @package MichalWolinski\UnitOfWork
 */
class UnitOfWork implements UnitOfWorkInterface
{
    /**
     * @var array
     */
    private array $insertions = [];
    /**
     * @var array
     */
    private array $updates = [];
    /**
     * @var array
     */
    private array $deletions = [];
    /**
     * @var DatabaseManager
     */
    private DatabaseManager $databaseManager;

    /**
     * UnitOfWork constructor.
     *
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * @param Model $model
     */
    public function insert(Model $model): void
    {
        $this->insertions[] = $model;
    }

    /**
     * @param Model $model
     */
    public function update(Model $model): void
    {
        $this->updates[] = $model;
    }

    /**
     * @param Model $model
     */
    public function delete(Model $model): void
    {
        $this->deletions[] = $model;
    }

    /**
     *
     */
    public function clear(): void
    {
        $this->insertions = [];
        $this->updates    = [];
        $this->deletions  = [];
    }

    /**
     * @return bool
     * @throws UnitOfWorkException
     */
    public function commit(): bool
    {
        try {
            return $this->databaseManager->transaction(function () {
                $this->doInsert();
                $this->doUpdate();
                $this->doDelete();
                $this->clear();

                return true;
            });
        } catch (Throwable $e) {
            try {
                $this->databaseManager->rollBack();

                return false;
            } catch (Exception $e){
                throw new UnitOfWorkException($e->getMessage());
            }
        }
    }

    /**
     *
     */
    private function doInsert(): void
    {
        /** @var Model $insertion */
        foreach ($this->insertions as $insertion) {
            $insertion->save();
        }
    }

    /**
     *
     */
    private function doUpdate(): void
    {
        /** @var Model $update */
        foreach ($this->updates as $update) {
            $update->save();
        }
    }

    /**
     * @throws Exception
     */
    private function doDelete(): void
    {
        /** @var Model $deletion */
        foreach ($this->deletions as $deletion) {
            $deletion->delete();
        }
    }
}