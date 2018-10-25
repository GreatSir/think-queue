<?php
/**
 * Created by PhpStorm.
 * User: greatsir
 * Date: 2018/10/25
 * Time: 上午9:59
 */
namespace think\queue\connector\message;

class PushMessage
{
    private $tag;
    private $key;
    private $body;
    private $time;

    public function __construct()
    {
        $this->time = time()*1000;
    }
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->$name = $value;
    }

    public function __get($name)
    {
        if (property_exists(static::class, $name)) {
            return $this->$name;
        }

        return null;
    }
}