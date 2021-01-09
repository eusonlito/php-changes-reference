<?php declare(strict_types=1);

namespace App\Command;

use App\Console\Command as CommandConsole;
use App\Console\Message as MessageConsole;
use App\Html\Dom as DomHtml;
use App\Filesystem\File as FileFilesystem;

abstract class CommandAbstract
{
    /**
     * @const
     */
    protected const URL_BASE = 'https://www.php.net';

    /**
     * @const
     */
    protected const URL_DOCS = 'https://www.php.net/manual/en';

    /**
     * @const
     */
    protected const URL_DOCS_LEGACY = 'https://php-legacy-docs.zend.com/manual/php5/en';

    /**
     * @const
     */
    protected const PATH_ASSET = PATH_BASE.'/src/views/assets';

    /**
     * @const
     */
    protected const PATH_CACHE_MIGRATION = PATH_BASE.'/cache/migration';

    /**
     * @const
     */
    protected const PATH_CACHE_CHUNK = PATH_BASE.'/cache/chunk';

    /**
     * @const
     */
    protected const PATH_CACHE_REMOTE = PATH_BASE.'/cache/remote';

    /**
     * @const
     */
    protected const PATH_HTML = PATH_BASE.'/html';

    /**
     * @param string $command
     * @param ... $arguments
     *
     * @return void
     */
    protected function command(string $command, ...$arguments): void
    {
        CommandConsole::factory($command, ...$arguments);
    }

    /**
     * @param string $message
     *
     * @return void
     */
    protected function echo(string $message): void
    {
        MessageConsole::echo($message);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function removePathBase(string $path): string
    {
        return str_replace(PATH_BASE, '', $path);
    }

    /**
     * @param string $file
     *
     * @return \App\Html\Dom
     */
    protected function dom(string $file): DomHtml
    {
        return new DomHtml($this->fileRead($file));
    }

    /**
     * @param string $file
     *
     * @return string
     */
    protected function fileRead(string $file): string
    {
        return FileFilesystem::read($file);
    }

    /**
     * @param string $file
     * @param string $contents
     *
     * @return void
     */
    protected function fileWrite(string $file, string $contents): void
    {
        FileFilesystem::write($file, $contents);
    }
}
