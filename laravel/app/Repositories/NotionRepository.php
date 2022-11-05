<?php

namespace App\Repositories;

use App\Repositories\Interfaces\NotionRepositoryInterface;
use GuzzleHttp\Client as HttpClient;

class NotionRepository implements NotionRepositoryInterface
{
    // apiの鍵ファイル
    private const API_KEY_FILE = 'notion.json';

    private HttpClient $httpClient;
    private array $config;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->config = json_decode(file_get_contents(config('apikey.path') . self::API_KEY_FILE), true, 512, JSON_THROW_ON_ERROR);
    }

    public function database(string $databaseId): array
    {
        $response = $this->httpClient->request(
            'GET',
            $this->config['url'] . $databaseId,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->config['secret_key'],
                    'Accept' => 'application/json',
                    'Notion-Version' => '2022-06-28',
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
