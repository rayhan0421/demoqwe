@extends('layouts.main')

@section('title', 'Pms Expense Edit')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('content')
    <div class="uk-grid">
        <div class="uk-width-large-10-10">
            <div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-10-10 uk-width-large-10-10">
                    <div class="md-card">
                        <div class="user_heading">
                            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            </div>
                            <div class="user_heading_content">
                                <h2 class="heading_b"><span class="uk-text-truncate">Create New Pms Expense</span></h2>
                                <div class="uk-width-medium-1-3">
                                    <div class="md-btn-group">
                                        <a href="{{ route('pms_expense_index') }}" class="md-btn md-btn-small md-btn-primary md-btn-wave">All</a>
                                        <a href="{{ route('pms_expense_create') }}" class="md-btn md-btn-small md-btn-primary md-btn-wave">Add</a>
                                        <a href="{{ URL::previous() }}" class="md-btn md-btn-small md-btn-primary md-btn-wave">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md-card">
                            {!! Form::open(['url' => route('pms_expense_update',["id"=>$expense->id]), 'method' => 'POST','files' => false]) !!}
                            <div class="user_content">
                                <div class="uk-margin-top">
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5  uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="nationality">Date <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="nationality">Select Date</label>
                                            <input class="md-input" type="text" id="date" name="date" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ $expense["date"] }}"/>
                                            @if($errors->first('date'))
                                                <div class="uk-text-danger">Date is required.</div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="uk-grid" data-uk-grid-margin>

                                        <div class="uk-width-medium-1-5 uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="type">Select Sectors <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">

                                            <select data-md-selectize name="sector" id="pms_sectors_id" class="md-input" data-uk-tooltip="{pos:'top'}" title="Select Sector">
                                                <option value="">Select Sector</option>
                                                @foreach($sectors as $all)
                                                    <option {{ $expense->pmsexpense_sector_id==$all->id?"selected":'' }} value="{{ $all->id }}">{{ $all->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if($errors->first('sector'))
                                            <div class="uk-text-danger">sector is required.</div>
                                        @endif
                                    </div>
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5  uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="company_name">Amount <i style="color:red" class="material-icons">stars</i></label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="name">Amount</label>
                                            <input class="md-input" type="text" id="amount" name="amount" value="{{ $expense["amount"] }}" />
                                        </div>
                                        @if($errors->first('amount'))
                                            <div class="uk-text-danger">{{ $errors->first('amount') }}</div>
                                        @endif
                                    </div>
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5  uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="company_name">Note</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <textarea name="note" cols="30" rows="4" class="md-input no_autosize">{{ $expense["note"] }}</textarea>
                                            @if($errors->has('note'))
                                                <div class="uk-text-danger">{{ $errors->first('note') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="uk-grid" data-uk-grid-margin>
                                        <div class="uk-width-medium-1-5  uk-vertical-align">
                                            <label class="uk-vertical-align-middle" for="company_name">Amount Paid</label>
                                        </div>
                                        <div class="uk-width-medium-2-5">
                                            <label for="name">Amount Paid</label>
                                            <input class="md-input" type="text" id="paid" name="paid" value="{{ $expense["paid"] }}" />
                                        </div>
                                        @if($errors->first('paid'))
                                            <div class="uk-text-danger">{{ $errors->first('paid') }}</div>
                                        @endif
                                    </div>

                                    <div class="uk-grid uk-ma" data-uk-grid-margin>
                                        <div class="uk-width-1-1 uk-float-left">
                                            <button type="submit" class="md-btn md-btn-primary" >Submit</button>
                                            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                                        </div>
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
        var old_paid = "{{ $expense["paid"] }}";
        var old_due = "{{ $expense["due"] }}";
        $("#paid").on("input",function () {
            var total = parseFloat(old_paid)+parseFloat(old_due);
            var paid= parseFloat($(this).val());
            var amount= parseFloat($("#amount").val());

            if(paid>total)
            {
                $(this).val(parseFloat(old_paid));
            }

        });
    </script>
    <script>

        $('#sidebar_pms').addClass('current_section');
        $('#sidebar_pms_expense_list_2').addClass('act_item');
        $(window).load(function(){
            $("#pms_tiktok").trigger('click');
            $("#pms_expense_tiktok").trigger('click');
        })
    </script>
    <script src="{{ asset("admin/assets/js/pages/redeyeCustom.js") }}"></script>
@endsection