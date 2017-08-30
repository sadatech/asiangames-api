@extends('layouts.app')

@section('header')
<h1 class="page-title"> Branch Sports
	<small>Manage branch sports</small>
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
	        <div class="portlet-body">
	        	<!-- MAIN CONTENT -->
	        	<table class="table table-striped table-hover table-bordered" id="sportsTable">
                	<thead>
                    	<tr>
                    		<th> No. </th>
                        	<th> Sport Name </th>
							<th> Location </th>
                            <th> Description </th>                            
                        </tr>
                    </thead>
				</table>
				<!-- END MAIN CONTENT -->
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
@endsection

@section('additional-scripts')

<script>
	$(document).ready(function () {    	

		$.ajaxSetup({
        	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#sportsTable').dataTable({
	        "processing": true,
	        "serverSide": true,	        
	        "ajax": "{{ route('datatable.sports') }}",
	        "columns": [
	            {data: 'id', name: 'id'},
	            {data: 'name', name: 'name'},
	            {data: 'location', name: 'location'},
	            {data: 'description', name: 'description'}
	        ]
    	});

    });
</script>
@endsection