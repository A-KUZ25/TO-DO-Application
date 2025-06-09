<?php

namespace DTO;

use App\DTO\Task\CreateDTO;
use App\Http\Requests\Task\SaveRequest;
use Tests\Helpers\MakesFormRequests;
use Tests\TestCase;

class CreateTest extends TestCase
{

    use MakesFormRequests;

    public function test_creates_dto_from_request(): void
    {
        $request = $this->makeFormRequest(SaveRequest::class, [
            'title' => 'New Task',
            'description' => null,
            'is_completed' => true,
        ]);

        $dto = CreateDTO::fromRequest($request);

        $this->assertSame('New Task', $dto->title);
        $this->assertNull($dto->description);
        $this->assertTrue($dto->isCompleted);
    }

}
