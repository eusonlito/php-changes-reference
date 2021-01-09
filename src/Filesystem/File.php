<?php declare(strict_types=1);

namespace App\Filesystem;

class File
{
    /**
     * @const
     */
    protected const PATH_CACHE = PATH_BASE.'/cache/remote';

    /**
     * @param string $file
     *
     * @return string
     */
    public static function read(string $file): string
    {
        $remote = static::isRemote($file);
        $cached = static::cached($file);

        if ($remote && static::isCached($file)) {
            $file = $cached;
        }

        $contents = file_get_contents($file);

        if ($remote) {
            static::write($cached, $contents);
        }

        return $contents;
    }

    /**
     * @param string $file
     * @param string $contents
     *
     * @return void
     */
    public static function write(string $file, string $contents): void
    {
        Directory::mkdir(dirname($file));

        if (static::isRemote($contents)) {
            $contents = static::read($contents);
        }

        file_put_contents($file, $contents, LOCK_EX);
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    protected static function isRemote(string $file): bool
    {
        return strpos($file, 'http') === 0;
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    protected static function isCached(string $file): bool
    {
        return is_file(static::cached($file));
    }

    /**
     * @param string $file
     *
     * @return string
     */
    protected static function cached(string $file): string
    {
        return static::PATH_CACHE.'/'.base64_encode($file);
    }
}
