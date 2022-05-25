<?php

namespace LiveCoinWatchApi;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JsonException;

class Client
{
    private string $api_key;
    public string  $currency = 'USD';
    public string  $host     = 'https://api.livecoinwatch.com';

    /**
     * @param string $api_key
     * @param string $currency
     * @param string $host
     */
    public function __construct(
        string $api_key,
        string $currency = 'USD',
        string $host = 'https://api.livecoinwatch.com'
    )
    {
        $this->api_key  = $api_key;
        $this->host     = $host;
        $this->currency = $currency;
    }

    /**
     * @param string $endpoint Resource endpoint, see: https://livecoinwatch.github.io/lcw-api-docs/#resources
     * @param array|null $data Body content
     *
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    private function request(
        string $endpoint,
        ?array $data = null
    ): Response {
        $client = new HttpClient([
            'base_uri' => $this->host,
        ]);

        $request = new Request(
            'POST',
            $endpoint,
            [
                'Content-type' => 'application/json',
                'x-api-key'    => $this->api_key,
            ],
            json_encode($data, JSON_THROW_ON_ERROR),
        );

        return $client->send($request);
    }

    /**
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function status(): Response
    {
        return $this->request('/status');
    }

    /**
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function credits(): Response
    {
        return $this->request('/credits');
    }

    /**
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function overview(): Response
    {
        return $this->request(
            '/overview',
            [
                'currency' => $this->currency,
            ],
        );
    }

    /**
     * @param int $start
     * @param int $end
     *
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function overviewHistory(
        int $start,
        int $end
    ): Response {
        return $this->request(
            '/overview/history',
            [
                'currency' => $this->currency,
                'start'    => $start,
                'end'      => $end,
            ],
        );
    }

    /**
     * @param string $code Coin code
     * @param bool $meta Include full coin information
     *
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function coinsSingle(
        string $code,
        bool $meta = false
    ): Response {
        return $this->request(
            '/coins/single',
            [
                'currency' => $this->currency,
                'code'     => $code,
                'meta'     => $meta,
            ],
        );
    }

    /**
     * @param string $platform
     * @param string $address
     * @param bool $meta Include full coin information
     *
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function coinsContract(
        string $platform,
        string $address,
        bool $meta = false
    ): Response {
        return $this->request(
            '/coins/contract',
            [
                'currency' => $this->currency,
                'platform' => $platform,
                'address'  => $address,
                'meta'     => $meta,
            ],
        );
    }

    /**
     * @param string $code Coin code
     * @param int $start
     * @param int $end
     * @param bool $meta Include full coin information
     *
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function coinsSingleHistory(
        string $code,
        int $start,
        int $end,
        bool $meta = false
    ): Response {
        return $this->request(
            '/coins/single/history',
            [
                'currency' => $this->currency,
                'code'     => $code,
                'start'    => $start,
                'end'      => $end,
                'meta'     => $meta,
            ],
        );
    }

    /**
     * @param string $sort Sorting parameter: {rank, price, volume, code, name, age}
     * @param string $order Sorting order: {ascending, descending}
     * @param int $offset
     * @param int $limit Maximum 100
     * @param bool $meta Include full coin information
     *
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function coinsList(
        string $sort,
        string $order,
        int $offset = 0,
        int $limit = 10,
        bool $meta = false
    ): Response {
        return $this->request(
            '/coins/list',
            [
                'currency' => $this->currency,
                'sort'     => $sort,
                'order'    => $order,
                'offset'   => $offset,
                'limit'    => $limit,
                'meta'     => $meta,
            ],
        );
    }

    /**
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function fiatsAll(): Response
    {
        return $this->request('/fiats/all');
    }

    /**
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function platformsAll(): Response
    {
        return $this->request('/platforms/all');
    }

    /**
     * @param string $code Coin code
     * @param bool $meta Include full coin information
     *
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function exchangesSingle(
        string $code,
        bool $meta
    ): Response {
        return $this->request(
            '/exchanges/single',
            [
                'currency' => $this->currency,
                'code'     => $code,
                'meta'     => $meta,
            ],
        );
    }

    /**
     * @param string $sort Sorting parameter: {volume, liquidity, code, name}
     * @param string $order Sorting order: {ascending, descending}
     * @param int $offset
     * @param int $limit Maximum 100
     * @param bool $meta Include full coin information
     *
     * @return Response
     * @throws GuzzleException
     * @throws JsonException
     */
    public function exchangesList(
        string $sort,
        string $order,
        int $offset = 0,
        int $limit = 50,
        bool $meta = false
    ): Response {
        return $this->request(
            '/exchanges/list',
            [
                'currency' => $this->currency,
                'sort'     => $sort,
                'order'    => $order,
                'offset'   => $offset,
                'limit'    => $limit,
                'meta'     => $meta,
            ],
        );
    }
}

