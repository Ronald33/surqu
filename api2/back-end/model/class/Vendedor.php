<?php

class Vendedor extends Usuario implements JsonSerializable
{

    public function __construct()
    {
        // ...
    }

    public function jsonSerialize() { return get_object_vars($this); }
}
