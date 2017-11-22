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
    private $associative;

    /**
     * Initializes an instance of the BarionClient class.
     *
     * @param Client $client
     * @param string $endpoint
     * @param string $posKey
     * @param bool   $associative
     */
    public function __construct(
        Client $client,
        $endpoint,
        $posKey,
        $associative = false
    ) {
        $this->client = $client;
        $this->endpoint = $endpoint;
        $this->posKey = $posKey;
        $this->associative = $associative;
    }

    /**
     * Performs a GET request to a given URL and returns the response.
     * The base URI of the endpoint gets prepended automatically.
     *
     * @param string $url
     *
     * @return array|mixed
     */
    public function get($url)
    {
        $url = $this->appendPosKey($url);
        $url = $this->getEndpointUrl($url);

        $response = $this->client->get($url);

        return json_decode((string) $response->getBody(), $this->associative);
    }

    /**
     * Performs a POST request to a given URL and returns the response.
     * The base URI of the endpoint gets prepended automatically.
     *
     * @param string $url
     * @param array  $data
     *
     * @return array|mixed
     */
    public function post($url, $data)
    {
        $url = $this->getEndpointUrl($url);

        // Add POS key to the post data
        $data['POSKey'] = $this->posKey;

        $response = $this->client->post($url, [
            'json' => $data,
        ]);

        return json_decode((string) $response->getBody(), $this->associative);
    }

    /**
     * Gets the full URL of the request including the endpoint base URI.
     *
     * @param string $url
     *
     * @return string
     */
    protected function getEndpointUrl($url)
    {
        return $this->endpoint.ltrim($url, '/');
    }

    /**
     * Appends the POS key to the given request path.
     *
     * @param string $path
     *
     * @return string
     */
    protected function appendPosKey($path)
    {
        if (strpos($path, '?') === false) {
            return "$path?POSKey={$this->posKey}";
        }

        return "$path&POSKey={$this->posKey}";
    }

    /**
     * Return the current POS Key.
     *
     * @return string
     */
    public function getPosKey()
    {
        return $this->posKey;
    }

    /**
     * Set the current POS key.
     *
     * @param string $posKey
     *
     * @return static
     */
    public function setPosKey($posKey)
    {
        $this->posKey = $posKey;

        return $this;
    }
}
