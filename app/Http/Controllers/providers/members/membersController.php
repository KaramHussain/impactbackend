<?php

namespace App\Http\Controllers\providers\members;

use App\Role;
use App\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\carepays_providers\payer;
use App\carepays_providers\provider;
use App\Http\Controllers\Controller;
use App\Notifications\memberCreated;
use Illuminate\Validation\ValidationException;
use App\Events\providers\members\sendOTPToMember;
use App\Http\Resources\providers\providerResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Controllers\providers\remarkCodes\remarkCodesController;

class membersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:providers']);
    }

    public function store(Request $request)
    {
        $provider = $request->user();
        
        $provider->can('create', $request->role);
        $this->validateMember($request);

        $password = Str::random(8);

        $member = provider::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'created_by'        => $provider->id,
            'practise_id'       => $provider->practise_id,
            'password'          => bcrypt($password),
            'email_verified_at' => date('Y-m-d')
        ]);

        $this->attachDuties($member, $request);

        $this->sendOTPToMember($provider, $member, $password);

        $provider->notify(new memberCreated($member));

        return response()->json("Member created", 201);

    }

    public function show(Request $request, provider $member)
    {
        $this->authorize('view', $member);
        $provider = $request->user();
        if($provider->practise_id != $member->practise_id)
        {
            throw new NotFoundHttpException("Member not found");
        }
        return (new providerResource($member))->additional([
            'data' => [
                'claims' => $member->claims
            ]
        ]);
    }


    public function update(provider $member, Request $request)
    {

        $this->authorize('update', $member);
        $this->validateData($request);

        $member->update([
            'active' => $request->active
        ]);

        $member->syncPermissions($request->permissions);
        $member->syncRoles([$request->role]);
        return response()->json("user updated", 200);

    }

    public function validateData(Request $request)
    {
        //check if user has given role or permission other than saved ones.
        if(!$this->allPermissionExists($request))
        {
            throw ValidationException::withMessages([
                'Invalid data provided'
            ]);
        }
    }

    public function roleNotExists(Request $request)
    {
        return Role::where('name', $request->role)->first();
    }

    public function allPermissionExists(Request $request)
    {
        $permissions = Permission::all()->pluck('id')->toArray();
        $allPermissions = array_diff($request->permissions, $permissions);
        return empty($allPermissions);
    }

    public function destroy(provider $member)
    {
        $this->authorize('delete', $member);
        $member->delete();
    }

    public function sendOTPToMember($provider, $member, $otp)
    {
        event(new sendOTPToMember($provider, $member, $otp));
    }

    public function validateMember(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:providers',
            'role'  => 'exists:roles,name'
        ]);

        $this->validateData($request);
    }

    public function attachDuties(provider $member, Request $request)
    {
        $role = $this->findRole($request->role);
        $member->attachRole($role);

        $member->syncPermissions($request->permissions);

        if(strtolower($request->responsibility) == 'eob')
        {
            $codes = (new remarkCodesController)->remarkCodes($request->all_remark_codes);
            $member->attachRemarkCode($codes);

            $member->attachPayers($request->all_payers);
            return;
        }

        $codes = (new remarkCodesController)->remarkCodes($request->remark_codes);
        $member->attachRemarkCode($codes);

        $member->attachPayers($request->insurance_companies);
    }

    public function findRole($role)
    {
        return Role::where('name', $role)->first();
    }

}
