<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{LoanCreateRequest, LoanApproveRequest, RepaymentRequest};
use App\Models\{Loan, Repayment};
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * loan application request
     *
     * @param LoanCreateRequest $request
     * @return void
     */
    public function create(LoanCreateRequest $request)
    {
        $loan = new Loan;
        $loan->amount          = $request->get("amount");
        $loan->duration        = $request->get("duration");
        $loan->interest_rate   = $request->get("interestRate");
        $loan->arrangement_fee = $request->get("arrangementFee");
        $loan->user_id         = Auth::id();
        $loan->save();

        return response()->json($loan)->setStatusCode(201);
    }

    /**
     * get loan details for loan status
     *
     * @param Request $request
     * @param [type] $loanId
     * @return void
     */
    public function get(Request $request, $loanId)
    {
        $loan = Loan::findOrFail($loanId);

        return response()->json($loan);
    }

    /**
     * loan repayment
     *
     * @param RepaymentRequest $request
     * @return void
     */
    public function repayment(RepaymentRequest $request)
    {
        $loan = Loan::where("id", $request->get("loanId"))->where("status", "approve")->firstOrFail();

        $repayment = new Repayment;
        $repayment->loan_id             = $loan->id;
        $repayment->amount              = $request->get("amount");
        $repayment->transaction_details = $request->get("transactionDetails");
        $repayment->save();

        return response()->json($repayment)->setStatusCode(201);
    }

    /**
     * loan approve by admin
     *
     * @param LoanApproveRequest $request
     * @return void
     */
    public function approve(LoanApproveRequest $request)
    {
        $loan = Loan::findOrFail($request->get("loanId"));
        $loan->status           = "approve";
        $loan->approve_admin_id = Auth::id();
        $loan->save();

        return response()->json($loan);
    }
}
