<?php declare(strict_types=1);

namespace PeeHaa\ArrayPath;

class ArrayPath
{
    private $delimiter;

    public function __construct($delimiter = '.')
    {
        $this->delimiter = $delimiter;
    }

    public function get(array $source, string $path)
    {
        $keys = explode($this->delimiter, $path);

        $currentSource = $source;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $currentSource)) {
                throw new NotFoundException();
            }

            $currentSource = $currentSource[$key];
        }

        return $currentSource;
    }

    public function set(array &$source, string $path, $value): void
    {
        $keys = explode($this->delimiter, $path);

        $currentSource = &$source;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $currentSource)) {
                $currentSource[$key] = [];
            }

            $currentSource = &$currentSource[$key];
        }

        $currentSource = $value;
    }

    public function exists(array $source, string $path): bool
    {
        try {
            $this->get($source, $path);
        } catch (NotFoundException $e) {
            return false;
        }

        return true;
    }

    public function remove(array &$source, string $path): void
    {
        $keys = explode($this->delimiter, $path);

        $lastKey = array_pop($keys);

        $currentSource = &$source;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $currentSource)) {
                return;
            }

            $currentSource = &$currentSource[$key];
        }

        unset($currentSource[$lastKey]);
    }
}
