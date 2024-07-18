<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Income;
use App\Models\Project;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $projectsCount = Project::count();
        $expenditureSum = Expenditure::sum("amount");
        $incomeSum = Income::sum("amount");

        return response()->json([
            'projects' => $projectsCount,
            'expenditures' => $expenditureSum,
            'incomes' => $incomeSum
        ], 200);
    }

    public function project($id){
        $expenditureSum = Expenditure::where('project_id', $id)->get()
        ->sum(function ($income) {
            return $income->amount * $income->count;
        });
        $incomeSum = Income::where('project_id', $id)->get()
        ->sum(function ($income) {
            return $income->amount * $income->count;
        });

        return response()->json([
            'projects' => 1,
            'expenditures' => $expenditureSum,
            'incomes' => $incomeSum
        ], 200);
    }

    public function mobileDashboardToday($id){
        $incomeAmount = Income::where("project_id", $id)->whereDate('created_at', Carbon::today())->sum("amount");
        $expenditureAmount = Expenditure::where("project_id", $id)->whereDate('created_at', Carbon::today())->sum("amount");
        $diff = $incomeAmount - $expenditureAmount;

        return response()->json([
            'success' => true,
            'income_amount' =>  $incomeAmount,
            'expenditure_amount' => $expenditureAmount,
            'difference' => $diff
        ],200);
    }
}
