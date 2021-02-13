<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Account;


class DataController extends Controller
{
    

    public function saveAccount(Request $request)
    {

        $decode_array = json_decode($request->excel_data, true);
        array_shift($decode_array);

        $data = $decode_array;
        for ($i=0; $i < count($data) ; $i++) { 
            $account = Account::create([
                'first_name' => $data[$i] ['__EMPTY_1'],
                'last_name' => $data[$i] ['__EMPTY_2'],
                'branch' => $data[$i] ['__EMPTY_3'],
                'account_type' => $data[$i] ['__EMPTY_4'],
                'account_balance' => $data[$i] ['__EMPTY_5'],
            ]);
        }

    }

    public function saveClient(Request $request)
    {

        $decode_array = json_decode($request->excel_data, true);
        array_shift($decode_array);

        $acc_no = rand(1111111111,9999999999);

        $data = $decode_array;
        for ($i=0; $i < count($data) ; $i++) { 
            $client = Client::create([
                'first_name' => $data[$i] ['__EMPTY_1'],
                'last_name' => $data[$i] ['__EMPTY_2'],
                'branch' => $data[$i] ['__EMPTY_3'],
                'account_type' => $data[$i] ['__EMPTY_4'],
                'account_balance' => $data[$i] ['__EMPTY_5'],
                'account_no' => rand(1111111111,9999999999)
            ]);
        }

    }

    public function getClientData()
    {

        $clients = Client::orderBy('id', 'desc')->paginate(3);
        return response()->json($clients);
    }


    public function searchClient(Request $request)
    {
        $search_query = $request->search_query;
        $data = Client::where('account_no','LIKE',"%$search_query%")
        ->take(2)
        ->get();
        return response()->json($data);
    }

}
