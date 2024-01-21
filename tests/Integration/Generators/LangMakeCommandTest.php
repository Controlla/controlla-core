<?php

namespace Controlla\Core\Tests\Integration\Generators;

class LangMakeCommandTest extends TestCase
{
    protected $files = [
        'resources/lang/es/foos.php',
    ];

    public function testItCanGenerateRequestFile()
    {
        $this->artisan('controlla:make:lang', ['name' => 'foo', '--model' => 'Foo', '--lang' => 'es'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'add' => 'Agregar foo',
        ], 'resources/lang/es/foos.php');
    }
}
