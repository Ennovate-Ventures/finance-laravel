<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Income;
use App\Models\Project;
use Illuminate\Http\Request;

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
        $expenditureSum = Expenditure::where('project_id', $id)->sum("amount");
        $incomeSum = Income::where('project_id', $id)->sum("amount");

        return response()->json([
            'projects' => 1,
            'expenditures' => $expenditureSum,
            'incomes' => $incomeSum
        ], 200);
    }
}
