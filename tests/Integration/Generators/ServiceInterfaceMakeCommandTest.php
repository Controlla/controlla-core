<?php

namespace Controlla\Core\Tests\Integration\Generators;

class ServiceInterfaceMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Services/Foo/FooServiceInterface.php',
    ];

    public function testItCanGenerateRequestFile()
    {
        $this->artisan('controlla:make:serviceinterface', ['name' => 'FooServiceInterface', '--model' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Services\Foo;',
            'use Controlla\Core\Services\BaseServiceInterface;',
            'interface FooServiceInterface extends BaseServiceInterface',
        ], 'app/Services/Foo/FooServiceInterface.php');
    }
}
