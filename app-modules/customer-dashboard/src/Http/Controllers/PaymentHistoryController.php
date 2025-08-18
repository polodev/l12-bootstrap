<?php

namespace Modules\CustomerDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Payment\Models\Payment;

class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of the user's payments.
     */
    public function index()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->with(['subscriptionPlan'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer-dashboard::accounts.payments.index', compact('payments'));
    }

    /**
     * Display the specified payment details.
     */
    public function show($id)
    {
        $payment = Payment::where('user_id', Auth::id())
            ->where('id', $id)
            ->with(['subscriptionPlan', 'user'])
            ->firstOrFail();

        return view('customer-dashboard::accounts.payments.show', compact('payment'));
    }
}