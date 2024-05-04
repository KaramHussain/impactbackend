<?php

namespace App\Http\Controllers\providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\carepays_providers\claim_revision;
use App\Http\Controllers\Controller;
use App\carepays_providers\provider_claim;

class claimRevisionsController extends Controller
{

    public function store(Request $request) 
    {
        $claim = provider_claim::findByClaimId($request->claim_id)->first();

        
        $old_revision = optional($claim->revisions()->latest('created_at')->first())->revision;
        $old_revision = optional(json_decode($old_revision))->old;

        if(is_null($old_revision)) 
        {
            $old_revision = $request->old_revision;
        }
        
        $saved_revision = $claim->revisions()->create([
            'provider_id' => $request->provider_id,
            'revision_id' => (string) Str::uuid(),
            'revision'    => json_encode([
                'old' => $old_revision,
                'new' => $request->revision,
            ]),
            'status'      => 'draft'
        ]);
        return response()->json($saved_revision);

    }

    public function index(Request $request) 
    {
        $claim = provider_claim::findByClaimId($request->claim_id)->first();
        return response()->json($claim->revisions);
    }


}
