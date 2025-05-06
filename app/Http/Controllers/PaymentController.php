<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function index(): Response
    {
        $payments = Payment::all();
        return Inertia::render('payments/payments', compact('payments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:payments,email',
            'amount' => 'required|numeric|min:0',
            'state' => 'required|in:pending,processing,success,failed',
        ]);

        $payment = Payment::create($validated);

        return response()->json($payment, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric',
            'state' => 'required|in:pending,success,failed,proccessing',
        ]);

        $payment = Payment::findOrFail($id);

        $payment->update([
            'email' => $request->email,
            'amount' => $request->amount,
            'state' => $request->state,
        ]);
        return response()->json(['message' => 'Payment Successfully Updated'], 200);
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->back()->with('success', 'Payment deleted successfully.');
    }
}
