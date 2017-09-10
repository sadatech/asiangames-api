@extends('layouts.app')

@section('header')
<h1 class="page-title"> Match Entries
	<small>Manage Match Entries</small>
</h1>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<span>Match Entries Management</span>
		</li>
	</ul>                        
</div>
@endsection

@section('content')

@inject('service','App\Services\CodeService')

<div class="row">
	<div class="col-lg-12 col-lg-3 col-md-3 col-sm-6 col-xs-12">
	    <!-- BEGIN EXAMPLE TABLE PORTLET-->
	    <div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-support font-green"></i>
					<span class="caption-subject font-green sbold uppercase">MATCH ENTRIES</span>
				</div>
	        </div>
	        <div class="portlet-body" style="padding: 15px;">
	        	<!-- MAIN CONTENT -->

                <div class="row">

                    <!-- BEGIN MATCH ENTRY -->
                    <div class="col-md-7">

        	        	<div class="table-toolbar">
                        	<div class="row">
                            	<div class="col-md-12">
                                	<div class="btn-group">
                                     	<a id="add-match-entry" class="btn green" data-toggle="modal" href="#match-entry"><i
        									class="fa fa-plus"></i> Add Match Entry </a>

                                    </div>
                            	</div>
                            </div>
                        </div>

        	        	<table class="table table-striped table-hover table-bordered" id="matchEntriesTable" style="white-space: nowrap;">
                        	<thead>
                            	<tr>
                            		<th> No. </th>                            
                                	<th> Code </th>                            
                                    <th> Type Sport </th>                            
                                    <th> Description </th>
                                    <th> Options </th>                        
                                </tr>
                            </thead>
        				</table>

                    </div>
                    <!-- END MATCH ENTRY -->

                    <!-- BEGIN MATCH GROUPING -->
                    <div class="col-md-5">

                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-12" style="text-align: right;">
                                    <div class="btn-group">
                                        <a id="add-match-grouping" class="btn green" data-toggle="modal" href="#match-grouping"><i
                                            class="fa fa-plus"></i> Add Participant </a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped table-hover table-bordered" id="matchEntriesTable" style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th> No. </th>                            
                                    <th> Name </th>                            
                                    <th> Country </th>                                                                
                                    <th> Options </th>                        
                                </tr>
                            </thead>
                        </table>

                    </div>
                    <!-- END MATCH GROUPING -->

                </div>

                @include('partial.modal.match-entry-modal')

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
<!-- BEGIN RELATION SCRIPTS -->
<script src="{{ asset('js/handler/relation-handler.js') }}" type="text/javascript"></script>
<!-- END RELATION SCRIPTS -->
<!-- BEGIN TEXT MODAL SCRIPTS -->
<script src="{{ asset('js/text-modal/popup.js') }}" type="text/javascript"></script>
<!-- END TEXT MODAL SCRIPTS -->
<!-- BEGIN PAGE VALIDATION SCRIPTS -->
<script src="{{ asset('js/handler/match-entries-handler.js') }}" type="text/javascript"></script>
<!-- END PAGE VALIDATION SCRIPTS -->

<script>

    // MATCH ENTRY
	$(document).ready(function () {                

		$.ajaxSetup({
        	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Set data for Data Table '#matchEntriesTable'
        var table = $('#matchEntriesTable').dataTable({
	        "processing": true,
	        "serverSide": true,	          
	        "ajax": {
                url: "{{ route('datatable.matchentries') }}",
                type: 'POST',
            },
	        "rowId": "id",
	        "columns": [
	            {data: 'id', name: 'id', visible: false},
	            {data: 'code', name: 'code'},                
                {data: 'typesport_name', name: 'typesport_name'},                
	            {data: 'description', name: 'description', sortable: false},
	            {data: 'action', name: 'action', searchable: false, sortable: false},           
	        ],
	        "columnDefs": [
        		{"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [4]},
      		],
            "order": [ [0, 'desc'] ],
    	});


    	// Delete data with sweet alert
        $('#matchEntriesTable').on('click', 'tr td button.deleteButton', function () {
            var id = $(this).val();

            // if(kindTypeRelation(id) > 0){
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
                            url:  'matchentries/' + id,
                            success: function (data) {
                                console.log(data);

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
        initSelect2();

    });

    // Init add form for Match Entry
    $(document).on("click", "#add-match-entry", function () {       
        
        resetValidation();

        var modalTitle = document.getElementById('matchEntryTitle');
        modalTitle.innerHTML = "ADD";

        $('#matchEntryCode').val('{{ $service->getMatchEntryCode() }}');
        $('#matchEntryDescription').val('');
        select2Reset($("#matchEntryTypeSport"));

    });


    // For editing data => Match Entry
    $(document).on("click", ".edit-match-entry", function () {

        resetValidation();       
        
        var modalTitle = document.getElementById('matchEntryTitle');
        modalTitle.innerHTML = "EDIT";

        var id = $(this).data('id');
        var getDataUrl = "{{ url('matchentries/edit/') }}";
        var postDataUrl = "{{ url('matchentries') }}"+"/"+id;        

        // Set action url form for update        
        $("#form_match_entries").attr("action", postDataUrl);

        // Set Patch Method
        if(!$('input[name=_method]').length){
            $("#form_match_entries").append("<input type='hidden' name='_method' value='PATCH'>");
        }

        $.get(getDataUrl + '/' + id, function (data) {

                    $('#matchEntryCode').val(data.code);

                    setSelect2IfPatchModal($("#matchEntryTypeSport"), data.typesport_id, data.type_sport.name);

                    $('#matchEntryDescription').val(data.description);

                })
    });

    function initSelect2(){

        /*
         * Select 2 for Match Entry
         *
         */

        $('#matchEntryTypeSport').select2(setOptions('{{ route("data.typesports") }}', 'Type Sport', function (params) {            
            return filterData('name', params.term);
        }, function (data, params) {
            return {
                results: $.map(data, function (obj) {                                
                    return {id: obj.id, text: obj.name}
                })
            }
        }));

    }

    

</script>
@endsection