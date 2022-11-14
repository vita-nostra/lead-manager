<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LeadController extends Controller
{
    public function createLead(Request $request) {

        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'phone' => 'required',
                'utm_source' => 'alpha_dash|nullable'
            ]);
        } catch(ValidationException $e) {
            return response([
                "status" => "error",
                "errors" => $e->errors()
            ], 400);
        }

        $lead = new Lead();
        $lead->name = $validated["name"];
        $lead->phone = $validated["phone"];

        /** @var Partner|null $partner */
        $partner = Partner::where('utm_source', $validated["utm_source"])->first();
        if ($partner !== null) {
            $lead->partner_id = $partner->id;
        } else {
            $lead->partner_id = null;
        }

        $lead->sending = false;

        $lead->save();

        return response([
            "status" => "success"
        ], 201);
    }
}
