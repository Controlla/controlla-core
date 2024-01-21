<?php

namespace Controlla\Core\Tests\Integration\Generators;

class ControllerMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Controllers/Resources/FooController.php',
    ];

    public function testItCanGenerateRequestFile()
    {
        $this->artisan('controlla:make:controller', ['name' => 'FooController', '--model' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers\Resources;',
            'class FooController extends Controller',
        ], 'app/Http/Controllers/Resources/FooController.php');
    }
}
