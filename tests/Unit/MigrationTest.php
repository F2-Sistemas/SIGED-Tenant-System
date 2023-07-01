<?php

namespace Tests\Unit;

use Tests\TestCase;
use Symfony\Component\Finder\Finder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function testMigrationsHaveUpAndDownMethods()
    {
        $this->assertTrue(
            $this->hasMigrationMethods('up', 'down'),
            'Some migrations do not have up and down methods.'
        );
    }

    private function hasMigrationMethods(...$methods)
    {
        $migrations = $this->getMigrations();

        $verified = [];

        foreach ($migrations as $migration) {
            if (in_array($migration, $verified, true)) {
                continue;
            }

            $verified[] = $migration;
            $fileContents = file_get_contents($migration);

            $migrationBasename = pathinfo($migration, PATHINFO_BASENAME);

            foreach ($methods as $method) {
                $hasNoMethod = !preg_match('/public\s+function\s+' . $method . '\s*\(/', $fileContents);

                $this->assertTrue(
                    !$hasNoMethod,
                    "[{$migrationBasename}] does not have public [{$method}] method."
                );
            }
        }

        return true;
    }

    private function getMigrations()
    {
        // https://symfony.com/doc/current/components/finder.html#usage
        $finder = new Finder();

        $finder->name('*.php');

        // find all files in the current directory
        $finder->files()->in(database_path('migrations'));

        // check if there are any search results
        if (!$finder->hasResults()) {
            return [];
        }

        foreach ($finder as $file) {
            $migrations[] = $file->getRealPath();
        }

        return $migrations ?? [];
    }
}
