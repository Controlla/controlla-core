<?php

namespace Controlla\Core\Tests\Integration\Generators;

class RequestMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Requests/Foo/FooStoreRequest.php',
    ];

    public function testItCanGenerateRequestFile()
    {
        $this->artisan('component:request', ['name' => 'FooStoreRequest', '--model' => 'Foo', '--type' => 'Store'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Requests\Foo;',
            'use Illuminate\Foundation\Http\FormRequest;',
            'class FooStoreRequest extends FormRequest',
        ], 'app/Http/Requests/Foo/FooStoreRequest.php');
    }
}
