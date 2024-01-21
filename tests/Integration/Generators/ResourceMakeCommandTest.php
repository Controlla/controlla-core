<?php

namespace Controlla\Core\Tests\Integration\Generators;

class ResourceMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Resources/Foo/FooResource.php',
    ];

    public function testItCanGenerateRequestFile()
    {
        $this->artisan('controlla:make:resource', ['name' => 'FooResource', '--model' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Resources\Foo;',
            'use Illuminate\Http\Request;',
            'use Illuminate\Http\Resources\Json\JsonResource;',
            'class FooResource extends JsonResource',
        ], 'app/Http/Resources/Foo/FooResource.php');
    }
}
