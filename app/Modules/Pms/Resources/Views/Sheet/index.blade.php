@extends('layouts.main')

@section('title', 'Pms Sheet')

@section('header')
    @include('inc.header')
@endsection

@section('sidebar')
    @include('inc.sidebar')
@endsection

@section('content')

    <div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
        <div class="uk-width-large-10-10">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-large-10-10">
                    <div class="md-card">
                        <div class="user_heading">

                            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                                <h2 style="color:white" class="heading_b"><span class="uk-text-truncate">All PMS Sheet</span></h2>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            </div>

                        </div>

                        @php
                            $i=1;
                        @endphp


                        <div class="user_content">
                            <div class="uk-overflow-container uk-margin-bottom">
                                <div style="padding: 5px;margin-bottom: 10px;" class="dt_colVis_buttons"></div>
                                <table class="uk-table" cellspacing="0" width="100%" id="data_table" >
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Payroll Period</th>
                                        <th>Site Name</th>
                                        <th>Status</th>
                                        <th class="uk-text-center">Action</th>
                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Payroll Period</th>
                                        <th>Site Name</th>
                                        <th>Status</th>
                                        <th class="uk-text-center">Action</th>
                                    </tr>
                                    </tfoot>

                                    <tbody>
                                    @foreach($sheet as $value)

                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>From {{ date('d-m-Y', strtotime($value->period_from)).' To '.date('d-m-Y', strtotime($value->period_to)) }}</td>
                                            <td>{{ $value->siteId['company_name'] }}</td>
                                            <td>
                                                @if($value->status == 0)
                                                    <a class="md-btn md-btn-flat md-btn-small md-btn-flat-danger md-btn-wave waves-effect waves-button" id="confirm_btn" data-id="{{ $value->id }}" onclick="confirmBtn(this);">Pending</a>
                                                @else
                                                    <a class="md-btn md-btn-flat md-btn-small md-btn-flat-primary md-btn-wave waves-effect waves-button">Confirmed</a>
                                                @endif

                                            </td>

                                            <td class="uk-text-center" style="white-space:nowrap !important;">

                                                <a href="{{ route('pms_payroll_sheet_edit',$value->id) }}">
                                                    <i data-uk-tooltip="{pos:'top'}" title="Edit" style="font-size: 23px;" class="material-icons">&#xE254;</i>
                                                </a>
                                               
                                                <a class="delete_btn"><i data-uk-tooltip="{pos:'top'}" title="Delete" class="material-icons">&#xE872;</i></a>
                                                <input type="hidden" class="sites_id" value="{{ $value->id }}">

                                                <a href="{{ route('pms_payroll_sheet_pdf',$value->id) }}">
                                                    <i data-uk-tooltip="{pos:'top'}" title="Edit" style="font-size: 23px;" class="material-icons">picture_as_pdf</i>
                                                </a>

                                            </td>
                                        </tr>

                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <!-- Add branch plus sign -->

                            <div class="md-fab-wrapper branch-create">
                                <a id="add_branch_button" href="{{ route('pms_payroll_sheet_create') }}" class="md-fab md-fab-accent branch-create">
                                    <i class="material-icons">&#xE145;</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#sidebar_pms').addClass('current_section');
        $('#pms_payroll_sheet').addClass('act_item');
        $(window).load(function(){
            $("#pms_tiktok").trigger('click');
            $("#pms_payroll_tiktok").trigger('click');
        })

        $('.delete_btn').click(function () {
            var id = $(this).next('.sites_id').val();

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                window.location.href = "{{ route('pms_payroll_sheet_destroy' , ['id' => '']) }}"+"/"+id;
            })
        })

        function confirmBtn(item) {

            var id = $(item).data('id');
            
            swal({
                title: 'Are you sure?',
                text: "Once confirmed You can not turn it to Pending.!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirm it!'
            }).then(function () {
                $.get("{{ route('pms_payroll_sheet_confirm',['id'=>'']) }}/"+id, function(data, status){
                    
                    if(status == 'success'){
                        $(item).removeClass( "md-btn md-btn-flat md-btn-small md-btn-flat-danger md-btn-wave waves-effect waves-button" ).addClass( "md-btn md-btn-flat md-btn-small md-btn-flat-primary md-btn-wave waves-effect waves-button" );
                        $(item).text('Confirmed');
                        $(item).removeAttr( "onclick" );
                    }
                    

                });
                swal("Confirmed!", "All payslips are generated.", "success");
            })
        }

    </script>
@endsection
