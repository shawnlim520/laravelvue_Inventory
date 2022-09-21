<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salary;
use DB;
class SalaryController extends Controller
{
    public function Paid(Request $request, $id){

        $validatedata = $request->validate([
            'salary_month' => 'required',
        ]);

        $salary = new Salary();

        $month = $request->salary_month;

        $check = Salary::where('employee_id',$id)->where('salary_month',$month)->first();

        if ($check) {
            return response('Salary Already Paid');
        }
        else
        {
            $salary->employee_id = $id;
            $salary->amount = $request->salary;
            $salary->salary_date = date('d/m/Y');
            $salary->salary_month = $month;
            $salary->salary_year = date('Y');
            $salary->save();
        }

    }

    public function AllSalary(){
        $salary = DB::table('salaries')
            ->select('salary_month')
            ->groupBy('salary_month')
            ->get();
        return response()->json($salary);
        // $salary = DB::table('salaries')
        //                 ->join('employees','salaries.employee_id','employees.employees_id')
        //                 ->select('employees.name','salaries.*')
        //                 ->groupBy($month)
        //                 ->get();
    }

    public function ViewSalary($id){
        $month = $id;
        $salary = DB::table('salaries')
            ->join('employees','salaries.employee_id','employees.id')
            ->select('employees.name','salaries.*')
            ->where('salaries.salary_month',$month)
            ->get();

        return response()->json($salary);
    }

    public function EditSalary($id){
        $salary = DB::table('salaries')
            ->join('employees','salaries.employee_id','employees.id')
            ->select('employees.name','employees.email','salaries.*')
            ->where('salaries.id',$id)
            ->first();
        
        return response()->json($salary);
    }

    public function UpdateSalary(Request $request,$id)
    {
        $salary = Salary::findOrFail($id);
        $salary->employee_id = $request->employee_id;
        $salary->amount = $request->amount;
        $salary->salary_month = $request->salary_month;
        $salary->save();
    }
}
