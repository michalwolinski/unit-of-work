<?php

namespace MichalWolinski\UnitOfWork\Interfaces;

use Illuminate\Database\Eloquent\Model;
use MichalWolinski\UnitOfWork\Exceptions\UnitOfWorkException;

/**
 * Interface UnitOfWorkInterface
 * @package MichalWolinski\UnitOfWork\Interfaces
 */
interface UnitOfWorkInterface
{
    /**
     * @param Model $model
     */
    public function insert(Model $model): void;

    /**
     * @param Model $model
     */
    public function update(Model $model): void;

    /**
     * @param Model $model
     */
    public function delete(Model $model): void;

    /**
     *
     */
    public function clear(): void;

    /**
     * @return bool
     * @throws UnitOfWorkException
     */
    public function commit(): bool;
}