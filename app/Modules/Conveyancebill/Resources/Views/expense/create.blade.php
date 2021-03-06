@extends('layouts.main')

@section('title', 'Expense')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('angular')
    <script src="{{url('app/moneyout/bill/bill.module.js')}}"></script>
    <script src="{{url('app/moneyout/bill/conveyanceexpense.controller.js')}}"></script>
@endsection

@section('content')
    <div class="uk-grid" ng-controller="ExpenseController">
        <div class="uk-width-large-10-10">
            {!! Form::open(['url' => route('cnb_expense_store'), 'method' => 'POST', 'class' => 'user_edit_form', 'id' => 'my_profile', 'files' => 'true', 'enctype' => "multipart/form-data", 'novalidate']) !!}
                <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                    <div class="uk-width-xLarge-10-10 uk-width-large-10-10">
                        <div class="md-card">
                            <div class="user_heading">
                                <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                </div>
                                <div class="user_heading_content">
                                    <h2 class="heading_b"><span class="uk-text-truncate">Create New Expense</span></h2>
                                </div>
                            </div>
                            <div class="user_content">
                                <div class="uk-margin-top">
                                    
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5  uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="expense_date">Expense Date</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="expense_date">Select date</label>
                                            <input class="md-input" type="text" id="expense_date" name="expense_date" value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" data-uk-datepicker="{format:'DD-MM-YYYY'}" required>
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="customer_name">Expense Account</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Customer" id="account_id" name="account_id" required>
                                                <option value="">Select Account</option>
                                                @foreach($accounts as $accounts)
                                                    <option {{ $accounts->id==28?"selected":null }} value="{{ $accounts->id }}">{{ $accounts->account_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label  class="uk-vertical-align-middle" for="amount">Amount</label>
                                        </div>

                                        <div class="uk-width-medium-2-5">
                                            <label id="level_amount" for="amount">Enter Amount</label>
                                            <input class="md-input" type="text" id="amount" ng-model="amount" name="amount" ng-keyup="calculateTax()"  />
                                            @if($errors->first('amount'))
                                                <div class="uk-text-danger">Amount is required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="customer_name">Select Tax</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select id="tax_id"
                                                    class="tax_id"
                                                    name="tax_id"
                                                    ng-model="tax_id"
                                                    ng-change="calculateTax()" required>

                                            </select>
                                            Tax Amount = @{{ total_tax | number : 2}} BDT
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label  class="uk-vertical-align-middle" for="customer_name">Amount Is</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select
                                                    id="amount_is"
                                                    class="amount_is"
                                                    name="amount_is"
                                                    ng-model="amount_is"
                                                    ng-change="calculateTax()"
                                                    required>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="deposite_to">Paid Through</label>
                                        </div>
                                        <div class="uk-width-medium-1-5">
                                            <select
                                                    id="paid_through_id"
                                                    class="paid_through_id"
                                                    name="paid_through_id"
                                                    ng-model="paid_through_id"
                                                    ng-change="getAccountType()"
                                                    required>
                                            </select>
                                        </div>
                                        @if($errors->first('payment_mode_id'))
                                            <div class="uk-text-danger">Paid Through is required.</div>
                                        @endif
                                        <div  class="uk-width-medium-2-5" id="show">
                                            <label for="reference">Optional(Cash) Requeired(Undeposited Fund)</label>
                                            <input class="md-input" type="text" id="reference" name="bank_info" />
                                            @if($errors->first('bank_info'))
                                                <div class="uk-text-danger">Field is required.</div>
                                            @endif
                                        </div>
                                        <div   class="uk-width-medium-1-5" id="show2">
                                            <input type="checkbox" checked id="invoice_show" name="invoice_show" />
                                            <label for="switch_demo_1" class="inline-label" id="show_invoice">Show In Invoice</label>
                                            @if($errors->first('invoice_show'))
                                                <div class="uk-text-danger">Field is required.</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="customer_name">Vendor Name</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <select data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Customer" id="customer_id" name="customer_id" required>
                                                <option value="">Select Customer</option>
                                                @foreach($customers as $customer)
                                                    <option {{ $conveyance->user_id==$customer->id?"selected":'' }} value="{{ $customer->id }}">{{ $customer->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5  uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="reference">Reference#</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="reference">Enter Reference Number</label>
                                            <input class="md-input" type="text" id="reference" name="reference" />
                                        </div>
                                    </div>

                                    <input class="md-input" type="hidden" id="reference" name="id" value="{!! $id !!}" />
                                    

                                    <hr>

                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-3">
                                            <div class="uk-grid" data-uk-grid-margin>
                                                <p>Payment Options: Paypal-Payza-Skrill </p>
                                            </div>
                                            <div class="uk-grid" data-uk-grid-margin>
                                                <div class="uk-width-medium-1-1">
                                                    <label for="user_edit_uname_control">Attach Files: </label>
                                                </div>
                                                <div class="uk-width-medium-1-1">
                                                    <div class="uk-form-file uk-text-primary"
                                                         style="width: 200px; height: 30px; border-color: #ececec; border-style: dotted; text-align: center; ">
                                                        <p style="margin: 4px;">Uplaod File</p>
                                                        <input onchange="uploadLavel()"  id="form-file" type="file" name="file1">
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

                                    <hr>

                                    <div class="uk-grid uk-ma" data-uk-grid-margin>
                                        <div class="uk-width-1-1 uk-float-left">
                                            <button type="submit" class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light">Submit</button>

                                            <a href="{{ route('expense') }}" class="md-btn md-btn-flat uk-modal-close">Close</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')

    <script>

        window.onload = function () {
            $("#show").hide();
            $("#show2").hide();
            $("#amount").val({{ $conveyance->conveyance_bill_list()->sum('amount') }});
            var design_click = document.getElementById('level_amount');
            design_click.click();

        }
        $("#paid_through_id").on("change",function () {
            var id=$(this).val();
            if(id!=3){
                $("#show").show();
                $("#show2").show();
                return false;
            }
            $("#show").hide();
            $("#show2").hide();
        })
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
        $('#sidebar_expense').addClass('act_item');
        $(window).load(function(){
            $("#tiktok_account").trigger('click');
        });

        altair_forms.parsley_validation_config();
    </script>

    <script src="{{ url('admin/bower_components/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ url('admin/assets/js/pages/forms_validation.js') }}"></script>

@endsection
