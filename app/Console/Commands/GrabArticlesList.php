<?php

declare(strict_types = 1);

namespace App\Console\Commands;

use App\Services\Grab\ArticlesFromVRApiService;
use Illuminate\Console\Command;

class GrabArticlesList extends Command
{
    /**
     * @var ArticlesFromVRApiService
     */
    private $service;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grab:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab articles from test articles api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->service = app()->make(ArticlesFromVRApiService::class);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->service->getArticles();

        $this->info('All articles grabbed!');
    }
}
