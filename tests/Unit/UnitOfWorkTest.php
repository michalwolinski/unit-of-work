<?php

namespace MichalWolinski\UnitOfWork\Tests\Unit;

use Illuminate\Database\DatabaseManager;
use MichalWolinski\UnitOfWork\Exceptions\UnitOfWorkException;
use MichalWolinski\UnitOfWork\Tests\TestCase;
use MichalWolinski\UnitOfWork\Tests\TestModel;
use MichalWolinski\UnitOfWork\UnitOfWork;
use Mockery;


/**
 * Class UnitOfWorkTest
 * @package MichalWolinski\UnitOfWork\Tests\Unit
 */
class UnitOfWorkTest extends TestCase
{
    /**
     * @var UnitOfWork
     */
    private UnitOfWork $unitOfWork;
    /**
     * @var TestModel|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $model;

    /**
     *
     */
    protected function setUp(): void
    {
        $db = Mockery::mock(DatabaseManager::class);
        $db->shouldReceive('transaction')->andReturn(true);
        $this->unitOfWork = new UnitOfWork($db);
        $this->model      = Mockery::mock(TestModel::class);
        $this->model->shouldReceive('save')->andReturn(true);
        $this->model->shouldReceive('delete')->andReturn(true);
    }

    /**
     * @test
     * @throws UnitOfWorkException
     */
    public function it_can_insert()
    {
        $this->unitOfWork->insert($this->model);
        $result = $this->unitOfWork->commit();

        $this->assertEquals(true, $result);
    }

    /**
     * @test
     * @throws UnitOfWorkException
     */
    public function it_can_update()
    {
        $this->unitOfWork->update($this->model);
        $result = $this->unitOfWork->commit();

        $this->assertEquals(true, $result);
    }

    /**
     * @test
     * @throws UnitOfWorkException
     */
    public function it_can_delete()
    {
        $this->unitOfWork->delete($this->model);
        $result = $this->unitOfWork->commit();

        $this->assertEquals(true, $result);
    }
}