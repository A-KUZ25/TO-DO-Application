<?php

namespace DTO;

use App\DTO\Task\UpdateDTO;
use App\Http\Requests\Task\SaveRequest;
use Tests\Helpers\MakesFormRequests;
use Tests\TestCase;

class UpdateTest extends TestCase
{

    use MakesFormRequests;

    public function test_creates_dto_from_request(): void
    {
        $request = $this->makeFormRequest(SaveRequest::class, [
            'title' => 'New Task',
            'description' => null,
            'is_completed' => true,
        ]);

        $dto = UpdateDTO::fromRequest($request);

        $this->assertEquals('New Task', $dto->title);
        $this->assertNull($dto->description);
        $this->assertTrue($dto->isCompleted);
        $this->assertTrue($dto->hasDescription); // Поле было передано
    }


    public function test_handles_missing_description(): void
    {
        $request = $this->makeFormRequest(SaveRequest::class, [
            'title' => 'New Task',
            'is_completed' => true,
            //нет поля description
        ]);

        $request->validateResolved();
        $dto = UpdateDTO::fromRequest($request);

        $this->assertFalse($dto->hasDescription); // Поле не передавалось
    }


    public function test_converts_to_update_array_correctly(): void
    {
        // Сценарий 1: description явно null (стереть)
        $dto1 = new UpdateDTO(
            title: 'Task',
            description: null,
            isCompleted: true,
            hasDescription: true
        );
        $this->assertEquals(
            ['title' => 'Task', 'description' => null, 'is_completed' => true],
            $dto1->toUpdateArray()
        );

        // Сценарий 2: description не передавался (не трогать)
        $dto2 = new UpdateDTO(
            title: 'Task',
            description: null,
            isCompleted: true,
            hasDescription: false
        );
        $this->assertEquals(
            ['title' => 'Task', 'is_completed' => true],
            $dto2->toUpdateArray()
        );
    }
    /**
     * @param array<string, mixed> $data
     */
    public function createSaveRequest(array $data): SaveRequest
    {
        $request = SaveRequest::create('/fake-url', 'POST', $data);
        $request->setContainer(app())->setRedirector(app('redirect'));
        $request->validateResolved();

        return $request;
    }
}
