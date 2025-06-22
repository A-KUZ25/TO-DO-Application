<?php

namespace Tests\Helpers;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Redirector;

trait MakesFormRequests
{
    /**
     * Создает и инициализирует FormRequest как в реальном HTTP-запросе
     *
     * @template T of FormRequest
     * @param class-string<T> $formRequestClass
     * @param array<string, mixed> $data
     * @param string $method
     * @param string $uri
     * @return T
     *
     */
    public function makeFormRequest(string $formRequestClass, array $data = [], string $method = 'POST', string $uri = '/fake-url'): FormRequest
    {
        /** @var FormRequest $request */
        $request = $formRequestClass::create($uri, $method, $data);
        $request->setContainer(app())->setRedirector(app(Redirector::class));
        $request->validateResolved();


        return $request;
    }
}
