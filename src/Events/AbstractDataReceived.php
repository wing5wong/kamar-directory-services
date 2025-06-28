<?php

namespace Wing5wong\KamarDirectoryServices\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

abstract class AbstractDataReceived
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Collection $records
    ) {}
}
