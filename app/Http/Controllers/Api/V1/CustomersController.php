<?php

namespace App\Http\Controllers\Api\V1;
use DB;
use App\Models\Logs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CustomersController extends Controller
{
    


    function GetCustomers(Request $request)
    {
        $query = 'SELECT cu.name, cu.last_name, cu.address, r.description, co.description from customers cu join regions r on cu.id_reg = r.id_reg join communes co on cu.id_com = co.id_com where cu.status = "A" ';
        $customers = DB::select($query,[]);

        $ip = $_SERVER['REMOTE_ADDR'];

        if(! $_ENV["APP_DEBUG"]){
            //----LOG----
            DB::insert('insert into logs values (null,"Select","Customers selected",?,?,?)', [$query,now()->toDateTimeString(),$ip]);
        }

        return response()->json(['Customers' => $customers], 200);
    }


    function GetCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'dni' => 'string|not_regex:/[\<\>\'\"\;\=\(\)]/',
            'email' => 'email|not_regex:/[\<\>\'\"\;\=\(\)]/',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $query = 'SELECT cu.name, cu.last_name, cu.address, r.description, co.description from customers cu join regions r on cu.id_reg = r.id_reg join communes co on cu.id_com = co.id_com where cu.status = "A" AND (cu.dni = ? OR cu.email = ?) ';
        $dni = $request->dni;
        $email = $request->email;

        $customers = DB::select($query,[$dni, $email]);

        if(! $_ENV["APP_DEBUG"]){
            //----LOG----
            DB::insert('insert into logs values (null,"Select","Customer selected",?,?,?)', [$query,now()->toDateTimeString(),$ip]);
        }

        return response()->json(['Customers' => $customers], 200);
    }



    function InsertCustomer(Request $request)
    {
        //--------------validate SQL Injections----------
        $validator = Validator::make($request->all(), [ 
            'dni' => 'required|string|not_regex:/[\<\>\'\"\;\=\(\)]/',
            'id_reg' => 'required|string|not_regex:/[\<\>\'\"\;\=\(\)]/',
            'id_com' => 'required|string|not_regex:/[\<\>\'\"\;\=\(\)]/',
            'email' => 'required|email|not_regex:/[\<\>\'\"\;\=\(\)]/',
            'name' => 'required|string|not_regex:/[\<\>\'\"\;\=\(\)]/',
            'last_name' => 'required|string|not_regex:/[\<\>\'\"\;\=\(\)]/',
            'address' => 'required|string|not_regex:/[\<\>\'\"\;\=\(\)]/',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $dni = $request->dni;
        $id_reg =$request->id_reg;
        $id_com =$request->id_com;
        $email =$request->email;
        $name = $request->name;
        $last_name =$request->last_name;
        $address = $request->address;
        

        $aux_id_reg = DB::select('SELECT id_reg from communes where id_com = ?', [$id_com]);

        if($aux_id_reg[0]->id_reg != $id_reg){
            return response()->json(['error' => "Region and Commune are not related!"], 400);
        }


        $query = 'INSERT into customers values(?,?,?,?,?,?,?,now(),"A")' ;
        DB::select($query,[$dni,$id_reg,$id_com,$email,$name,$last_name,$address]);

        //----LOG----
        DB::insert('insert into logs values (null,"Insert","Customer added",?,?,?)', [$query ,now()->toDateTimeString(),$ip]);

        return response()->json(['Succes' => "Customer added!"], 200);
    }



    public function delete($dni){
        $patrones = array(
            '/\b(SELECT|INSERT|UPDATE|DELETE|DROP|CREATE|ALTER)\b/i', 
            '/--.*?$/', 
            '/\b(UNION|JOIN|WHERE|AND)\b/i' 
        );
        foreach ($patrones as $patron) {
            if (preg_match($patron, $dni)) {
                return response()->json(['error' => 'No valid'], 400);
            }
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $query = 'UPDATE customers  SET status = "trash" where dni = ?';
        $res = DB::select($query,[$dni]);

        //Another way to doit
        // DB::table('customers')->delete($dni);

        if(count( $res) == 0){
            //----LOG----
            DB::insert('insert into logs values (null,"Delete","Customer deleted",?,?,?)', [$query." dni -> $dni" ,now()->toDateTimeString(),$ip]);
            return response()->json(['Success' => 'Customer deleted'], 400);
        }

        
        return response()->json(['Error' => 'Customer not found'], 200);
    }





}
