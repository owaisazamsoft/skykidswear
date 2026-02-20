<?php

$items = $getRecord()->items;

$groups = $items->groupBy(['employee_id']);

?>

<div id="invoice-shell">

    <style>
        /* THE FIX FOR THE BLACK BACKGROUND */
        @media screen {
            #invoice-shell {
                padding: 20px;
                background: #f4f4f4;
            }
        }

        @media print {

            /* Hide EVERYTHING in Filament */
            body * {
                visibility: hidden !important;
                background: white !important;
            }

            /* Show ONLY the invoice */
            #invoice-shell,
            #invoice-shell * {
                visibility: visible !important;
            }

            #invoice-shell {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                background: white !important;
                color: black !important;
            }

            /* Force browser to kill dark mode */
            html,
            body {
                background: white !important;
                color: black !important;
            }
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            background: white !important;
            color: black !important;
            font-family: 'Helvetica', sans-serif;
        }

        .th{
            padding: 10px; 
            border: 1px solid #ddd; 
            text-align: center;
        }

        .td{
            text-align:center;
            padding: 10px; 
            border: 1px solid #ddd;
        }
    </style>

    <div class="invoice-box">
        <table style="width: 100%; line-height: 28px; text-align: left;">
            <tr>
                <td style="font-size: 28px; font-weight: bold;">WEEKLY PAYMENT</td>
                <td style="text-align: right;">
                    ID: #{{ $getRecord()->ref }}<br>
                    Date: {{ $getRecord()->date }}
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 20px 0;">
                    <hr style="border: 1px solid #eee;">
                </td>
            </tr>
            {{-- <tr>
                <td>
                    <strong>Customer:</strong><br>
                    {{ $getRecord()->customer_name ?? 'Walking Customer' }}
                </td>
                <td style="text-align: right;">
                    <strong>Company:</strong><br>
                    My Awesome Shop
                </td>
            </tr> --}}
        </table>

        <table style="width: 100%; margin-top: 40px; border-collapse: collapse;">
            <tr style="background: #eee;">
                <th class="th">Department</th>
                <th class="th">Employee</th>
                <th class="th">Lot</th>
                <th class="th">Item</th>
                <th class="th">Qty</th>
                <th class="th">Price</th>
                <th class="th">Total</th>
            </tr>
            
            @foreach ($groups as $items)
                    @foreach ($items as $k => $item)
                        <tr>
                            <td class="td">
                                {{ $item->department->name ?? '' }}</td>
                            <td class="td">
                                {{ $item->employee->name }}</td>
                            <td class="td">
                                {{ $item->lotItem->lot->ref }}</td>
                            <td class="td">
                                {{ $item->lotItem->product->name }}-{{ $item->lotItem->color->name }}-{{ $item->lotItem->size->name }}
                            </td>
                            <td class="td">{{ $item->quantity }}</td>
                            <td class="td">{{ $item->price }}</td>
                            <td class="td">{{ $item->total }}
                            </td>
                        </tr>
                    @endforeach
                   <tr>
                      <td colspan="5" style="padding: 10px; border: 1px solid #ddd;"></td>
                      <th class="th">Total</th>
                      <td class="td">{{ $items->sum('total')}}</td>
                   </tr>
                   
                @endforeach
                 
         

        </table>

        <div style="text-align: right; margin-top: 30px; font-size: 20px; font-weight: bold;">
            Total: RS {{ $items->sum('total') }}
        </div>
    </div>
</div>
