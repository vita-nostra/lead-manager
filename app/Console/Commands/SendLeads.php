<?php

namespace App\Console\Commands;

use App\Jobs\ProcessLead;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendLeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Переотправка неотправленных лидов старше 2х часов';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $leads = Lead::where([
            ["created_at", "<" , $now->ceilHour(2)],
            ["sending", "=", false]
        ])->get();
        foreach ($leads as $lead) {
            ProcessLead::dispatch($lead);
        }
    }
}
