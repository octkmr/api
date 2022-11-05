<?php

namespace App\Console\Commands\Notion;

use App\Repositories\NotionRepository;
use Illuminate\Console\Command;

class RetrieveDatabase extends Command
{
    private const FILE_NAME = 'retrieve_database';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notion:r_db {database_id}';

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
        $databaseId = $this->argument('database_id');
        $result = $this->repository->database($databaseId);
        $outputPath = config('response.notion_path') . self::FILE_NAME . '_' . $databaseId;
        file_put_contents($outputPath, json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    }
}
