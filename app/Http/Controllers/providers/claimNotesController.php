<?php

namespace App\Http\Controllers\providers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\carepays_providers\{claim_note, provider_claim};

class claimNotesController extends Controller
{

    public function index(Request $request) 
    {
        $claim = provider_claim::findByClaimId($request->id)->first();
        return response()->json($claim->notes);
    }

    public function store(Request $request) 
    {
        $claim = provider_claim::findByClaimId($request->claim_id)->first();
        
        $note = $claim->notes()->create([
            'provider_id' => $request->provider_id,
            'title'       => $request->title,
            'body'        => $request->body
        ]);
        
        return response()->json($note);

    }

    public function update(Request $request, claim_note $note) 
    {
        $note = tap($note)->update([
            'title' => $request->title,
            'body'  => $request->body
        ]);
        
        return response()->json($note);
    
    }  

    public function destroy(claim_note $note) 
    {
        $note->delete();
        return response()->json("Note deleted", 200);
    }

}
