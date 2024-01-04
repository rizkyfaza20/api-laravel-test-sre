<?php

namespace App\Services;

use Prometheus\CollectorRegistry;
use Prometheus\Counter;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

class MetricService
{
    public function incrementMyCounter()
    {
        $registry = new CollectorRegistry(new InMemory());
        $counter = $registry->registerCounter('my_counter', 'Description of my_counter');
        $counter->inc(['counter' => 'v_counter']);
    }
}

