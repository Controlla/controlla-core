<?php

namespace Controlla\Core\Tests\Integration\Generators;

class RepositoryMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Repositories/Foo/FooRepository.php',
    ];

    public function testItCanGenerateRequestFile()
    {
        $this->artisan('component:repository', ['name' => 'FooRepository', '--model' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Repositories\Foo;',
            'use Illuminate\Http\Request;',
            'use App\Models\Foo;',
            'use App\Http\Filters\QueryBuilder;',
            'class FooRepository implements FooRepositoryInterface',
        ], 'app/Repositories/Foo/FooRepository.php');
    }
}
