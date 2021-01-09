<?php declare(strict_types=1);

namespace App\Command;

use App\Console\Message as MessageConsole;
use App\Filesystem\Directory as DirectoryFilesystem;

class Chunk extends CommandAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->clean();

        foreach ($this->files() as $file) {
            $this->store($file, $this->html($file));
        }
    }

    /**
     * @return void
     */
    protected function clean(): void
    {
        DirectoryFilesystem::rmdir($this->path());
    }

    /**
     * @param string $file = ''
     *
     * @return string
     */
    protected function path(string $file = ''): string
    {
        return static::PATH_CACHE_CHUNK.'/'.$file;
    }

    /**
     * @return array
     */
    protected function files(): array
    {
        return DirectoryFilesystem::files(static::PATH_CACHE_MIGRATION);
    }

    /**
     * @param string $file
     *
     * @return string
     */
    protected function html(string $file): string
    {
        $id = $this->nameFromCache($file);
        $dom = $this->dom($file);

        return $dom->toHtml($dom->queryItem('//div[@id="'.$id.'"]'));
    }

    /**
     * @param string $file
     * @param string $html
     *
     * @return void
     */
    protected function store(string $file, string $html): void
    {
        $target = $this->storeName($file);

        MessageConsole::echo(sprintf("Creating <color:green>%s</color> HTML chunk\n", $this->removePathBase($target)));

        $this->fileWrite($target, $html);
    }

    /**
     * @param string $file
     *
     * @return string
     */
    protected function nameFromCache(string $file): string
    {
        return preg_replace('/\.[a-z]+$/', '', basename(base64_decode(basename($file))));
    }

    /**
     * @param string $file
     *
     * @return string
     */
    protected function storeName(string $file): string
    {
        return $this->path($this->nameFromCache($file));
    }
}
