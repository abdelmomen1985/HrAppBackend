<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HRCtrl extends Controller
{
    /**
     * INPUT
     * phoneNo
     * inOut
     * date
     */
    public function logAttend(Request $request)
    {
        $ok = DB::update("EXEC SP_HR_EmployeeAttendanceLog_Insert
        @PhoneNumber=:PhoneNumber,
        @InOutMode=:InOutMode,
        @Date=:Date ;",
        [
            ':PhoneNumber' => $request->input('phoneNo'), //'01101',
            ':InOutMode' => $request->input('inOut'), // 0 / 1,
            ':Date' => $request->input('date') // '2020-05-12'
        ]);
        return response()->json($ok , 200);
    }

    /**
     * INPUT
     * company
     */
    public function getVacationsTypes(Request $request)
    {
        $results = DB::select('EXEC SP_HR_VacationsType_FindAll @Company=:Company ;',
        [
            ':Company' => $request->input('company')
        ]);
        $collection = collect($results);
        $mapped = $collection->map(function($item, $key) {
            return [
                'typeNameAr'=> $item->ArabicDescription,
                'type' => $item->GUID
            ];
        });
        return response()->json($mapped , 200);
    }

    /**
     * INPUT
     * phoneNo
     * type : Vacation type GUID
     * days
     * fromDate
     * toDate
     */
    public function requestVacation(Request $request)
    {
        $results = DB::select("
        EXEC [dbo].[SP_HR_Vacations_Insert] @PhoneNumber =  '{$request->input('phoneNo')}',
        @Type = :Type,
        @Dayes = :Dayes,
        @SerialNo = '',
        @FromDate = :FromDate,
        @ToDate = :ToDate;
        ",
        [
            ':Type' => '02003-BFAE6B9E-44DB-4C22-BA93-67B5CE2BD6AC',
            ':Dayes' => 1,
            ':FromDate' => '2020-05-25',
            ':ToDate' => '2020-05-25',
        ]);
        var_dump($results);

        // GET Vacation Row itself
    }
}
