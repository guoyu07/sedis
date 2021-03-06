<?php

namespace Sedis\Structure;

use ArrayIterator;
use Sedis\Response;
use Sedis\Service;

class Sets extends AbstractStructure
{
    public static $commands = ['sadd', 'scard', 'sismember', 'srem'];

    public function sadd($fd, $data)
    {
        if (count($data) !== 2)
            return Response::wrongNumber(__METHOD__);

        if (!Service::$keys->offsetExists($data[0])) {
            Service::$keys[$data[0]] = new ArrayIterator();
        }

        $instance = Service::$keys[$data[0]];

        $count = $instance->count();

        $instance[$data[1]] = true;

        return Response::int($instance->count() - $count);
    }

    public function scard($fd, $data)
    {
        $instance = Service::$keys[$data[0]];

        return Response::int($instance->count());
    }

    public function sismember($fd, $data)
    {
        if (count($data) !== 2)
            return Response::wrongNumber(__METHOD__);

        $instance = Service::$keys[$data[0]];

        return Response::int($instance->offsetExists($data[1]));
    }

    public function srem($fd, $data)
    {
        if (count($data) < 1) {
            return Response::wrongNumber(__METHOD__);
        }

        $instance = Service::$keys[$data[0]];
    }
}
