<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {


        $userAuth = auth()->user();

        $invoices = Invoice::where('user_id', $userAuth->id)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);;



        $data = [
            'invoices' => $invoices,
        ];

        return view(getTemplate() . '.panel.financial.invoice', $data);
    }
}
