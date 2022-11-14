<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\Partner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessLead implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Lead $lead;

    /**
     * Create a new job instance.
     *
     * @param Lead $lead
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var Partner|null $partner */
        $partner = Partner::where('id', $this->lead->partner_id)->first();


        $response = Http::post(config('app.lead_service_url'), [
            'name' => $this->lead->name,
            'phone' => $this->lead->phone,
            'partner_id' => $this->lead->partner_id,
            'utm_source' => $partner->utm_source
        ]);

        if($response->successful()) {
            $this->lead->sending = true;
            $this->lead->save();
        }
    }
}
