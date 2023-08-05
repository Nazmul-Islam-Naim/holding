<?php

namespace App\Http\Controllers;

use App\Models\GeneralInformation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function overallEmployee(Request $request){
        if ($request->ajax()) {
            $alldata= GeneralInformation::with(['district','presentDesignation','presentWorkStation'])
                            ->get();
            return DataTables::of($alldata)->addIndexColumn()->make(True);
        }
        return view('dashboard.overallEmployee');
    }
    
    public function presentEmployee(Request $request){
        if ($request->ajax()) {
            $alldata= GeneralInformation::with(['district','presentDesignation','presentWorkStation'])
                            ->where('status', 1)
                            ->get();
            return DataTables::of($alldata)->addIndexColumn()->make(True);
        }
        return view('dashboard.presentEmployee');
    }

    public function pensionEmployee(Request $request){
        if ($request->ajax()) {
            $alldata= GeneralInformation::with(['district','presentDesignation','presentWorkStation'])
                            ->where('status', 0)
                            ->get();
            return DataTables::of($alldata)->addIndexColumn()->make(True);
        }
        return view('dashboard.pensionEmployee');
    }

    public function director(Request $request){
        if ($request->ajax()) {
            $alldata= GeneralInformation::with(['district','presentDesignation','presentWorkStation'])
                            ->where('status', 1)
                            ->where('present_designation_id', 4)
                            ->get();
            return DataTables::of($alldata)->addIndexColumn()->make(True);
        }
        return view('dashboard.director');
    }

    public function assistantDirector(Request $request){
        if ($request->ajax()) {
            $alldata= GeneralInformation::with(['district','presentDesignation','presentWorkStation'])
                            ->where('status', 1)
                            ->where('present_designation_id', 5)
                            ->get();
            return DataTables::of($alldata)->addIndexColumn()->make(True);
        }
        return view('dashboard.assistantDirector');
    }

    public function subAssistantDirector(Request $request){
        if ($request->ajax()) {
            $alldata= GeneralInformation::with(['district','presentDesignation','presentWorkStation'])
                            ->where('status', 1)
                            ->where('present_designation_id', 6)
                            ->get();
            return DataTables::of($alldata)->addIndexColumn()->make(True);
        }
        return view('dashboard.subAssistantDirector');
    }
}
