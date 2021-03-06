<?php
/**
 * Copyright (c) 2017 Josh P (joshp.xyz).
 */

namespace J0sh0nat0r\SimpleCache;

/**
 * A static wrapper around a SimpleCache instance (e.g for a global cache).
 *
 * @method  static bool|array  store(string|array $key, mixed $value, int $time = null)
 * @method  static mixed       remember(string $key, int $time, \Closure $generate, mixed $default = null)
 * @method  static bool|array  forever(string|array $key, mixed $value = null)
 * @method  static bool|array  has(string|string[] $key)
 * @method  static mixed       get(string|string[] $key, mixed $default)
 * @method  static mixed       pull(string|string[] $key, mixed $default)
 * @method  static bool|array  remove(string|string[] $key)
 * @method  static bool        clear()
 *
 * @category  Class
 *
 * @author    Josh P
 */
class StaticFacade
{
    /**
     * Cache instance for the static facade.
     *
     * @var Cache
     */
    private static $cache;

    /**
     * Handle static calls and proxy them to $cache.
     *
     * @param string     $name      Name of the function being called
     * @param array|null $arguments Arguments passed ot the function being called
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        self::_checkBound();

        if (method_exists(self::$cache, $name)) {
            return call_user_func_array([self::$cache, $name], $arguments);
        }
    }

    /**
     * Bind the StaticFacade to a SimpleCache instance.
     *
     * @param Cache $cache The SimpleCache instance to bind to
     */
    public static function bind($cache)
    {
        self::$cache = $cache;
    }

    /**
     * Checks if the StaticFacade has been bound to a SimpleCache instance,
     * and, if not, an exception will be thrown.
     *
     * @throws \Exception
     *
     * @return void
     */
    private static function _checkBound()
    {
        if (!isset(self::$cache)) {
            throw new \Exception(
                'Please bind StaticFacade to a SimpleCache instance with setCache'
            );
        }
    }
}
