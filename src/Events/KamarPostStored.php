<?php

namespace Wing5wong\KamarDirectoryServices\Events;

use Illuminate\Foundation\Events\Dispatchable;

class KamarPostStored
{
    use Dispatchable;

    public function __construct(
        public $filename
    ) {}
}
