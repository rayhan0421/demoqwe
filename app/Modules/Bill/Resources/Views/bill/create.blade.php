@extends('layouts.main')

@section('title', 'Bill')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('angular')
    <script src="{{url('app/moneyout/bill/bill.module.js')}}"></script>
    <script src="{{url('app/moneyout/bill/bill.controller.js')}}"></script>
@endsection

@section('content')
    <div class="uk-grid" ng-controller="BillController">
        <div class="uk-width-large-10-10">
            <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-10-10 uk-width-large-10-10">
                    <div class="md-card">
                        <div class="user_heading">
                            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b"><span class="uk-text-truncate">Create New Bill</span></h2>
                            </div>
                        </div>
                        <div class="user_content">
                            {!! Form::open(['url' => route('bill_store'), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}
                            <div class="uk-margin-top">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="customer_name">Vendor Name</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Customer" id="customer_id" name="customer_id" required>
                                            <option value="">Select Vendor</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->display_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="order_number">Order Number#</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="invoice_number"></label>
                                        <input class="md-input" type="text" id="order_number" name="order_number"/>
                                    </div>
                                </div>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="bill_number">Bill#</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="invoice_number"></label>
                                        <input class="md-input" type="text" id="bill_number" name="bill_number" value="{{ $bill_number }}" readonly required/>
                                    </div>
                                </div>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="invoice_date">Bill Date</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="bill_date">Select date</label>
                                        <input class="md-input" type="text" id="bill_date" name="bill_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                    </div>
                                </div>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5  uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="due_date">Due Date</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <label for="due_date">Select date</label>
                                        <input class="md-input" type="text" id="due_date" name="due_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-5 uk-vertical-align">
                                        <label class="uk-vertical-align-middle" for="customer_name">Item Rates Are</label>
                                    </div>
                                    <div class="uk-width-medium-2-5">
                                        <select
                                                id="item_rates"
                                                class="item_rates"
                                                name="item_rates"
                                                ng-model="item_rates"
                                                ng-change="itemRateAre()"
                                                required>

                                        </select>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top uk-margin-large-bottom" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-1">
                                        <table class="uk-table">
                                            <thead>
                                            <tr>
                                                <th class="uk-text-nowrap">Item Details</th>
                                                <th class="uk-text-nowrap">Description</th>
                                                <th class="uk-text-nowrap">Account</th>
                                                <th class="uk-text-nowrap">Quantity</th>
                                                <th class="uk-text-nowrap">Rate</th>
                                                <th class="uk-text-nowrap uk-width-medium-1-6 hidden">Tax</th>
                                                <th class="uk-text-nowrap">Amount</th>
                                                <th class="uk-text-nowrap">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="form_section">
                                                <td>
                                                    <select
                                                            id="item_id_0"
                                                            class="account"
                                                            name="item_id[0]"
                                                            ng-model="item_id"
                                                            ng-change="getItemRate(0)"
                                                            required>

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="description_0" class="md-input" name="description[0]" ng-model="description">
                                                </td>
                                                <td>
                                                    <select id="account_id_0" class="account_id" name="account_id[0]" ng-model="account_id" required>

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="quantity_0" name="quantity[0]" ng-init="quantity[0]='1'" ng-model="quantity[0]" ng-pattern="myRegex" ng-keyup="calculateBill()" class="md-input" required/>
                                                </td>
                                                <td>
                                                    <input type="text" id="rate_0" name="rate[0]" class="md-input" ng-init="rate[0]='0.00'" ng-model="rate[0]" ng-pattern="myRegex" ng-keyup="calculateBill()" required/>
                                                </td>
                                                <td class="hidden">
                                                    <select id="tax_id_0" class="tax_id" name="tax_id[0]" ng-model="tax_id" ng-change="calculateBill()" required>

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="amount_0" name="amount[0]" ng-init="amount[0]='0.00'" ng-model="amount[0]" class="md-input" readonly="readonly" />
                                                </td>
                                                <td class="uk-text-right uk-text-middle">
                                                    <a href="#" class="btnSectionClone uk-width-medium-1-2" ng-click="Append()">
                                                        <i class="material-icons md-24">&#xE145;</i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr ng-repeat="bill in bills track by $index" class="form_section" id="data_clone">
                                                <td>
                                                    <select id="item_id_@{{ $index + 1 }}" class="item_id" name="item_id[]" ng-model="item_id" ng-change="getItemRate($index+1)" required>


                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="description_@{{ $index + 1 }}" class="md-input" name="description[]" ng-model="description[$index+1]">
                                                </td>
                                                <td>
                                                    <select id="account_id_@{{ $index + 1 }}" class="account_id" name="account_id[]" ng-model="account_id" required>


                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="quantity_@{{ $index + 1 }}" name="quantity[]" ng-init="quantity[$index+1]='1'" ng-model="quantity[$index+1]" ng-pattern="myRegex" ng-keyup="calculateBill()" class="md-input" required/>
                                                </td>
                                                <td>
                                                    <input type="text" id="rate_@{{ $index + 1 }}" name="rate[]" ng-init="rate[$index+1]='0.00'" ng-model="rate[$index+1]" ng-keyup="calculateBill()" class="md-input" required/>
                                                </td>
                                                <td class="hidden">
                                                    <select id="tax_id_@{{ $index + 1 }}" class="tax_id" name="tax_id[]" ng-model="tax_id" ng-change="calculateBill()" required>


                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" id="amount_@{{ $index + 1 }}" name="amount[]" ng-init="amount[$index+1]='0.00'" ng-model="amount[$index+1]" class="md-input" readonly="readonly" required/>
                                                </td>
                                                <td class="uk-text-right uk-text-middle">
                                                    <a href="" class="btnSectionClone uk-width-medium-1-2" ng-click="Remove($index)">
                                                        <i class="material-icons md-24">delete</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" ng-model="tax_total" name="tax_total" value="@{{ tax_total }}">
                                        <input type="hidden" ng-model="total_amount" name="total_amount" value="@{{ total_amount }}"> 
                                    </div>
                                </div>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-3 uk-margin-medium-top"></div>
                                    <div class="uk-width-medium-2-3">
                                        <table class="uk-table">
                                            <tbody>
                                            <tr class="form_section">
                                                <td>
                                                    Sub Total
                                                </td>
                                                <td>

                                                </td>
                                                <td>
                                                    @{{ sub_total | number : 2}}
                                                </td>
                                            </tr>

                                            <tr class="form_section hidden">
                                                <td>
                                                    Tax Total
                                                </td>
                                                <td>

                                                </td>
                                                <td>
                                                    @{{ tax_total | number : 2}}
                                                </td>
                                            </tr>
                                            <tr class="form_section">
                                                <td>
                                                    Vat(%)
                                                </td>
                                                <td>
                                                    <input type="text" name="shipping_charge" ng-init="vat='0.00'" ng-model="vat" ng-change="calculateBill()" class="md-input md-input-width-medium"  />
                                                </td>
                                                <td>
                                                    @{{ vat_show.toFixed(2) }} 
                                                </td>
                                            </tr>
                                            <tr class="form_section">
                                                <th>Total(BDT)</th>
                                                <th></th>
                                                <th id="total_amount">@{{ total_amount.toFixed(2) }}</th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <hr>

                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-3">
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <p>Payment Options: Cash/cheque </p>
                                        </div>
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-1">
                                                <label for="user_edit_uname_control">Attach Files: </label>
                                            </div>
                                            <div class="uk-width-medium-1-1">
                                                <div class="uk-form-file uk-text-primary"
                                                     style="width: 200px; height: 30px; border-color: #ececec; border-style: dotted; text-align: center; ">
                                                    <p style="margin: 4px;">Uplaod File</p>
                                                    <input onchange="uploadLavel()" id="form-file" type="file" name="file1">
                                                </div>
                                            </div>
                                            <p id="upload_name"></p>
                                        </div>
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-2-3">
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-1">
                                                <label for="customer_note">Customer note</label>
                                                <textarea class="md-input" id="customer_note" name="customer_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <p>
                                    @if($errors->has('payment_account')|| $errors->has('payment_amount'))

                                        <span style="color:red; position: relative; right:0px; margin: 5px 0px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">{!! "Payment field required" !!}</span>

                                    @endif
                                </p>

                                <div class="uk-grid" >
                                    <div class="uk-width-1-2" >
                                        <div style=" padding:10px;height: 40px; color: white; background-color: #1976d2; ">
                                            Payment Made
                                        </div>
                                    </div>
                                    <div class="uk-width-1-2" style="padding: 10px; height: 40px; position:relative;background: #1976d2 ">
                                        <div id="inv" style="position: absolute; right: 10px; height: 40px; ">
                                            <input {{ old('check_payment')?"checked":'' }} type="checkbox" name="check_payment" id="check_payment" style=" margin-top: -1px; height: 25px; width: 20px;" />
                                        </div>

                                    </div>
                                </div>
                                <div class="uk-grid" style="display: none;" id="payment_details">
                                    <div class="uk-width-1-1" >
                                        <div class="uk-grid">
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="payment_amount">Amount</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">

                                                <label for="payment_amount">Amount</label>
                                                <input class="md-input" type="number" id="payment_amount" name="payment_amount" value="{{ old("payment_amount") }}"/>
                                            </div>
                                        </div>
                                        <div class="uk-grid">
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="payment_account">Paid Through</label>
                                            </div>
                                            <div class="uk-width-medium-2-5">

                                                <select data-md-selectize data-md-selectize-bottom  name="payment_account" id="payment_account" class="md-input" data-uk-tooltip="{pos:'top'}" title="Select Account">
                                                    <option value="" disabled selected hidden>Select...</option>
                                                    @foreach($account as $value)
                                                        @if($value->id==3)
                                                            <option selected  value="{{ $value->id }}">{{ $value->account_name }}</option>
                                                        @else
                                                            <option value="{{ $value->id }}">{{ $value->account_name }}</option>
                                                        @endif


                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>
                                        <div style="display: none;" id="show" class="uk-grid">
                                            <div class="uk-width-medium-1-5 uk-vertical-align">
                                                <label class="uk-vertical-align-middle" for="payment_deposit_details">Details</label>
                                            </div>
                                            <div class="uk-width-medium-2-3">

                                                <input class="md-input" type="text" id="payment_deposit_details" name="payment_deposit_details" value="{{ old("payment_deposit_details") }}"/>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="uk-grid uk-ma" data-uk-grid-margin>
                                    <div class="uk-width-1-1 uk-float-left">
                                        <button type="submit" class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" value="Submit" name="submit">Submit</button>
                                        <button type="submit" class="md-btn md-btn-primary" name="save">Save</button>
                                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                    </div>
                                </div>

                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        function uploadLavel()
        {
            var fullPath = document.getElementById('form-file').value;
            var upload_file_name_ = document.getElementById('upload_name');
            if (fullPath) {
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
                }

                upload_file_name_.innerHTML  = filename;

            }
        }
        $('#sidebar_main_account').addClass('current_section');
        $('#sidebar_bill').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        });
        altair_forms.parsley_validation_config();
        //payment made
        $("#check_payment").on("click",function () {
            $("#payment_details").toggle(800);
        });
        $("#payment_amount").on("input",function () {
            var total_amount= parseInt($("#total_amount").text());
            if($(this).val()>total_amount)
            {
                $(this).val(total_amount);
                return true;
            }
            if($(this).val()<0)
            {
                $(this).val(0);
                return true;
            }
        })
        $("#payment_account").on("change",function (){
            var id=parseInt($(this).val());
            if(id!=3)
            {
                $("#show").show(900);
                return 0;
            }
            if(id==3)
            {
                $("#show").hide(900);
                return 0;
            }
        });
    </script>

    <script src="{{ url('admin/bower_components/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ url('admin/assets/js/pages/forms_validation.js') }}"></script>

@endsection
