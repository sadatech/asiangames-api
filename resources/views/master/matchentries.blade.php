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

<div class="row">
	<div class="col-lg-12 col-lg-3 col-md-3 col-sm-6 col-xs-12">
	    <!-- BEGIN EXAMPLE TABLE PORTLET-->
	    <div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-ticket font-green"></i>
					<span class="caption-subject font-green sbold uppercase">MATCH ENTRIES</span>
				</div>
	        </div>
	        <div class="portlet-body" style="padding: 15px;">
	        	<!-- MAIN CONTENT -->

                <div class="row">

                    <!-- BEGIN MATCH ENTRY -->
                    <div class="col-md-7" id="matchEntryContent">

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
                                    <th> Gender </th>
                                    <th> Description </th>
                                    <th> Options </th>                        
                                </tr>
                            </thead>
        				</table>

                    </div>
                    <!-- END MATCH ENTRY -->

                    <!-- BEGIN MATCH GROUPING -->
                    <div class="col-md-5" id="matchGroupContent">

                        <form id="form_match_groups" class="form-horizontal" action="{{ url('matchgroups') }}" method="POST">

                        {{ csrf_field() }}
                        <input type="hidden" name="matchentry_id" id="matchGroupMatchEntryId">

                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-12" style="vertical-align: middle; line-height: 34px;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Match Entry Selected                                            
                                        </div>
                                        <div class="col-md-1" style="padding: 0; width: 1px;">
                                            :                               
                                        </div>                                        
                                        <div class="col-md-7">                                            
                                            <span id="selected-code-label" class="label label-primary" style="padding: 7px;"></span>
                                        </div>
                                    </div>                                    
                                </div>                            
                            </div>

                            <div class="row" style="padding-top: 16px;">
                                <div class="col-md-12" style="vertical-align: middle; line-height: 34px;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Search Athlete                                    
                                        </div>
                                        <div class="col-md-1" style="padding: 0; width: 1px;">
                                            :                               
                                        </div>                                       
                                        <div class="col-md-7">                                            
                                            <select class="select2select" name="athlete_id" id="matchGroupAthlete" required></select>
                                        </div>
                                    </div>                                    
                                </div>                            
                            </div>

                            <div class="row" style="padding-top: 16px;">
                                <div class="col-md-12" style="vertical-align: middle; line-height: 34px;">
                                    <button type="submit" class="btn btn-primary green"><i
                                            class="fa fa-plus"></i> Add Participant</button>
                                </div>                  
                            </div>

                        </div>

                        </form>


                        <table class="table table-striped table-hover table-bordered" id="matchGroupsTable" style="white-space: nowrap;">
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

                @include('partial.modal.match-group-modal')

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
<!-- BEGIN MATCH GROUP SCRIPTS -->
<script src="{{ asset('js/handler/match-groups-handler.js') }}" type="text/javascript"></script>
<!-- END MATCH GROUP SCRIPTS -->
<!-- BEGIN SERVICE SCRIPTS -->
<script src="{{ asset('js/handler/service-handler.js') }}" type="text/javascript"></script>
<!-- END SERVICE SCRIPTS -->

<script>

    /*
     * MATCH ENTRY
     *
     */
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
	            {data: 'id', name: 'id', visible: false, searchable: false},
	            {data: 'code', name: 'code'},                
                {data: 'typesport_name', name: 'typesport_name'},
                {data: 'gender_type', name: 'gender_type'},
	            {data: 'description', name: 'description', sortable: false},
	            {data: 'action', name: 'action', searchable: false, sortable: false},           
	        ],
	        "columnDefs": [
        		{"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [3]},
      		],
            "order": [ [1, 'desc'] ],
    	});


    	// Delete data with sweet alert
        $('#matchEntriesTable').on('click', 'tr td button.deleteButton', function () {
            var id = $(this).val();

            if(athleteMatchGroupRelation(id) > 0){
                swal("Warning", "This data still related to others! Please check the relation first.", "warning");
                return;
            }

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
                                // console.log(data);

                                $("#ME"+id).remove();
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
        initSelect2MatchEntry();

    });

    // Init add form for Match Entry
    $(document).on("click", "#add-match-entry", function () {       
        
        resetValidation();

        var modalTitle = document.getElementById('matchEntryTitle');
        modalTitle.innerHTML = "ADD";

        // Get Generated Code => 'service-handler.js'
        var matchEntryCode = getMatchEntryCode();

        $('#matchEntryCode').val(matchEntryCode);        
        $('#matchEntryDescription').val('');
        select2Reset($("#matchEntryTypeSport"));

        // Set action url form for add
        var postDataUrl = "{{ url('matchentries') }}";    
        $("#form_match_entries").attr("action", postDataUrl);

        // Delete Patch Method if Exist
        if($('input[name=_method]').length){
            $('input[name=_method]').remove();
        }

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

    function initSelect2MatchEntry(){

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

    // If datatable change
    $('#matchEntriesTable').on( 'draw.dt', function () {        
        resetSelectedMatch();
    });

    // Change highlight when hover
    $(document).on("mouseover", ".code-label", function () {
        if(!$(this).hasClass('selected')) $(this).addClass('label label-primary');        
    });

    $(document).on("mouseout", ".code-label", function () {
        if(!$(this).hasClass('selected')) $(this).removeClass('label label-primary');
    });

    // Set selected match entry
    $(document).on("click", ".code-label", function () {
        // console.log($(this).data('code'));
        resetSelectedMatch();
        document.getElementById('selected-code-label').innerHTML = $(this).data('code');

        $(".code-label").removeClass('label label-primary selected');
        $(this).addClass('label label-primary selected');

        // Set Match Group Function
        setMatchGroup($(this).data('id'));

        matchGroupShow();
    });    

    function resetSelectedMatch(){            
        matchGroupHide();
        document.getElementById('selected-code-label').innerHTML = "";
        resetDataTableGroup();
        $('#matchGroupMatchEntryId').val('');
    }


    /*
     * MATCH GROUPING
     *
     */

     $(document).ready(function () {                

        initDataTableGroup();
        // if($.fn.dataTable.isDataTable('#matchGroupsTable')){
        //                     $('#matchGroupsTable').DataTable().clear();
        //                     $('#matchGroupsTable').DataTable().destroy();
        //                 }
        //                 initDataTableGroup(1);

    });

    function setMatchGroup(id){
        //Init datatable
        initDataTableGroup(id);

        // Init select2
        initSelect2MatchGroup(id);

        // Input match entry hidden
        $('#matchGroupMatchEntryId').val(id);
    }

    function initDataTableGroup(id){

        // Set data for Data Table '#matchGroupsTable'
        var table = $('#matchGroupsTable').dataTable({
            "processing": true,
            "serverSide": true,           
            "ajax": {
                url: "{{ route('datatable.matchgroups') }}",
                type: 'POST',
                data: { matchentry_id: id }
            },
            "rowId": "id",
            "columns": [
                {data: 'id', name: 'id', visible: false},
                {data: 'fullname', name: 'fullname'},                
                {data: 'country', name: 'country'},                                
                {data: 'action', name: 'action', searchable: false, sortable: false},           
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},                
                {"className": "dt-center", "targets": [3]},
            ],
            "order": [ [0, 'desc'] ],
            "paging": false,
            "info": false,
        })
    }

    function resetDataTableGroup(){
        if($.fn.dataTable.isDataTable('#matchGroupsTable')){
            $('#matchGroupsTable').DataTable().clear();
            $('#matchGroupsTable').DataTable().destroy();
        }

        // $('#matchGroupContent').addClass('display-hide');
    }

    // Delete data with sweet alert
    $('#matchGroupsTable').on('click', 'tr td button.deleteButton', function () {
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
                        url:  'matchgroups/' + id,
                        success: function (data) {
                            // console.log(data);

                            $("#MG"+id).remove();
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

    function initSelect2MatchGroup(id){

        /*
         * Select 2 for Match Group
         *
         */

        $('#matchGroupAthlete').select2(setOptions('{{ route("data.athletes") }}', 'Athlete', function (params) {            
            filters = {};
            filters['notInMatchEntry'] = id;
            return filterData('name', params.term);
        }, function (data, params) {
            return {
                results: $.map(data, function (obj) {                                
                    return {id: obj.id, text: obj.firstname+" "+obj.lastname+" ("+obj.country.name+")"}
                })
            }
        }));

    }


    /*
     * Column adaptable
     *
     */

     function matchGroupShow(){
        // $('#matchEntryContent').removeClass('col-md-12').addClass('col-md-7');
        $('#matchGroupContent').removeClass('display-hide');
     }

     function matchGroupHide(){
        // $('#matchEntryContent').removeClass('col-md-7').addClass('col-md-12');
        $('#matchGroupContent').addClass('display-hide');
     }


</script>
@endsection
