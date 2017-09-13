@extends('layouts.app')

@section('header')
<h1 class="page-title"> Schedule Details
	<small>Manage Schedule Details</small>
</h1>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<span>Schedule Details Management</span>
		</li>
	</ul>                        
</div>
@endsection

@section('content')

<div class="row">
	<div class="col-lg-12 col-lg-3 col-md-3 col-sm-6 col-xs-12">
	    <!-- BEGIN EXAMPLE TABLE PORTLET-->
	    <div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-support font-green"></i>
					<span class="caption-subject font-green sbold uppercase">SCHEDULE DETAILS</span>
				</div>
	        </div>
	        <div class="portlet-body" style="padding: 15px;">
	        	<!-- MAIN CONTENT -->

                <div class="row">

                    <!-- BEGIN MATCH ENTRY -->
                    <div class="col-md-12" id="scheduleDetailContent">

        	        	<div class="table-toolbar">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="btn-group">
                                     	<a id="add-schedule-detail" class="btn green" data-toggle="modal" href="#schedule-detail"><i
        									class="fa fa-plus"></i> Add Schedule Details </a>

                                    </div>
                            	</div>
                            </div>
                        </div>

        	        	<table class="table table-striped table-hover table-bordered" id="scheduleDetailsTable" style="white-space: nowrap;">
                        	<thead>
                            	<tr>
                                    <th> Options </th>
                                    <th> Match Entry </th>
                            		<th> Schedule Code </th>
                                    <th> Date & Time </th>
                                    <th> Sport </th>
                                	<th> Description </th>                                   
                                    
                                </tr>
                            </thead>
        				</table>

                    </div>
                    <!-- END MATCH ENTRY -->

                </div>

                @include('partial.modal.schedule-detail-modal')

                @include('partial.modal.description-modal')

				<!-- END MAIN CONTENT -->
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
@endsection

@section('additional-scripts')

<!-- BEGIN SELECT2 SCRIPTS -->
<script src="{{ asset('js/handler/select2-handler.js') }}" type="text/javascript"></script>
<!-- END SELECT2 SCRIPTS -->
<!-- BEGIN TEXT MODAL SCRIPTS -->
<script src="{{ asset('js/text-modal/popup.js') }}" type="text/javascript"></script>
<!-- END TEXT MODAL SCRIPTS -->
<!-- BEGIN PAGE VALIDATION SCRIPTS -->
<script src="{{ asset('js/handler/schedule-details-handler.js') }}" type="text/javascript"></script>
<!-- END PAGE VALIDATION SCRIPTS -->

<script>

    /*
     * SCHEDULE DETAILS
     *
     */
	$(document).ready(function () {                

		$.ajaxSetup({
        	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Set data for Data Table '#scheduleDetailsTable'
        var table = $('#scheduleDetailsTable').dataTable({
	        "processing": true,
	        "serverSide": true,	          
	        "ajax": {
                url: "{{ route('datatable.scheduledetails') }}",
                type: 'POST',
            },
	        "rowId": "id",
	        "columns": [
                {data: 'action', name: 'action', searchable: false, sortable: false},
                {data: 'matchentry_description', name: 'matchentry_description', sortable: false},
	            {data: 'code', name: 'code'},
                {data: 'datetime', name: 'datetime'},
                {data: 'typesport', name: 'typesport'},
	            {data: 'description', name: 'description', sortable: false},                	           
	        ],
	        "columnDefs": [
        		{"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [2]},
      		],
            "order": [ [2, 'desc'] ],
    	});


    	// Delete data with sweet alert
        $('#scheduleDetailsTable').on('click', 'tr td button.deleteButton', function () {
            var id = $(this).val();

            // if(athleteMatchGroupRelation(id) > 0){
            //     swal("Warning", "This data still related to others! Please check the relation first.", "warning");
            //     return;
            // }

            	swal({
					title: "Are you sure?",
                    text: "You will not be able to recover data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it",
                    cancelButtonText: "No, cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })


                        $.ajax({

                            type: "DELETE",
                            url:  'scheduledetails/' + id,
                            success: function (data) {
                                // console.log(data);

                                $("#"+id).remove();
                                // $('#sportsTable').DataTable().ajax.reload();
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });                        

                        swal("Deleted!", "Data has been deleted.", "success");
                    } else {
                        swal("Cancelled", "Data is safe ", "success");
                    }
                });
        });


        // Init select2
        initSelect2Schedule();
        initSelect2MatchEntry();

    });

    function initSelect2Schedule(){

        /*
         * Select 2 for Match Entry
         *
         */

        $('#detailsSchedule').select2(setOptions('{{ route("data.schedules") }}', 'Schedules', function (params) {            
            return filterData('code', params.term);
        }, function (data, params) {
            return {
                results: $.map(data, function (obj) {                                
                    return {id: obj.id, text: obj.code+" - "+obj.type_sport.name+" - "+obj.description}
                })
            }
        }));

    }   

    function initSelect2MatchEntry(){

        /*
         * Select 2 for Match Entry
         *
         */

        $('#detailsMatchEntry').select2(setOptions('{{ route("data.matchentries") }}', 'Match Entries', function (params) {            
            return filterData('code', params.term);
        }, function (data, params) {
            return {
                results: $.map(data, function (obj) {                                
                    return {id: obj.id, text: obj.code+" - "+obj.type_sport.name+" - "+obj.description}
                })
            }
        }));

    }

    // Init add form for Schedule details
    $(document).on("click", "#add-schedule-detail", function () {               

        select2Reset($("#detailsSchedule"));
        select2Reset($("#detailsMatchEntry"));
        filters = {};

    });

    // Set typesport when select
    $('#detailsSchedule').on('select2:select', () => {

        filters['byTypeSportSchedule'] = $('#detailsSchedule').val();
    })

    // Set typesport when select
    // $('#detailsMatchEntry').on('select2:select', () => {
    //     alert($('#detailsMatchEntry').val());
    //     filters = {};
    //     filters['byTypeSport'] = $('#detailsMatchEntry').val();
    // })

    // Set typesport when select
    // $('#detailsMatchEntry').on('select2:select', () => {
    //     alert($('#detailsMatchEntry').val());
    //     filters = {};
    //     // filters['byTypeSport'] = $('#detailsMatchEntry').val();
    // })

    // Set typesport when change
    $('#detailsMatchEntry').on('change', (e) => {

        if($('#detailsMatchEntry').val()){
            filters['byTypeSportScheduleFromMatchEntry'] = $('#detailsMatchEntry').val();
            filters['byTypeSportMatchEntry'] = $('#detailsMatchEntry').val();
            filters['notWithId'] = $('#detailsMatchEntry').val();
        }
    })


</script>
@endsection

