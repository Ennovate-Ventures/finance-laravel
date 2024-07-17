<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function index(){
        $expenditures = Expenditure::with('project')->get();

        return response()->json($expenditures);
    }

    public function getGeneralExpenditureSum(){
        $expenditureSum = Expenditure::sum("amount");
        return response()->json($expenditureSum, 200);
    }

    public function getExpenditureSumToday($id){
        $totalAmount = Expenditure::where("project_id", $id)->whereDate('created_at', Carbon::today())->sum("amount");
        return response()->json([
            'amount' => $totalAmount,
            'message' => 'success'
        ], 200);
    }

    public function getProjectExpenditureSum($id){
        $totalAmount = Expenditure::where("project_id", $id)->sum("amount");
        return response()->json($totalAmount, 200);
    }

    public function store(Request $request){
        Expenditure::create([
            'title' => $request->title, 
            'amount' => $request->amount, 
            'project_id' => $request->project_id,
            'count' => $request->count
        ]);
        
        return response()->json('Expenditure record created', 201);
    }
}
