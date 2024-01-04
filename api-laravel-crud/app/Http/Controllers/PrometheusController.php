<?php

namespace App\Http\Controllers;

use Prometheus\CollectorRegistry;
use Prometheus\Counter;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;
use Symfony\Component\HttpFoundation\Response;

class PrometheusController extends Controller
{
    public function metrics()
    {
        $renderer = new RenderTextFormat();
        $result = $renderer->render((new CollectorRegistry(new InMemory()))->getMetricFamilySamples());
        return response($result, 200, ['Content-Type' => RenderTextFormat::MIME_TYPE]);
    }
    public function login_user()
    {
        $registry = new CollectorRegistry(new InMemory());
        $counter = $registry->registerCounter('user_logged_in', 'Count of user logins');
        $counter->inc();
    }
    public function monitorUsage()
    {
        $registry = new CollectorRegistry(new InMemory());
        $gauge = $registry->registerGauge('cpu_usage', 'CPU usage percentage');
        $gauge->set(rand(1, 30));
    }
    public function processData()
    {
        $registry = new CollectorRegistry(new InMemory());

        // Counter for incoming data
        $incomingCounter = $registry->registerCounter('data_in', 'Count of incoming data units');
        $incomingCounter->inc($incomingData);

        // Counter for outgoing data
        $outgoingCounter = $registry->registerCounter('data_out', 'Count of outgoing data units');
        $outgoingCounter->inc($outgoingData);
    }
}
