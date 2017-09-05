@extends('layouts.app')

@section('header')
<h1 class="page-title"> Branch Sports
	<small>Manage Branch Sports</small>
</h1>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<span>Branch Sports Management</span>
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
					<i class="icon-social-dribbble font-green"></i>
					<span class="caption-subject font-green sbold uppercase">BRANCH SPORTS</span>
				</div>
	        </div>
	        <div class="portlet-body" style="padding: 15px;">
	        	<!-- MAIN CONTENT -->
	        	<div class="table-toolbar">
                	<div class="row">
                    	<div class="col-md-6">
                        	<div class="btn-group">
                             	<a class="btn green" href="{{ url('branchsport/create') }}"><i
									class="fa fa-plus"></i> Add New </a>

                            </div>
                    	</div>
                    </div>
                </div>

	        	<table class="table table-striped table-hover table-bordered" id="sportsTable" style="white-space: nowrap;">
                	<thead>
                    	<tr>
                    		<th> No. </th>
                            <th> Icon </th>
                        	<th> Sport Name </th>
							<th> Location </th>
                            <th> Description </th>
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

        // Set data for Data Table '#sportsTable'
        var table = $('#sportsTable').dataTable({
	        "processing": true,
	        "serverSide": true,	          
	        "ajax": {
                url: "{{ route('datatable.branchsports') }}",
                type: 'POST',
            },
	        "rowId": "id",
	        "columns": [
	            {data: 'id', name: 'id'},
                {data: 'icon', name: 'icon', searchable: false, sortable: false},
	            {data: 'name', name: 'name'},
	            {data: 'location', name: 'location'},
	            {data: 'description', name: 'description', sortable: false},
                {data: 'photo', name: 'photo', searchable: false, sortable: false},
	            {data: 'action', name: 'action', searchable: false, sortable: false},                
	        ],
	        "columnDefs": [
        		{"className": "dt-center", "targets": [0]}
      		],
            "order": [ [0, 'desc'] ],
    	});


    	// Delete data with sweet alert
        $('#sportsTable').on('click', 'tr td button.deleteButton', function () {
            var id = $(this).val();

            // alert(branchKindRelation(id));            
            // return;

            if(branchKindRelation(id) > 0){
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
                            url:  'branchsport/' + id,
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



  //   	swal({
		//   title: "Error!",
		//   text: "Here's my error message!",
		//   type: "error",
		//   confirmButtonText: "Cool"
		// });	

    });
</script>
@endsection