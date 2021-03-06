<!DOCTYPE html>
<!--[if lte IE 9]>
<html class="lte-ie9" lang="en">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" ng-app="app">
<!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no" />

    <link rel="icon" type="image/png" href="{{ url('admin/assets/img/favicon-16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ url('admin/assets/img/favicon-32x32.png') }}" sizes="32x32">

    <title>@yield('title')</title>


    <!-- themes -->
    <link rel="stylesheet" href="{{ url('admin/assets/css/themes/themes_combined.min.css') }}" media="all">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
    <script type="text/javascript" src="{{ url('admin/bower_components/matchMedia/matchMedia.js') }}"></script>
    <script type="text/javascript" src="{{ url('admin/bower_components/matchMedia/matchMedia.addListener.js') }}"></script>
    <link rel="stylesheet" href="{{ url('admin/assets/css/ie.css') }}" media="all">
    <![endif]-->

    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.css">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th{
            border: 1px solid #ccc;
        }
        td {

            height: 2em;
            border: 1px solid #ccc;
        }
        @page { margin: 180px 50px; }
        #header { position: fixed; left: 0px; top: -190px; right: 0px; height: 150px;padding-top: 20px }
        #footer { position: fixed; left: 0px; bottom: -140px; right: 0px; height: 150px; }
        #footer .page:after { content: counter(page, upper-roman); }

    </style>
</head>

<body class="sidebar_main_open sidebar_main_swipe header_double_height" style="margin-top: 30px;margin-bottom: 40px">
<?php
$helper = new \App\Lib\Helpers;
?>

<div id="header">
    <div class="col-md-4">
        <img style="padding-top: 20px;" class="logo_regular" src="{{ url('uploads/op-logo/logo.png') }}" alt="" height="50" width="50"/>
    </div>
    <div class="" style="text-align: center;padding-top: -70px">
        <h1 style="text-transform: uppercase">{{ $OrganizationProfile->company_name }}</h1>
        <p style="margin: 0;padding: 0">{{ $OrganizationProfile->street }},{{ $OrganizationProfile->city }},{{ $OrganizationProfile->state }},{{ $OrganizationProfile->country }}</p>
        <p>{{ $OrganizationProfile->email }},{{ $OrganizationProfile->contact_number }}</p>
    </div>

    <div>

        <div style="font-size: 12px;text-align: center">
            <div >
                <h2 style="margin: 0;padding: 0">CREDIT NOTE</h2>
                <p style="margin: 0;padding: 0"># CN-{{ str_pad($credit_note->credit_note_number, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </div>
</div>
<div id="footer">

    <div class="uk-grid">
        <div class="uk-width-1-2" style="text-align: left">
            <p class="uk-text-small uk-margin-bottom">Customer Signature</p>
        </div>
        <div class="uk-width-1-2" style="text-align: right">
            <p class="uk-text-small uk-margin-bottom">Company Representative</p>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <p class="uk-text-small uk-margin-bottom">Looking forward for your business.</p>
        </div>
    </div>
</div>


<div class="uk-width-large-6-10">

    <div class="md-card-content invoice_content print_bg" style="margin-top: 10px;">

        <div class="container" style="font-size: 15px;">
            <div class="uk-width-small-1-2 uk-row-first" style="padding-top: -50px">
                <div class="uk-margin-bottom">
                    <span class="uk-text-muted uk-text-small uk-text-italic">Bill To: <span style="color: green">{{ $credit_note->customer->display_name }}</span> </span>
                    <address>
                        <p>{{ $credit_note->customer->company_name }},{{ $credit_note->customer->phone_number_1 }}</p>
                        <p>Billing Address-{{ $credit_note->customer->billing_street }},{{ $credit_note->customer->billing_city }},{{ $credit_note->customer->billing_state }},{{ $credit_note->customer->billing_zip_code }},{{ $credit_note->customer->billing_country }}</p>
                        <p>Shipping address-{{ $credit_note->customer->shipping_street }},{{ $credit_note->customer->shipping_city }},{{ $credit_note->customer->shipping_state }},{{ $credit_note->customer->shipping_zip_code }},{{ $credit_note->customer->shipping_country }}</p>
                    </address>
                </div>
            </div>
            <div class="uk-width-small-1-2" style="padding-top: -90px;">
                <div class="uk-width-small-1-1">
                    <p style="text-align: right; width: 99%;margin: 5px;padding: 0" class="uk-margin-top-remove">Credit Date : {{ $credit_note->created_at->format('d M, Y') }}</p>
                </div>
            </div>
        </div>
        <br>

        <div class="uk-grid uk-margin-large-bottom" style="font-size: 12px;padding-top: 20px">
            <table width="700px">
                <thead>
                <tr>
                    <th style="text-align: center" width="10%">#</th>
                    <th style="text-align: center">Item</th>
                    <th style="text-align: center" >Qty</th>
                    <th style="text-align: center">Rate</th>
                    <th style="text-align: center">Discount(%) </th>
                    <th style="text-align: center">Amount</th>
                </tr>
                </thead>
                <tbody>
                <tbody>
                <?php $i = 1; ?>
                @foreach($credit_note_entries as $credit_note_entry)
                    <tr class="uk-table-middle">
                        <td style="text-align: center">{{ $i++ }}</td>
                        <td style="text-align: center">{{ $credit_note_entry->item->item_name }}</td>
                        <td style="text-align: center" class="uk-text-right">{{ $credit_note_entry->quantity }}</td>
                        <td style="text-align: center" class="uk-text-right">{{ $credit_note_entry->rate }}</td>
                        <td style="text-align: center" class="uk-text-right">{{ $credit_note_entry->discount }}%</td>
                        <td style="text-align: center" class="uk-text-right">{{ $credit_note_entry->amount }}</td>
                    </tr>
                @endforeach
                <tr class="uk-table-middle">
                    <td class="no-border-bottom"></td>
                    <td class="no-border-bottom"></td>
                    <td class="no-border-bottom"></td>
                    <td class="no-border-bottom"></td>
                    <td style="text-align: center" class="uk-text-right no-border-bottom">Sub Total</td>
                    <td style="text-align: center" class="uk-text-right no-border-bottom">{{ $sub_total }}</td>
                </tr>

                @if($credit_note->tax_total>0)
                    <tr class="uk-table-middle">
                        <td class="no-border-bottom"></td>
                        <td class="no-border-bottom"></td>
                        <td class="no-border-bottom"></td>
                        <td class="no-border-bottom"></td>
                        <td style="text-align: center" class="uk-text-right no-border-bottom">Tax</td>
                        <td style="text-align: center" class="uk-text-right no-border-bottom">{{ $credit_note->tax_total }}</td>
                    </tr>
                @endif

                @if($credit_note->shiping_charge>0)
                    <tr class="uk-table-middle">
                        <td class="no-border-bottom"></td>
                        <td class="no-border-bottom"></td>
                        <td class="no-border-bottom"></td>
                        <td class="no-border-bottom"></td>
                        <td style="text-align: center" class="uk-text-right no-border-bottom">Shipping Charge</td>
                        <td style="text-align: center" class="uk-text-right no-border-bottom">{{ $credit_note->shiping_charge }}</td>
                    </tr>
                @endif

                @if($credit_note->adjustment > 0 || $credit_note->adjustment < 0)
                    <tr class="uk-table-middle">
                        <td class="no-border-bottom"></td>
                        <td class="no-border-bottom"></td>
                        <td class="no-border-bottom"></td>
                        <td class="no-border-bottom"></td>
                        <td style="text-align: center" class="uk-text-right no-border-bottom">Adjustment</td>
                        <td style="text-align: center" class="uk-text-right no-border-bottom">{{ $credit_note->adjustment }}</td>
                    </tr>
                @endif

                <tr class="uk-table-middle">
                    <td class="no-border-bottom"></td>
                    <td class="no-border-bottom"></td>
                    <td class="no-border-bottom"></td>
                    <td class="no-border-bottom"></td>
                    <td style="text-align: center" class="uk-text-right no-border-bottom">Total</td>
                    <td style="text-align: center" class="uk-text-right no-border-bottom">{{ $credit_note->total_credit_note }}</td>
                </tr>
                <tr class="uk-table-middle">
                    <td class="no-border-bottom"></td>
                    <td class="no-border-bottom"></td>
                    <td class="no-border-bottom"></td>
                    <td class="no-border-bottom"></td>
                    <td style="text-align: center" class="uk-text-right no-border-bottom" style="background: #efefef">Balance Due</td>
                    <td style="text-align: center" class="uk-text-right no-border-bottom" style="background: #efefef">BDT  {{ $credit_note->available_credit }}</td>
                </tr>
                </tbody>

            </table>
        </div>
        <br>
    </div>
</div>

</body>

</html>
