<?php

namespace DTO;

use App\DTO\Task\ListDTO;
use App\Http\Requests\Task\IndexRequest;
use PHPUnit\Framework\Attributes\Test;
use Tests\Helpers\MakesFormRequests;
use Tests\TestCase;

class ListTest extends TestCase
{


    use MakesFormRequests;


    public function test_creates_dto_with_expected_data(): void
    {
        $request = $this->makeFormRequest(IndexRequest::class, [
            'per_page' => 50,
            'is_completed' => true,
            'sort_by' => 'title',
            'sort_order' => 'desc',
        ]);

        $dto = ListDTO::fromRequest($request);

        $this->assertSame(50, $dto->perPage);
        $this->assertTrue($dto->isCompleted);
        $this->assertTrue($dto->filterByStatus);
        $this->assertSame('title', $dto->sortBy);
        $this->assertSame('desc', $dto->sortOrder);
    }

    public function test_creates_dto_with_defaults(): void
    {
        $request = $this->makeFormRequest(IndexRequest::class, []);

        $dto = ListDTO::fromRequest($request);

        $this->assertSame(25, $dto->perPage); // значение по умолчанию в IndexRequest
        $this->assertFalse($dto->filterByStatus);
        $this->assertFalse($dto->isCompleted);
        $this->assertSame('id', $dto->sortBy);
        $this->assertSame('asc', $dto->sortOrder);
    }

}
