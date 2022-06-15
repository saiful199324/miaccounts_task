<?php

namespace App\Http\Controllers;
use App\Models\AccountHead;
use App\Models\JournalItem;
use App\Models\AccountHeadType;
use Illuminate\Http\Request;
use App\Models\AccountHeadSubType;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    
    public function balanceSheet(Request $request)
    {


            if(!empty($request->start_date) && !empty($request->end_date))
            {
                $start = $request->start_date;
                $end   = $request->end_date;
            }
            else
            {
                $start = date('Y-m-01');
                $end   = date('Y-m-t');
            }

            $types = AccountHeadType::get();

            // dd($types);


            $chartAccounts = [];
            foreach($types as $type)
            {
                $subTypes = AccountHeadSubType::where('type', $type->id)->get();

                // dd($subTypes);

                $subTypeArray = [];
                foreach($subTypes as $subType)
                {
                    $accounts = AccountHead::where('created_by', 1)->where('type', $type->id)->where('sub_type', $subType->id)->get();

                    // dd($accounts);

                    $accountArray = [];
                    foreach($accounts as $account)
                    {

                        $journalItem = JournalItem::select(DB::raw('sum(credit) as totalCredit'), DB::raw('sum(debit) as totalDebit'), DB::raw('sum(credit) - sum(debit) as netAmount'))->where('account', $account->id);
                        $journalItem->where('created_at', '>=', $start);
                        $journalItem->where('created_at', '<=', $end);
                        $journalItem          = $journalItem->first();
                        // dd($journalItem);
                        $data['account_name'] = $account->name;
                        $data['totalCredit']  = $journalItem->totalCredit;
                        $data['totalDebit']   = $journalItem->totalDebit;
                        $data['netAmount']    = $journalItem->netAmount;
                        $accountArray[]       = $data;
                    }
                    $subTypeData['subType'] = $subType->name;
                    $subTypeData['account'] = $accountArray;
                    $subTypeArray[]         = $subTypeData;
                }

                $chartAccounts[$type->name] = $subTypeArray;
            }

            $filter['startDateRange'] = $start;
            $filter['endDateRange']   = $end;


            return view('report.balance_sheet', compact('filter', 'chartAccounts'));
    }

    public function balanceSheetDetail(Request $request){

        if(!empty($request->start_date) && !empty($request->end_date))
        {
            $start = $request->start_date;
            $end   = $request->end_date;
        }
        else
        {
            $start = date('Y-m-01');
            $end   = date('Y-m-t');
        }

        $types = AccountHeadType::get();

        // dd($types);


        $chartAccounts = [];
        foreach($types as $type)
        {
            $subTypes = AccountHeadSubType::where('type', $type->id)->get();

            // dd($subTypes);

            $subTypeArray = [];
            foreach($subTypes as $subType)
            {

                $accounts = AccountHead::where('created_by', 1)->where('type', $type->id)->where('sub_type', $subType->id)->with('types')->get();

                // dd($accounts->$types[0]->name);

                $accountArray = [];
                foreach($accounts as $account)
                {
                    // dd($account);

                    $journalItem = JournalItem::select(DB::raw('sum(credit) as totalCredit'), DB::raw('sum(debit) as totalDebit'), DB::raw('sum(credit) - sum(debit) as netAmount'))->where('account', $account->id);
                    $journalItem->where('created_at', '>=', $start);
                    $journalItem->where('created_at', '<=', $end);
                    $journalItem          = $journalItem->first();
                    // dd($journalItem);
                    $data['account_name'] = $account->name;
                    // dd($data['account_name']);

                    // dd($account);

                    $data['level_name'] = $account->types->name;
                    $data['id'] = $account->id;
                    $data['totalCredit']  = $journalItem->totalCredit;
                    $data['totalDebit']   = $journalItem->totalDebit;
                    $data['netAmount']    = $journalItem->netAmount;
                    $accountArray[]       = $data;
                }
                $subTypeData['subType'] = $subType->name;
                $subTypeData['account'] = $accountArray;
                // dd($accountArray);
                $subTypeArray[]         = $subTypeData;
            }

            $chartAccounts[$type->name] = $subTypeArray;
            // dd($chartAccounts[$type->name]);
        }

        $filter['startDateRange'] = $start;
        $filter['endDateRange']   = $end;


        return view('report.balance_sheet_details', compact('filter', 'chartAccounts'));

    }


    

}
