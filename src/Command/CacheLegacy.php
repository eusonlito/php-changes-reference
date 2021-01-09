<?php declare(strict_types=1);

namespace App\Command;

use Generator;
use App\Console\Message as MessageConsole;
use App\Filesystem\Directory as DirectoryFilesystem;

class CacheLegacy extends CommandAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        foreach ($this->urls() as $url) {
            $this->store($url);
        }
    }

    /**
     * @param string $file = ''
     *
     * @return string
     */
    protected function path(string $file = ''): string
    {
        return static::PATH_CACHE_MIGRATION.'/'.$file;
    }

    /**
     * @param string $path = ''
     *
     * @return string
     */
    protected function url(string $path = ''): string
    {
        return static::URL_DOCS_LEGACY.'/'.$path;
    }

    /**
     * @return \Generator
     */
    protected function urls(): Generator
    {
        $dom = $this->dom($this->url('appendices'));

        foreach ($dom->query('//div[@id="appendices"]/ul/li/ul/li/a') as $node) {
            $href = $node->getAttribute('href');

            if (strpos($href, 'migration') === 0) {
                yield $this->url($href);
            }
        }
    }

    /**
     * @param string $url
     *
     * @return void
     */
    protected function store(string $url): void
    {
        $target = $this->target($url);

        MessageConsole::echo(sprintf("Downloading <color:green>%s</color> into <color:green>%s</color>\n", $url, $this->removePathBase($target)));

        $this->fileWrite($target, $this->html($url));
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function html(string $url): string
    {
        return str_replace('href="', 'target="_blank" href="'.$this->url(), $this->fileRead($url));
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function target(string $url): string
    {
        return $this->path(base64_encode($url));
    }
}
