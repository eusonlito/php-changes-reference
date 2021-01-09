<?php declare(strict_types=1);

namespace App\Command;

use App\Filesystem\Directory as DirectoryFilesystem;

class Cache extends CommandAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->clean();

        $this->command('CacheLegacy');
        $this->command('CacheCurrent');
    }

    /**
     * @return void
     */
    protected function clean(): void
    {
        $this->rmdir(static::PATH_CACHE_REMOTE);
        $this->rmdir(static::PATH_CACHE_MIGRATION);
    }

    /**
     * @param string $path
     *
     * @return void
     */
    protected function rmdir(string $path): void
    {
        DirectoryFilesystem::rmdir($path);
    }
}
