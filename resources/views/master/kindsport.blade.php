@extends('layouts.app')

@section('header')
<h1 class="page-title"> Kind Sports
	<small>Manage Kind Sports</small>
</h1>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<span>Kind Sports Management</span>
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
					<span class="caption-subject font-green sbold uppercase">KIND SPORTS</span>
				</div>
	        </div>
	        <div class="portlet-body" style="padding: 15px;">
	        	<!-- MAIN CONTENT -->
	        	<div class="table-toolbar">
                	<div class="row">
                    	<div class="col-md-6">
                        	<div class="btn-group">
                             	<a class="btn green" href="{{ url('kindsport/create') }}"><i
									class="fa fa-plus"></i> Add New </a>

                            </div>
                    	</div>
                    </div>
                </div>

	        	<table class="table table-striped table-hover table-bordered" id="kindsportsTable" style="white-space: nowrap;">
                	<thead>
                    	<tr>
                    		<th> No. </th>                            
                        	<th> Kind Sport's Name </th>
                            <th> Branch Sport </th>                            
                            <th> Description </th>
                            <th> Options </th>                        
                        </tr>
                    </thead>
				</table>

                @include('partial.modal.description-modal')

				<!-- END MAIN CONTENT -->
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
@endsection

@section('additional-scripts')

<!-- BEGIN RELATION SCRIPTS -->
<script src="{{ asset('js/handler/relation-handler.js') }}" type="text/javascript"></script>
<!-- END RELATION SCRIPTS -->
<!-- BEGIN TEXT MODAL SCRIPTS -->
<script src="{{ asset('js/text-modal/popup.js') }}" type="text/javascript"></script>
<!-- END TEXT MODAL SCRIPTS -->

<script>
	$(document).ready(function () {    	

		$.ajaxSetup({
        	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Set data for Data Table '#kindsportsTable'
        var table = $('#kindsportsTable').dataTable({
	        "processing": true,
	        "serverSide": true,	          
	        "ajax": {
                url: "{{ route('datatable.kindsports') }}",
                type: 'POST',
            },
	        "rowId": "id",
	        "columns": [
	            {data: 'id', name: 'id'},
	            {data: 'name', name: 'name'},
                {data: 'branchsport_name', name: 'branchsport_name'},                
	            {data: 'description', name: 'description', sortable: false},
	            {data: 'action', name: 'action', searchable: false, sortable: false},           
	        ],
	        "columnDefs": [
        		{"className": "dt-center", "targets": [0]}
      		],
            "order": [ [0, 'desc'] ],
    	});


    	// Delete data with sweet alert
        $('#kindsportsTable').on('click', 'tr td button.deleteButton', function () {
            var id = $(this).val();

            if(kindTypeRelation(id) > 0){
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
                            url:  'kindsport/' + id,
                            success: function (data) {
                                console.log(data);

                                $("#"+id).remove();
                                // $('#sportsTable').DataTable().ajax.reload();
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });                        

                        swal("Deleted!", "Account has been deleted.", "success");
                    } else {
                        swal("Cancelled", "Account is safe ", "success");
                    }
                });
        });


    });

</script>
@endsection