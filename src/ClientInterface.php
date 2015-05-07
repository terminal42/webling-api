<?php

namespace Terminal42\WeblingApi;

interface ClientInterface
{
    /**
     * Sends a GET request.
     *
     * @param string $url  The URL to send request to
     * @param array $query An optional array of GET parameters
     *
     * @return mixed
     */
    public function get($url, $query = []);

    /**
     * Sends a POST request.
     *
     * @param string $url  The URL to send request to
     * @param string $json The JSON data
     *
     * @return mixed
     */
    public function post($url, $json);

    /**
     * Sends a PUT request.
     *
     * @param string $url  The URL to send request to
     * @param string $json The JSON data
     *
     * @return mixed
     */
    public function put($url, $json);

    /**
     * Sends a DELETE request.
     *
     * @param string $url The URL to send request to
     *
     * @return mixed
     */
    public function delete($url);
}
