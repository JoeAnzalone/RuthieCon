<?php

namespace App\Console\Commands;

use App\FacebookHelper;
use Illuminate\Console\Command;

class ImportGuestlist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guestlist:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import guestlist from Facebook into users table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FacebookHelper $facebook_helper)
    {
        parent::__construct();
        $this->facebook_helper = $facebook_helper;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $guestlist = $this->facebook_helper->getGuestlist();
        dump($guestlist);
    }
}
