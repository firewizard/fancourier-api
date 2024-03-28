<?php

namespace Fancourier;

interface AuthTokenCacheContract
{
    public function get();

    public function set($value);
}
