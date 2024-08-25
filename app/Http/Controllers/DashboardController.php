<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Income;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $projectsCount = Project::count();
        $expenditureSum = Expenditure::sum("amount");
        $incomeSum = Income::sum("amount");

        $currentYear = Carbon::now()->year;

        //expenditure data
        $expendituresales = DB::table('expenditures')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount * count) as total_expenditure') // Calculate total sales by multiplying amount and count
            )
            ->whereYear('created_at', $currentYear) // Filter for the current year
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $expenditurelabels = [];
        $expendituredata = [];

        foreach ($expendituresales as $sale) {
            $monthName = Carbon::createFromDate($sale->year, $sale->month, 1)->format('F Y'); // e.g., January 2024
            $expenditurelabels[] = $monthName;
            $expendituredata[] = $sale->total_expenditure;
        }

        //Income data
        $sales = DB::table('incomes')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount * count) as total_sales') // Calculate total sales by multiplying amount and count
            )
            ->whereYear('created_at', $currentYear) // Filter for the current year
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();


        $saleslabels = [];
        $salesdata = [];

        foreach ($sales as $sale) {
            $monthName = Carbon::createFromDate($sale->year, $sale->month, 1)->format('F Y'); // e.g., January 2024
            $saleslabels[] = $monthName;
            $salesdata[] = $sale->total_sales;
        }

        return response()->json([
            'projects' => $projectsCount,
            'expenditures' => $expenditureSum,
            'incomes' => $incomeSum,
            'saleslabels' => $saleslabels,
            'salesdata' => $salesdata,
            'expenditurelabels' => $expenditurelabels,
            'expendituredata' => $expendituredata
        ], 200);
    }

    public function project($id)
    {
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

    public function mobileDashboardToday($id)
    {
        $incomeAmount = Income::where("project_id", $id)->whereDate('created_at', Carbon::today())->sum("amount");
        $expenditureAmount = Expenditure::where("project_id", $id)->whereDate('created_at', Carbon::today())->sum("amount");
        $diff = $incomeAmount - $expenditureAmount;

        return response()->json([
            'success' => true,
            'income_amount' =>  $incomeAmount,
            'expenditure_amount' => $expenditureAmount,
            'difference' => $diff
        ], 200);
    }
}
