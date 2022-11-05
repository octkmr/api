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
        $this->config = json_decode(file_get_contents(config('apikey.path') . self::API_KEY_FILE), true);
    }

    /**
     * Retrieve a database
     * https://developers.notion.com/reference/retrieve-a-database
     */
    public function database(string $databaseId): array
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.notion.com/v1/databases/' . $databaseId,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->config['secret_key'],
                    'Accept' => 'application/json',
                    'Notion-Version' => '2022-06-28',
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * List all users
     * https://developers.notion.com/reference/get-users
     */
    public function users(): array
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.notion.com/v1/users/',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->config['secret_key'],
                    'Accept' => 'application/json',
                    'Notion-Version' => '2022-06-28',
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
