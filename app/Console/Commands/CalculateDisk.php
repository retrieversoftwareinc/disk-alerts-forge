<?php

namespace App\Console\Commands;

use App\Mail\LowDisk;
use Illuminate\Console\Command;

class CalculateDisk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:disk {--location=/} {--email=} {--alert-when=10} {--test=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets information about the disk size';

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
        $isTest = boolval($this->option('test'));

        $location = $this->option('location');

        $alert = $this->option('alert-when');

        if (empty($location)) {
            $location = '/';
        }

        $emailsTo = $this->option('email');
        if (empty($emailsTo) && !$isTest) {
            // exit because apparently no one wants to be notified.
            return;
        }

        if (! is_array($emailsTo)) {
            $emailsTo = [$emailsTo];
        }

        $disk_free = disk_free_space($location);
        $total_disk = disk_total_space($location);
        $disk_used = $total_disk - $disk_free;

        $disk_free = $this->bToGb($disk_free);
        $disk_used = $this->bToGb($disk_used);
        $total_disk = $this->bToGb($total_disk);

        if($alert < round($disk_free)) {
            $this->info("Alert value: $alert GB");

            $this->info("Total disk free: $disk_free GB");
            $this->info("Your alert value is less than the free space.");
            return;
        }

        if($isTest) {
            $this->info("Total disk: $total_disk GB");
            $this->info("Total disk free: $disk_free GB");
            $this->info("Total disk used: $disk_used GB");
            return;
        }

        \Mail::to($emailsTo)->send((new LowDisk(compact('disk_free', 'total_disk', 'disk_used', 'location', 'alert'))));
    }

    public function bToGb($bytes): float
    {
        return round((($bytes / 1024) / 1024) / 1024, 2);
    }
}
