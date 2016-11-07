<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use LaravelHungary\Barion\BarionClient;
use LaravelHungary\Barion\Enums\BarionEndpoint;

class BarionClientTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function pos_key_gets_appended_to_get_queries()
    {
        $history = [];
        $request = $this->getClientObject(
            [new Response(200), new Response(200)],
            $history
        );

        $request->get('/test/url');
        $uri = $history[0]['request']->getUri();
        $this->assertEquals(
            'https://api.test.barion.com/test/url?POSKey=abcd-1234',
            (string) $uri
        );

        $request->get('/test/url?myparam=false');
        $uri = $history[1]['request']->getUri();
        $this->assertEquals(
            'https://api.test.barion.com/test/url?myparam=false&POSKey=abcd-1234',
            (string) $uri
        );
    }

    /** @test */
    public function pos_key_is_sent_with_post_requests()
    {
        $history = [];
        $request = $this->getClientObject([], $history);

        $request->post('/pay', ['currency' => 'HUF', 'amount' => 100]);

        $body = (string) $history[0]['request']->getBody();
        $data = json_decode($body);

        $this->assertEquals($data->POSKey, 'abcd-1234');
    }

    private function getClientObject($responses = [], &$history = [])
    {
        $historyMiddleware = Middleware::history($history);

        if (!$responses) {
            $responses = [new Response(200)];
        }

        $mockHandler = new MockHandler($responses);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($historyMiddleware);

        return new BarionClient(
            new Client(['handler' => $handler]),
            BarionEndpoint::TEST,
            'abcd-1234'
        );
    }
}
