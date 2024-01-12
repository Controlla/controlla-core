<?php

namespace Controlla\Core\Tests\Integration\Generators;

class ServiceMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Services/Foo/FooService.php',
    ];

    public function testItCanGenerateRequestFile()
    {
        $this->artisan('component:service', ['name' => 'FooService', '--model' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Services\Foo;',
            'use App\Repositories\Foo\FooRepositoryInterface;',
            'use Controlla\Core\Services\BaseService;',
            'class FooService extends BaseService implements FooServiceInterface',
        ], 'app/Services/Foo/FooService.php');
    }
}
