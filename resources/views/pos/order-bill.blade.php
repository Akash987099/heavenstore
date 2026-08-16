@extends('pos.layout.app')

@section('content')

<style>

    .invoice-page {
    background: #f4f6f8;
    min-height: 100%;
    width: 100%;
    padding: 20px;
    overflow-y: auto;
    overflow-x: hidden;
}

    .invoice-box {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #d6dee6;
        border-radius: 6px;
        overflow: hidden;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 20px 25px;
        background: #128C7E;
        color: #fff;
    }

    .company-name {
        font-size: 22px;
        font-weight: 700;
    }

    .company-subtitle {
        font-size: 12px;
        margin-top: 3px;
        opacity: .9;
    }

    .invoice-header-right {
        text-align: right;
    }

    .invoice-title {
        font-size: 26px;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .invoice-number {
        font-size: 13px;
        margin-top: 4px;
        opacity: .95;
    }

    .invoice-content {
        padding: 22px 25px 0;
    }

    .invoice-info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .invoice-info-table td {
        width: 33.33%;
        vertical-align: top;
        padding-right: 20px;
    }

    .invoice-info-table td:last-child {
        padding-right: 0;
    }

    .info-heading {
        font-size: 12px;
        font-weight: 700;
        color: #128C7E;
        border-bottom: 1px solid #dce6ee;
        padding-bottom: 6px;
        margin-bottom: 8px;
    }

    .info-content {
        font-size: 13px;
        line-height: 1.6;
        color: #374151;
        word-break: break-word;
    }

    .info-content strong {
        color: #111827;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #dce6ee;
        font-size: 13px;
        table-layout: fixed;
        margin-bottom: 20px;
    }

    .items-table th,
    .items-table td {
        border-bottom: 1px solid #e6edf3;
        padding: 11px 9px;
        word-break: break-word;
    }

    .items-table th {
        background: #eaf8f5;
        color: #128C7E;
        text-transform: uppercase;
        font-size: 11px;
        text-align: left;
    }

    .items-table tr:last-child td {
        border-bottom: none;
    }

    .items-table th:nth-child(n+3),
    .items-table td:nth-child(n+3) {
        text-align: right;
    }

    .items-table th:nth-child(1),
    .items-table td:nth-child(1) {
        width: 5%;
        text-align: center;
    }

    .items-table th:nth-child(2),
    .items-table td:nth-child(2) {
        width: 43%;
        text-align: left;
    }

    .items-table th:nth-child(3),
    .items-table td:nth-child(3) {
        width: 12%;
    }

    .items-table th:nth-child(4),
    .items-table td:nth-child(4) {
        width: 20%;
    }

    .items-table th:nth-child(5),
    .items-table td:nth-child(5) {
        width: 20%;
    }

    .summary-box {
        width: 340px;
        max-width: 100%;
        margin-left: auto;
        margin-bottom: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 7px 0;
        font-size: 13px;
        color: #64748b;
    }

    .summary-row strong {
        color: #334155;
    }

    .grand-total {
        margin-top: 7px;
        padding-top: 12px;
        border-top: 2px solid #128C7E;

        display: flex;
        justify-content: space-between;
        align-items: center;

        font-size: 18px;
        font-weight: 700;
        color: #128C7E;
    }

    .payment-box {
        margin-bottom: 20px;
        padding: 11px 13px;
        background: #f5faf9;
        border-left: 3px solid #128C7E;
    }

    .payment-box span {
        font-size: 12px;
        color: #64748b;
    }

    .payment-box strong {
        font-size: 13px;
        color: #128C7E;
        text-transform: uppercase;
    }

    .invoice-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;

        background: #f5f9fc;
        border-top: 1px solid #d6dee6;
        padding: 16px 25px;
    }

    .footer-text {
        font-size: 12px;
        color: #64748b;
    }

    .footer-total {
        font-size: 19px;
        font-weight: 700;
        color: #128C7E;
        white-space: nowrap;
    }

    .footer-total span {
        font-size: 11px;
        font-weight: 400;
        color: #64748b;
        margin-right: 5px;
    }

    .bill-actions {
        max-width: 900px;
        margin: 0 auto 15px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .bill-action {
        border: 0;
        border-radius: 8px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .new-order-btn {
        background: #fff;
        border: 1px solid #d6dee6;
        color: #475569;
        text-decoration: none;
    }

    @media (max-width: 700px) {

        .invoice-page {
            padding: 10px;
        }

        .invoice-header {
            padding: 16px;
        }

        .invoice-content {
            padding: 16px 14px 0;
        }

        .invoice-info-table,
        .invoice-info-table tbody,
        .invoice-info-table tr,
        .invoice-info-table td {
            display: block;
            width: 100%;
        }

        .invoice-info-table td {
            padding-right: 0;
            margin-bottom: 15px;
        }

        .invoice-info-table td:last-child {
            margin-bottom: 0;
        }

        .invoice-header {
            align-items: flex-start;
        }

        .invoice-title {
            font-size: 21px;
        }

        .company-name {
            font-size: 18px;
        }

        .items-table {
            min-width: 650px;
        }

        .items-scroll {
            overflow-x: auto;
        }

        .summary-box {
            width: 100%;
        }

        .invoice-footer {
            padding: 14px 16px;
        }
    }

    
    @media print {

    @page {
        size: A4;
        margin: 8mm;
    }

    /* Hide complete application */
    body * {
        visibility: hidden;
    }

    /* Show only invoice */
    .invoice-box,
    .invoice-box * {
        visibility: visible;
    }

    /* Remove normal page layout */
    .invoice-page {
        position: absolute;
        left: 0;
        top: 0;

        width: 100%;
        min-height: auto;

        margin: 0;
        padding: 0;

        background: #fff;
        overflow: visible;
    }

    /* Invoice itself */
    .invoice-box {
        position: relative;

        width: 100%;
        max-width: 100%;

        margin: 0;

        background: #fff;

        border: 1px solid #d6dee6;
        border-radius: 0;

        overflow: visible;

        box-shadow: none;
    }

    /* Hide buttons */
    .bill-actions {
        display: none !important;
    }

    /* Keep invoice colors while printing */
    .invoice-header,
    .items-table th,
    .payment-box,
    .invoice-footer {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* Don't cut invoice rows */
    .items-scroll {
        overflow: visible !important;
    }

    .items-table {
        width: 100%;
        min-width: 0 !important;
    }

}

    .print-invoice-btn {
    background: #128C7E;
    color: #fff;
}

.print-invoice-btn:hover {
    background: #0f766e;
}

</style>


<div class="invoice-page">

<div class="bill-actions">

    <a
        href="{{ route('pos.order') }}"
        class="bill-action new-order-btn"
    >
        <i class="fas fa-plus mr-1"></i>
        New Order
    </a>

    <button
        type="button"
        id="printInvoiceBtn"
        class="bill-action print-invoice-btn"
    >
        <i class="fas fa-print mr-1"></i>
        Print Invoice
    </button>

</div>

    <div class="invoice-box">

        {{-- ==========================================
            HEADER
        =========================================== --}}

        <div class="invoice-header">

            <div>

                <div class="company-name">
                    Heaven Kart
                </div>

                <div class="company-subtitle">
                    Retail Store / POS
                </div>

            </div>


            <div class="invoice-header-right">

                <div class="invoice-title">
                    INVOICE
                </div>

                <div class="invoice-number">
                    #{{ $order->order_number }}
                </div>

            </div>

        </div>


        <div class="invoice-content">

            {{-- ==========================================
                FROM / TO / INVOICE INFO
            =========================================== --}}

            <table class="invoice-info-table">

                <tr>

                    {{-- FROM --}}

                    <td>

                        <div class="info-heading">
                            FROM
                        </div>

                        <div class="info-content">

                            <strong>
                                Heaven Kart
                            </strong>

                            <br>

                            Retail Store

                            <br>

                            Uttar Pradesh, India

                            <br>

                            Email:
                            info@heavenkart.online

                        </div>

                    </td>


                    {{-- TO --}}

                    <td>

                        <div class="info-heading">
                            TO
                        </div>

                        <div class="info-content">

                            <strong>
                                {{ $order->customer_name
                                    ?: 'Walk-in Customer' }}
                            </strong>

                            @if($order->customer_phone)

                                <br>

                                +91
                                {{ $order->customer_phone }}

                            @endif


                            @if($order->customer_email)

                                <br>

                                {{ $order->customer_email }}

                            @endif

                        </div>

                    </td>


                    {{-- INVOICE INFO --}}

                    <td>

                        <div class="info-heading">
                            INVOICE INFO
                        </div>

                        <div class="info-content">

                            <strong>
                                Invoice No:
                            </strong>

                            {{ $order->order_number }}

                            <br>

                            <strong>
                                Invoice Date:
                            </strong>

                            {{ $order->created_at
                                ->format('d M Y, h:i A') }}

                            <br>

                            <strong>
                                Payment Mode:
                            </strong>

                            {{ strtoupper(
                                $order->payment_method
                                ?? 'N/A'
                            ) }}

                            <br>

                            <strong>
                                Status:
                            </strong>

                            {{ ucfirst(
                                $order->status
                                ?? 'Pending'
                            ) }}

                        </div>

                    </td>

                </tr>

            </table>


            {{-- ==========================================
                THANK YOU / ORDER SUMMARY
            =========================================== --}}

            <div class="payment-box">

                <span>
                    Thank you for shopping with
                </span>

                <strong>
                    Heaven Kart
                </strong>

            </div>


            {{-- ==========================================
                PRODUCTS
            =========================================== --}}

            <div class="items-scroll">

                <table class="items-table">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Description
                            </th>

                            <th>
                                QTY
                            </th>

                            <th>
                                Unit Price
                            </th>

                            <th>
                                Total
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse(
                            $order->details
                            as $key => $detail
                        )

                            <tr>

                                <td>
                                    {{ $key + 1 }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $detail->product_name }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $detail->quantity }}
                                </td>

                                <td>
                                    ₹{{ number_format(
                                        $detail->price,
                                        2
                                    ) }}
                                </td>

                                <td>
                                    <strong>
                                        ₹{{ number_format(
                                            $detail->total,
                                            2
                                        ) }}
                                    </strong>
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    style="text-align:center;"
                                >
                                    No items found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ==========================================
                TOTAL
            =========================================== --}}

            <div class="summary-box">

                <div class="summary-row">

                    <span>
                        Subtotal
                    </span>

                    <strong>
                        ₹{{ number_format(
                            $order->subtotal,
                            2
                        ) }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Discount
                    </span>

                    <strong>
                        ₹{{ number_format(
                            $order->discount ?? 0,
                            2
                        ) }}
                    </strong>

                </div>


                <div class="grand-total">

                    <span>
                        TOTAL
                    </span>

                    <span>
                        ₹{{ number_format(
                            $order->grand_total,
                            2
                        ) }}
                    </span>

                </div>

            </div>

        </div>


        {{-- ==========================================
            FOOTER
        =========================================== --}}

        <div class="invoice-footer">

            <div class="footer-text">

                This is a computer generated invoice
                and does not require a signature.

            </div>

            <div class="footer-total">

                <span>
                    TOTAL AMOUNT
                </span>

                ₹{{ number_format(
                    $order->grand_total,
                    2
                ) }}

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const printBtn = document.getElementById('printInvoiceBtn');

    if (printBtn) {

        printBtn.addEventListener('click', function () {

            window.print();

        });

    }

});
</script>

@endsection