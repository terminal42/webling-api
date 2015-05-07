<?php

namespace Terminal42\WeblingApi;

interface ClientInterface
{
    public function get($url, $query = []);

    public function post($url, $body);

    public function put($url, $body);

    public function delete($url);
}
