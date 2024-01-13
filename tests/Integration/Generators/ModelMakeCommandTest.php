<?php

namespace Controlla\Core\Tests\Integration\Generators;

class ModelMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Models/Foo.php',
        'app/Models/Foo/Bar.php',
        'app/Http/Controllers/FooController.php',
        'app/Http/Controllers/BarController.php',
        'database/factories/FooFactory.php',
        'database/seeders/FooSeeder.php',
        'tests/Feature/Models/FooTest.php',
    ];

    public function testItCanGenerateModelFile()
    {
        $this->artisan('make:model', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
        $this->assertFilenameNotExists('tests/Feature/Models/FooTest.php');
    }

    public function testItCanGenerateModelFileWithFactoryOption()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--factory' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    public function testItCanGenerateModelFileWithMigrationOption()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--migration' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'foos\', function (Blueprint $table) {',
            'Schema::dropIfExists(\'foos\');',
        ], 'create_foos_table.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    public function testItCanGenerateModelFileWithSeederption()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--seed' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameExists('database/seeders/FooSeeder.php');
    }
}
