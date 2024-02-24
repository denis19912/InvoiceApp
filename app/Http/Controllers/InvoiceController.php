<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class InvoiceController extends Controller
{
    public function getAllInvoices()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();

        return response()->json(([
            'invoices' => $invoices
        ]), 200);
    }

    public function searchInvoice(Request $request)
    {

        $search = $request->get('s');
        if ($search != null) {
            $invoices = Invoice::with('customer')
                ->where(function ($query) use ($search) {
                    $query->orWhere('date', 'LIKE', "%$search%")
                        ->orWhere('due_date', 'LIKE', "%$search%")
                        ->orWhere('reference', 'LIKE', "%$search%")
                        ->orWhere('terms_and_conditions', 'LIKE', "%$search%")
                        ->orWhere('sub_total', 'LIKE', "%$search%")
                        ->orWhere('number', 'LIKE', "%$search%")
                        ->orWhere('total', 'LIKE', "%$search%");
                })
                ->orderBy('id', 'desc')
                ->get();
            return response()->json(([
                'invoices' => $invoices
            ]), 200);
        } else {
            return $this->getAllInvoices();
        }
    }


    public function createInvoice(Request $request)
    {

        $counter = Counter::where('key', 'invoice')->first();
        $random = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();

        if ($invoice) {
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        } else {
            $counters = $counter->value;
        }

        $formData = [
            'number' => '#' . rand(100, 10000),
            'customer_id' => null,
            'customer' => null,
            'date' => date('d-m-Y'),
            'due_date' => null,
            'reference' => null,
            'discount' => null,
            'terms_and_conditions' => 'Default Terms and conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1
                ]
            ]
        ];

        return response()->json($formData);
    }

    public function addInvoice(Request $request)
    {
        $invoiceItem = $request->input('invoiceItem');
        $invoiceData['customer_id'] = $request->input('customerId');
        $invoiceData['date'] = $request->input('date');
        $invoiceData['due_date'] = $request->input('dueDate');
        $invoiceData['number'] = $request->input('number');
        $invoiceData['reference'] = $request->input('reference');
        $invoiceData['discount'] = $request->input('discount');
        $invoiceData['sub_total'] = $request->input('subTotal');
        $invoiceData['total'] = $request->input('grandTotal');
        $invoiceData['terms_and_conditions'] = $request->input('termsAndConditions');

        $invoice = Invoice::create($invoiceData);

        foreach (json_decode($invoiceItem) as $item) {
            $itemData['product_id'] = $item->id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity'] = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemData);
        }
    }
}
