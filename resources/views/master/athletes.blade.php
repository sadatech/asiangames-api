@extends('layouts.app')

@section('header')
<h1 class="page-title"> Athletes
	<small>Manage Athletes</small>
</h1>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<span>Athletes Management</span>
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
					<i class="fa fa-group font-green"></i>
					<span class="caption-subject font-green sbold uppercase">ATHLETES</span>
				</div>
	        </div>
	        <div class="portlet-body" style="padding: 15px;">
	        	<!-- MAIN CONTENT -->            
	        	<div class="table-toolbar">
                	<div class="row">
                    	<div class="col-md-6">
                        	<div class="btn-group">
                             	<a class="btn green" href="{{ url('athletes/create') }}"><i
									class="fa fa-plus"></i> Add New </a>
                                
                            </div>
                    	</div>
                    </div>
                </div>

	        	<table class="table table-striped table-hover table-bordered" id="athletesTable" style="white-space: nowrap;">
                	<thead>
                    	<tr>
                    		<th> No. </th>
                            <th> Athlete's Name </th>
                            <th> Gender </th>
                        	<th> Height </th>
                            <th> Weight </th>                        
							<th> Country </th>
                            <th> Type Sport </th>
                            <th> Photo </th>
                            <th> Options </th>                             
                        </tr>
                    </thead>
				</table>

                <!-- BEGIN IMAGE MODAL POPUP -->
                <div id="myModal" class="image-modal">
                  <span class="image-modal-close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
                  <img class="image-modal-content" id="image-popup">
                </div>
                <!-- END IMAGE MODAL POPUP -->

                @include('partial.modal.description-modal')

				<!-- END MAIN CONTENT -->
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
@endsection

@section('additional-scripts')

<!-- BEGIN IMAGE MODAL SCRIPTS -->
<script src="{{ asset('js/image-modal/popup.js') }}" type="text/javascript"></script>
<!-- END IMAGE MODAL SCRIPTS -->
<!-- BEGIN TEXT MODAL SCRIPTS -->
<script src="{{ asset('js/text-modal/popup.js') }}" type="text/javascript"></script>
<!-- END TEXT MODAL SCRIPTS -->
<!-- BEGIN RELATION SCRIPTS -->
<script src="{{ asset('js/handler/relation-handler.js') }}" type="text/javascript"></script>
<!-- END RELATION SCRIPTS -->

<script>
	$(document).ready(function () {    	

		$.ajaxSetup({
        	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Set data for Data Table '#athletesTable'
        var table = $('#athletesTable').dataTable({
	        "processing": true,
	        "serverSide": true,	          
	        "ajax": {
                url: "{{ route('datatable.athletes') }}",
                type: 'POST',
            },
	        "rowId": "id",
	        "columns": [
	            {data: 'id', name: 'id'},                
	            {data: 'fullname', name: 'fullname'},
                {data: 'height', name: 'height'},
                {data: 'weight', name: 'weight'},
                {data: 'gender_type', name: 'gender_type'},
                {data: 'country_name', name: 'country_name'},
                {data: 'typesport_name', name: 'typesport_name'},
                {data: 'photo', name: 'photo', searchable: false, sortable: false},
	            {data: 'action', name: 'action', searchable: false, sortable: false},                
	        ],
	        "columnDefs": [
        		{"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [8]}
      		],
            "order": [ [0, 'desc'] ],
    	});


    	// Delete data with sweet alert
        $('#athletesTable').on('click', 'tr td button.deleteButton', function () {
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
                            url:  'athletes/' + id,
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

    });

</script>
@endsection
