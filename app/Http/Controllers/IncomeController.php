<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(){
        $incomes = Income::get();

        return response()->json($incomes);
    }

    public function getGeneralIncomeSum(){
        $incomeSum = Income::sum("amount");
        return response()->json($incomeSum, 200);
    }

    public function getIncomeSumToday($id){
        $totalAmount = Income::where("project_id", $id)->whereDate('created_at', Carbon::today())->sum("amount");
        return response()->json([
            'amount' => $totalAmount,
            'message' => 'success'
        ], 200);
    }

    public function getProjectIncomeSum($id){
        $totalAmount = Income::where("project_id", $id)->sum("amount");
        return response()->json($totalAmount, 200);
    }

    public function store(Request $request){
        Income::create([
            'title' => $request->title, 
            'amount' => $request->amount, 
            'project_id' => $request->project_id
        ]);
        
        return response()->json('Income record created', 201);
    }
}
