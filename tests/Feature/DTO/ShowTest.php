<?php

namespace DTO;

use App\DTO\Task\ShowDTO;
use Illuminate\Http\Request;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_creates_dto_with_with_relations_true(): void
    {
        $request = Request::create('/fake-url?with_relations=1', 'GET');

        $dto = ShowDTO::fromRequest(42, $request);

        $this->assertSame(42, $dto->taskId);
        $this->assertTrue($dto->withRelations);
    }

    public function test_dto_with_with_relations_false_by_default(): void
    {
        $request = Request::create('/fake-url', 'GET');

        $dto = ShowDTO::fromRequest(99, $request);

        $this->assertSame(99, $dto->taskId);
        $this->assertFalse($dto->withRelations);
    }
}
