<?php

namespace LaravelHungary\Barion;

use GuzzleHttp\Client;

class BarionClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $posKey;

    /**
     * @var bool
     */
    private $assoc;

    /**
     * BarionClient constructor. Initializes an instance
     * of the BarionClient class.
     *
     * @param Client $client
     * @param string $endpoint
     * @param string $posKey
     * @param bool $assoc
     */
    public function __construct(
        Client $client,
        $endpoint,
        $posKey,
        $assoc = false
    ) {
        $this->endpoint = $endpoint;
        $this->client = $client;
        $this->posKey = $posKey;
        $this->assoc = $assoc;
    }

    /**
     * Performs a GET request to a given URL and returns the response JSON as
     * string. The base URI of the endpoint gets prepended automatically.
     *
     * @param string $url
     * @return array|mixed
     */
    public function get($url)
    {
        $url = $this->appendPosKey($url);
        $url = $this->getEndpointUrl($url);

        $response = $this->client->get($url);

        return json_decode((string) $response->getBody(), $this->assoc);
    }

    /**
     * Performs a POST request to a given URL and returns the response JSON as
     * string. The base URI of the endpoint gets prepended automatically.
     *
     * @param string $url
     * @param array $data
     * @return array|mixed
     */
    public function post($url, $data)
    {
        $url = $this->getEndpointUrl($url);

        // Add POS key to the post data
        $data["POSKey"] = $this->posKey;

        $response = $this->client->post($url, [
            'json' => $data
        ]);

        return json_decode((string) $response->getBody(), $this->assoc);
    }

    /**
     * Gets the full URL of the request including the endpoint base URI.
     *
     * @param string $url
     * @return string
     */
    protected function getEndpointUrl($url)
    {
        return $this->endpoint . ltrim($url, "/");
    }

    /**
     * Appends the POS key to the given request path.
     *
     * @param string $path
     * @return string
     */
    protected function appendPosKey($path)
    {
        if (strpos($path, "?") === false) {
            return "$path?POSKey={$this->posKey}";
        }

        return "$path&POSKey={$this->posKey}";
    }
}
