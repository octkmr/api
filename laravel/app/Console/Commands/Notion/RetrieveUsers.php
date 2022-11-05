<?php

namespace App\Console\Commands\Notion;

use App\Repositories\NotionRepository;
use Illuminate\Console\Command;

class RetrieveUsers extends Command
{
    private const FILE_NAME = 'retrieve_users.json';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notion:r_users';

    private NotionRepository $repository;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notionのデータベースにを取得します';

    public function __construct(NotionRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $result = $this->repository->users();
        $outputFile = config('response.notion_path') . self::FILE_NAME;
        file_put_contents($outputFile, json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }
}
