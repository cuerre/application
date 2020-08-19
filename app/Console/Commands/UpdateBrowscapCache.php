<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use BrowscapPHP\BrowscapUpdater;
use BrowscapPHP\Helper\IniLoaderInterface;

class UpdateBrowscapCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'browscap:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update browscap.ini into Redis cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cache = Cache::store('redis');
        $logger = Log::channel('null');
        $bc = new BrowscapUpdater($cache, $logger);
        $bc->update(IniLoaderInterface::PHP_INI_FULL);
    }
}
