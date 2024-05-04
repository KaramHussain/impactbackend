<?php

namespace App\Http\Controllers\providers;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\carepays_providers\provider;
use App\Http\Controllers\Controller;
use App\Http\Resources\providers\providerResource;

class providersController extends Controller
{

    protected $paginated_limit = 12;

    public function index(Request $request)
    {
        $provider = $request->user();

        $role = $provider->roles->first()->name;

        $permissions = $provider->allPermissions()->pluck('name')->toArray();

        $providers = provider::byPractise($provider)
        ->notSelf($provider)
        // ->join('provider_claims', 'provider_id', '=', 'providers.id')
        // ->select(DB::raw('SUM(total_claim_charges) as claim_charges'), 'providers.*')
        ->latest();

        if($role == 'admin')
        {
            $providers = $providers->paginate($this->paginated_limit);
        }

        if($role == 'manager')
        {
            if(!in_array('view-manager', $permissions))
            {
                $providers = $providers->whereRoleIs('collector')->paginate($this->paginated_limit);
            }
        }

        if($role == 'collector')
        {
            abort(401, "You are unauthorized");
        }

        return providerResource::collection(
            $providers
        );

    }

    public function rolePermissions()
    {
        return Role::with('permissions')->where('name', 'collector')->Orwhere('name', 'manager')->get();
    }

    public function show(provider $provider)
    {
        return (new providerResource($provider));
    }

    public function permissions()
    {
        return Permission::where('name', '<>', 'all-permissions')->get();
    }

}
