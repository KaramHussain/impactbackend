<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ediApisController extends Controller
{
    
    public function __construct() 
    {
        // $this->middleware(['auth:api']);    
    }
    
    public function get_graph(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph.carebidsexchange.com/get_graph');
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'provider_id'=> $request->provider_id
        )));

        $response = curl_exec($ch);

        #echo 'REQUEST HEADERS:' . PHP_EOL . PHP_EOL;
        #echo curl_getinfo($ch)['request_header'];
        #echo 'RESPONSE:' . PHP_EOL . PHP_EOL;
        return $response;

        curl_close($ch);
    }

    public function get_upload_details(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://status-stage.carebidsexchange.com/get_upload_details');
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            'provider_id'=> $request->provider_id
        )));

        $response = curl_exec($ch);

        #echo 'REQUEST HEADERS:' . PHP_EOL . PHP_EOL;
        #echo curl_getinfo($ch)['request_header'];
        #echo 'RESPONSE:' . PHP_EOL . PHP_EOL;

        return response()->json(json_decode($response));

        curl_close($ch);
    }

    public function get_remark(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph.carebidsexchange.com/get_remark');
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            'provider_id'=> $request->provider_id
        )));

        $response = curl_exec($ch);

        #echo 'REQUEST HEADERS:' . PHP_EOL . PHP_EOL;
        #echo curl_getinfo($ch)['request_header'];
        #echo 'RESPONSE:' . PHP_EOL . PHP_EOL;

        return response()->json(json_decode($response));

        curl_close($ch);
    }

    public function get_payer(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph.carebidsexchange.com/get_payers');
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            'provider_id'=> $request->provider_id
        )));

        $response = curl_exec($ch);

        #echo 'REQUEST HEADERS:' . PHP_EOL . PHP_EOL;
        #echo curl_getinfo($ch)['request_header'];
        #echo 'RESPONSE:' . PHP_EOL . PHP_EOL;

        return response()->json(json_decode($response));

        curl_close($ch);
    }

    public function get_file_details(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://status-stage.carebidsexchange.com/get_file_details');
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            '_id'=> $request->_id
        )));

        $response = curl_exec($ch);

        #echo 'REQUEST HEADERS:' . PHP_EOL . PHP_EOL;
        #echo curl_getinfo($ch)['request_header'];
        #echo 'RESPONSE:' . PHP_EOL . PHP_EOL;

        return response()->json(json_decode($response));

        curl_close($ch);
    }

    public function get_rc_inc(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph.carebidsexchange.com/get_rc_ins');
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            "provider_id" => $request->provider_id,
            "payer_identifier_list" => $request->payers,
            "rc_type" => $request->remark_code_types,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date
        )));

        $response = curl_exec($ch);

        #echo 'REQUEST HEADERS:' . PHP_EOL . PHP_EOL;
        #echo curl_getinfo($ch)['request_header'];
        #echo 'RESPONSE:' . PHP_EOL . PHP_EOL;

        return response()->json(json_decode($response));

        curl_close($ch);
    }

    public function eob_upload(Request $request)
    {
        $file = $request->file->store('client_uploaded_files', 'public');
        $filepath = 'https://backend.carebidsexchange.com/storage/' . $file;
        // sleep(5);
        $ch = curl_init();
        $file_info_json = array(
            "provider_id" => $request->provider_id,
            "file"        => $filepath,
            "filename"    => $request->file->getClientOriginalName(),
            "date_upload" => $request->date_upload,
            "time_upload" => $request->time_upload,
            "email"       => $request->email,
            "claim_type"  => $request->claim_type
        );
        // 169.61.216.28
        curl_setopt($ch, CURLOPT_URL, 'https://upload-stage.carebidsexchange.com/eob_load');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($file_info_json));
        // curl -X POST -H "Content-Type: application/json" -d '{ "provider_id": "19", "file": "https://apis.carepays.com/public/home/exsania/healthcareiq.com/imran_work/apis.carepays.com/storageclient_uploaded_files/x6DAXcwIvvRVStZONSUrLILW5pEqZ6l7kOKH4qis.zip", "filename": "vb_835.zip", "date_upload": "2021-06-23", "time_upload": "07:43", "email": "email@grr.la", "claim_type": "835" }' https://upload-stage.carebidsexchange.com/eob_load
        try {
            $response = curl_exec($ch);
            print_r($response);
            $info = curl_getinfo($ch);
            $curl_error = curl_errno ($ch);
            curl_close($ch);
          } catch (\Exception $e) {
            return response()->json($e->getMessage());
          }

        return response()->json($file_info_json);
        
    }
    
    public function get_claim837(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph.carebidsexchange.com/get_claim837');
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            "_id" => $request->_id,
        )));

        $response = curl_exec($ch);

        #echo 'REQUEST HEADERS:' . PHP_EOL . PHP_EOL;
        #echo curl_getinfo($ch)['request_header'];
        #echo 'RESPONSE:' . PHP_EOL . PHP_EOL;

        return response()->json(json_decode($response));

        curl_close($ch);
    }
    
    public function submit_edi(Request $request) 
    {
        $data = $request->all();
       
        // $data = array_merge($request->all(), [
        //     '_id'                                           =>$request['_id'],
        //     'Security Information'                          => "          ",
        //     'Authorization Information'                     => "          ",
        //     'insured group or policy number'                => is_null($request['insured group or policy number']) ? "" : $request['insured group or policy number'],
        //     'Transaction Segment Count'                     => is_null($request['Transaction Segment Count']) ? "" : $request['Transaction Segment Count'],
        //     'Originator Application Transaction Identifier' => is_null($request['Originator Application Transaction Identifier']) ? "" : $request['Originator Application Transaction Identifier'],
        //     'Provider Taxonomy Code'                        => is_null($request['Provider Taxonomy Code']) ? "" : $request['Provider Taxonomy Code'],
        //     'billing_provider'                      => array_merge($request['billing_provider'], [
        //         'Hierarchical Parent ID Number'     => is_null($request['billing_provider']['Hierarchical Parent ID Number']) ? "" : $request['billing_provider']['Hierarchical Parent ID Number'],     
        //         'Identification'                    => is_null($request['billing_provider']['Identification']) ? "" : $request['billing_provider']['Identification'],
        //         'Identification Code'               => is_null($request['billing_provider']['Identification Code']) ? "" : $request['billing_provider']['Identification Code'],
        //     ]),
        //     'receiver'                    => array_merge($request['receiver'], [
        //         'Identification Code'     => is_null($request['receiver']['Identification Code']) ? "" : $request['receiver']['Identification Code'],
        //         'Name'                    => is_null($request['receiver']['Name']) ? "" : $request['receiver']['Name']
        //     ]),
        //      'submitter'                  => array_merge($request['submitter'], [
        //         'Communication Number'    => is_null($request['submitter']['Communication Number']) ? "" : $request['submitter']['Communication Number'],
        //         'Submitter Contact Name'  => is_null($request['submitter']['Submitter Contact Name']) ? "" : $request['submitter']['Submitter Contact Name'],
        //         'Identification Code'     => is_null($request['submitter']['Identification Code']) ? "" : $request['submitter']['Identification Code'],
        //     ]),
            
        //     'subscriber'         => array_merge($request['subscriber'], [
        //         'Identification' => is_null($request['subscriber']['Identification']) ? "" : $request['subscriber']['Identification']     
        //     ]),
            
            
            
            
        // ]);
        
        $ch = curl_init();
        //
        curl_setopt($ch, CURLOPT_URL, 'https://graph.carebidsexchange.com/edi');
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        #echo 'REQUEST HEADERS:' . PHP_EOL . PHP_EOL;
        #echo curl_getinfo($ch)['request_header'];
        #echo 'RESPONSE:' . PHP_EOL . PHP_EOL;
        return response()->json(json_decode($response));

        curl_close($ch);
    }
    
    
    public function send_http_request(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph.carebidsexchange.com/get_all');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request->all()));
        $response = curl_exec($ch);
        return response()->json(json_decode($response));
        curl_close($ch);
    }
    
    public function send_http_request_for_graphs(Request $request)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph.carebidsexchange.com/get_everything');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request->all()));
        $response = curl_exec($ch);
        return response()->json(json_decode($response));
        curl_close($ch);
    }   
    

}