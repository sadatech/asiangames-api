@extends('layouts.app')

@section('header')
<h1 class="page-title"> Countries
	<small>Manage Countries</small>
</h1>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>			
			<a href="{{ url('countries') }}">Countries Management</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<span>
				@if (empty($data))
					Add New Countries
				@else
					Update Countries
				@endif
			</span>
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
					<i class="fa fa-globe font-green"></i>
					<span class="caption-subject font-green sbold uppercase">
						@if (empty($data))
							ADD NEW COUNTRIES
						@else
							UPDATE COUNTRIES
						@endif
					</span>
				</div>

				<div class="btn-group" style="float: right; padding-top: 2px; padding-right: 10px;">
                	<a class="btn btn-md green" href="{{ url('countries/') }}">
                		<i class="fa fa-chevron-left"></i> Back
                	</a>
				</div>
	        </div>
	        <div class="portlet-body" style="padding: 15px;">
	        	<!-- MAIN CONTENT -->
	        	<form id="form_country" class="form-horizontal" action="{{ url('countries', @$data->id) }}" method="POST" enctype="multipart/form-data">	        	
			        {{ csrf_field() }}
			        @if (!empty($data))
			          {{ method_field('PATCH') }}
			        @endif
			        <div class="form-body">
                    	<div class="alert alert-danger display-hide">
                        	<button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                        <div class="alert alert-success display-hide">
                        	<button class="close" data-close="alert"></button> Your form validation is successful! </div>
                        
                        <div class="caption padding-caption">
                        	<span class="caption-subject font-dark bold uppercase">DETAILS</span>
                        	<hr>
                        </div>

                        <div class="form-group">
				          <label class="col-sm-2 control-label">Code</label>
				          <div class="col-sm-9">
				          	<div class="input-icon right">
				          		<i class="fa"></i>
				            	<input type="text" name="code" class="form-control" value="{{ @$data->code }}" placeholder="Input Code" />
				            </div>
				          </div>
				        </div>

				        <div class="form-group">
				          <label class="col-sm-2 control-label">Name</label>
				          <div class="col-sm-9">
				          	<div class="input-icon right">
				          		<i class="fa"></i>
				            	<input type="text" name="name" class="form-control" value="{{ @$data->name }}" placeholder="Input Name" />
				            </div>
				          </div>
				        </div>

				        <div class="form-group">
				          <label class="col-sm-2 control-label">Description</label>
				          <div class="col-sm-9">
				          	<div class="input-icon right">
				          		<i class="fa"></i>
				          		<textarea name="description" class="form-control" rows="5" placeholder="Description about this country..">{{ @$data->description }}</textarea>
				          	</div>
				          </div>
				        </div>

				        <!-- View for old image * FLAG * -->
				        @if (!empty($data))

				        <div class="caption padding-caption">
                        	<span class="caption-subject font-dark bold uppercase">FLAG</span>
                        	<hr>
                        </div>

				        
				        	<div class="form-group">
				          		<label class="col-sm-2 control-label">Flag</label>
				         		<div class="col-sm-9">				          	
					    			<img width="90px" height="90px" src="{{ @$data->flag }}" onError="this.onerror=null;this.src='{{ asset('image/missing.png') }}';">
				         		</div>
				        	</div>

			          		<div class="form-group">
				          		<label class="col-sm-2 control-label">Flag URL</label>
				         		<div class="col-sm-9">				          	
					    			<input type="text" class="form-control" value="{{ @$data->flag }}" disabled="disabled" />
					    		</div>
				        	</div>
			        	@endif

					    <div class="form-group">
				          <label class="col-sm-2 control-label">{{ (!empty($data)) ? 'New ' : ' ' }}Flag</label>
				          <div class="col-sm-9">
				          	<div class="input-group" style="width: 100%;">
					          	<input type="file" accept=".jpg,.jpeg,.png,.gif,.svg" class="form-control" id="flag_file" name="flag_file">
					          	<p style="font-size: 10pt;" class="help-block"> (Type of file: jpg, jpeg, png, gif, svg - Max size : 2 MB) </p>
					          	<div class="file_error_message" style="display: none;"></div>
					      	</div>
				          </div>
				        </div>				     
				        
				        <div class="form-group" style="padding-top: 15pt;">
				          <div class="col-sm-9 col-sm-offset-2">
				            <button type="submit" class="btn btn-primary green">Save</button>
				          </div>
				        </div>
			    	</div>
			    </form>
				<!-- END MAIN CONTENT -->
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
@endsection

@section('additional-scripts')
	<!-- BEGIN PAGE VALIDATION SCRIPTS -->
    <script src="{{ asset('js/handler/countries-handler.js') }}" type="text/javascript"></script>
    <!-- END PAGE VALIDATION SCRIPTS -->
    <script>
		$(document).ready(function () {
			$.ajaxSetup({
	        	headers: {
	            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	        });	        

		});
	</script>
@endsection