<?php

namespace App\Http\Controllers\providers;

use App\Role;
use App\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\carepays_providers\practise;
use App\carepays_providers\provider;
use App\carepays_providers\nucc_provider_details;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Events\providers\sendVerificationEmail;
use App\Http\Requests\providers\registrationRequest;
use App\Http\Controllers\providers\practises\practiseController;

class registerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function register(registrationRequest $request)
    {
        $practise = (new practiseController)->create($request);

        $provider = $this->create($practise, $request);

        if ($provider) {

            $admin = Role::admin();
            $permissions = Permission::all();

            $provider->attachRole($admin);
            $provider->attachPermissions($permissions);

            $this->fireVerificationEvent($provider);

            return response()->json("Registered successfully", 201);
        }

        throw new ValidationException("Something went wrong please try again later");
    }

    public function create(practise $practise, registrationRequest $request)
    {
        return provider::create([
            'practise_id' => $practise->id,
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'email_token' => Str::random(255),
            'npi'         => $request->npi,
            'is_doctor'   => $request->is_doctor
        ]);
    }

    public function fireVerificationEvent($provider)
    {
        event(new sendVerificationEmail($provider));
    }

    public function get_provider_details_by_npi()
    {
        $request = request();
        if ($request->has('npi')) {
            $npi = $request->query('npi');
            if ($npi) {
                $prov_details = nucc_provider_details::select(
                    "npi",
                    "entity_type_code",
                    "provider_organization_name",
                    "provider_last_name",
                    "provider_first_name",
                    "provider_first_line_business_mailing_address",
                    "provider_second_line_business_mailing_address",
                    "provider_business_mailing_address_city_name",
                    "provider_business_mailing_address_state_name",
                    "provider_business_mailing_address_postal_code",
                    "provider_business_mailing_address_country_code",
                    "provider_business_mailing_address_telephone_number",
                    "provider_business_mailing_address_fax_number",
                    "provider_first_fine_business_practice_location_address",
                    "provider_business_practice_location_address_city_name",
                    "provider_business_practice_location_address_state_name",
                    "provider_business_practice_location_address_postal_code",
                    "provider_business_practice_location_address_country_code",
                    "provider_business_practice_location_address_telephone_number",
                    "healthcare_provider_taxonomy_code_1"
                )->where('npi', $npi)->first();
                if ($prov_details) {
                    return response()->json($prov_details);
                }
            }
        }
    }
}
