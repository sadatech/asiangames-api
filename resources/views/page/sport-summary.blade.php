@extends('layouts.app')

@section('header')
<h1 class="page-title"> Sports Summary
	<small>Summary Data for Sports</small>
</h1>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<span>Sports Summary</span>
		</li>
	</ul>                        
</div>
@endsection

@section('content')

<div class="row">
	<!-- BEGIN WIDGET DIV -->
	<div class="row widget-row">
	    <div class="col-md-4">
	        <!-- BEGIN WIDGET THUMB -->
	        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
	            <h4 class="widget-thumb-heading">Branch Sport(s)</h4>
	            <div class="widget-thumb-wrap">
	                <i class="widget-thumb-icon bg-green icon-social-dribbble"></i>
	                <div class="widget-thumb-body">
	                    <span class="widget-thumb-subtitle">Total</span>
	                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{ (@$countBranchSports) ? $countBranchSports : 0 }}">0</span>
	                </div>
	            </div>
	        </div>
	        <!-- END WIDGET THUMB -->
	    </div>
	    <div class="col-md-4">
	        <!-- BEGIN WIDGET THUMB -->
	        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
	            <h4 class="widget-thumb-heading">Kind of Sport(s)</h4>
	            <div class="widget-thumb-wrap">
	                <i class="widget-thumb-icon bg-red icon-support"></i>
	                <div class="widget-thumb-body">
	                    <span class="widget-thumb-subtitle">Total</span>
	                    <span id="countKind" class="widget-thumb-body-stat" data-counter="counterup" data-value="{{ (@$countKindSports) ? $countKindSports : 0 }}">0</span>
	                </div>
	            </div>
	        </div>
	        <!-- END WIDGET THUMB -->
	    </div>
	    <div class="col-md-4">
	        <!-- BEGIN WIDGET THUMB -->
	        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
	            <h4 class="widget-thumb-heading">Type of Sport(s)</h4>
	            <div class="widget-thumb-wrap">
	                <i class="widget-thumb-icon bg-purple fa fa-soccer-ball-o"></i>
	                <div class="widget-thumb-body">
	                    <span class="widget-thumb-subtitle">Total</span>
	                    <span id="countType" class="widget-thumb-body-stat" data-counter="counterup" data-value="{{ (@$countTypeSports) ? $countTypeSports : 0 }}">0</span>
	                </div>
	            </div>
	        </div>
	        <!-- END WIDGET THUMB -->
	    </div>
	</div>
	<!-- END WIDGET DIV -->
</div>

<div class="row">
	<div class="col-lg-12 col-lg-3 col-md-3 col-sm-6 col-xs-12">
	    <!-- BEGIN EXAMPLE TABLE PORTLET-->
	    <div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-settings font-green"></i>
					<span class="caption-subject font-green sbold uppercase">Sports List</span>
				</div>
	        </div>
	        <div class="portlet-body">
	        	<!-- MAIN CONTENT -->

	        	<div class="row" style="margin-bottom: 20px;">

	        		<!-- BRANCH SPORT LIST -->
		        	<div class="col-md-4">
		        		<div class="mt-element-list">
                            <div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">
                                <div class="list-head-title-container">                                
                                    <h4 class="list-title">
                                    	<i class="icon-social-dribbble"></i>
                                    	&nbsp;Branch Sports
                                    </h4>
                                </div>
                            </div>
                            <div class="mt-list-container list-simple ext-1">
                                <ul id="branchSportList" style="height: 330px;overflow-x:hidden; overflow-y:scroll;">
                                                           
                                </ul>
                            </div>
                            <div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">
                                <div class="list-head-title-container">                                    

                                </div>
                            </div>
                        </div>
		        	</div>

		        	<!-- KIND SPORT LIST -->
		        	<div id="kindSportColumn" class="col-md-4" style="display: none;">
		        		<div class="mt-element-list">
                            <div class="mt-list-head list-simple ext-1 font-white bg-red">
                                <div class="list-head-title-container">                                    
                                    <h4 class="list-title">
                                    	<i class="icon-support"></i>
                                    	&nbsp;Branch Sports
                                    </h4>
                                </div>
                            </div>
                            <div class="mt-list-container list-simple ext-1">
                                <ul id="kindSportList">
                                                           
                                </ul>
                            </div>
                            <div class="mt-list-head list-simple ext-1 font-white bg-red">
                                <div class="list-head-title-container">                                    

                                </div>
                            </div>
                        </div>
		        	</div>

		        	<!-- TYPE SPORT LIST -->
		        	<div id="typeSportColumn" class="col-md-4" style="display: none;">
		        		<div class="mt-element-list">
                            <div class="mt-list-head list-simple ext-1 font-white bg-purple">
                                <div class="list-head-title-container">                                    
                                    <h4 class="list-title">
                                    	<i class="fa fa-soccer-ball-o"></i>
                                    	&nbsp;Branch Sports
                                    </h4>
                                </div>
                            </div>
                            <div class="mt-list-container list-simple ext-1">
                                <ul id="typeSportList">
                                                           
                                </ul>
                            </div>
                             <div class="mt-list-head list-simple ext-1 font-white bg-purple">
                                <div class="list-head-title-container">                                    
                                </div>
                            </div>
                        </div>
		        	</div>

	        	</div>


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

		// Init module
        branchSportList();
	});

	/* 
	 * Fungsi buat nampilin list sport 
	 *
	 */

	/** Brranch Sport List **/
	function branchSportList(){
		$("#branchSportList").empty();

		$.ajax({
	        url: "{{ route('data.branchsports') }}",
	        type: 'POST',
	        dataType: 'json',
	        global: false,
        	async: false,
	        success: function (data) {	        	
				return {
                    results: $.map(data, function (obj) {                                
                        branchSportAdd(obj.id, obj.icon, obj.name);
                    })
                }     
	        }
	    });
	}

	// Fungsi buat nambah list -> Branch Sport
	function branchSportAdd(id, imageParam, textParam){

  		var element = 	"<li class='branchsportlist mt-list-item sport-block' onclick='branchSportSelect(this, "+id+")'>"+
	  					  	"<div class='row sport-block-content'>"+
	                        	"<div class='col-md-2 sport-block-icon'>"+
	                            	"<img width='30px' height='30px' src='"+ imageParam +"'>"+
	                            "</div>"+
	                        	"<div class='col-md-8'>"+ textParam +"</div>"+
	                        	"<div class='col-md-2 sport-block-icon'>"+
	                        		"<i class='branchsporticon fa'></i>"+
	                        	"</div>"+
	                        "</div>"+
                    	"</li>";

  		$("#branchSportList").append(element);
	}

	// Function Branch Sport Selection
	$(function () {
	    branchSportSelect = function (element, id) {	    	

	        // Remove all highlight in list
	        $('.branchsportlist').each(function() {
	        	$(this).removeClass('sport-block-selected');
			});

			// Add highlight
			$(element).addClass('sport-block-selected');

	        // Remove all icon in list
	        $('.branchsporticon').each(function() {
	        	$(this).removeClass('fa-chevron-circle-right');
			});

	        // Add icon
	        var icon = $(element).find('i');
	        icon.addClass('fa-chevron-circle-right');

	        kindSportList(id);	       

	    };
	});

	/** Kind Sport List **/
	function kindSportList(id){
		$("#kindSportList").empty();
		// Type sport empty
		$("#typeSportList").empty();
		$("#typeSportColumn").attr("style", "display: none;");

		$.ajax({
	        url: "{{ route('data.kindsports') }}",
	        type: 'POST',
	        data: { whereBranchSport: id },
	        dataType: 'json',                        
	        success: function (data) {
	        	if(!$.trim(data)){
	        		$("#kindSportColumn").attr("style", "display: none;");
	        	}else{
	        		$("#kindSportColumn").removeAttr("style");
	        	}
				return {
                    results: $.map(data, function (obj) {                                
                        kindSportAdd(obj.id, obj.name);
                    })
                }     
	        }
	    });
	}

	// Fungsi buat nambah list -> Kind Sport
	function kindSportAdd(id, textParam){

  		var element = 	"<li class='kindsportlist mt-list-item sport-block' onclick='kindSportSelect(this, "+id+")'>"+
	  					  	"<div class='row sport-block-content'>"+
	                        	"<div class='col-md-10'>"+ textParam +"</div>"+
	                        	"<div class='col-md-2 sport-block-icon'>"+
	                        		"<i class='kindsporticon fa'></i>"+
	                        	"</div>"+
	                        "</div>"+
                    	"</li>";

  		$("#kindSportList").append(element);
	}

	// Function Kind Sport Selection
	$(function () {
	    kindSportSelect = function (element, id) {	    	

	        // Remove all highlight in list
	        $('.kindsportlist').each(function() {
	        	$(this).removeClass('sport-block-selected');
			});

			// Add highlight
			$(element).addClass('sport-block-selected');

	        // Remove all icon in list
	        $('.kindsporticon').each(function() {
	        	$(this).removeClass('fa-chevron-circle-right');
			});

	        // Add icon
	        var icon = $(element).find('i');
	        icon.addClass('fa-chevron-circle-right');

	        typeSportList(id);

	    };
	});

	/** Type Sport List **/
	function typeSportList(id){
		$("#typeSportList").empty();

		$.ajax({
	        url: "{{ route('data.typesports') }}",
	        type: 'POST',
	        data: { whereKindSport: id },
	        dataType: 'json',                        
	        success: function (data) {
	        	if(!$.trim(data)){
	        		$("#typeSportColumn").attr("style", "display: none;");
	        	}else{
	        		$("#typeSportColumn").removeAttr("style");
	        	}
				return {
                    results: $.map(data, function (obj) {                                
                        typeSportAdd(obj.id, obj.name);
                    })
                }     
	        }
	    });
	}

	// Fungsi buat nambah list -> Type Sport
	function typeSportAdd(id, textParam){

  		var element = 	"<li class='typesportlist mt-list-item sport-block' onclick='typeSportSelect(this, "+id+")'>"+
	  					  	"<div class='row sport-block-content'>"+
	                        	"<div class='col-md-10'>"+ textParam +"</div>"+
	                        	"<div class='col-md-2 sport-block-icon'>"+
	                        		"<i class='typesporticon fa'></i>"+
	                        	"</div>"+
	                        "</div>"+
                    	"</li>";

  		$("#typeSportList").append(element);
	}

	// Function Type Sport Selection
	$(function () {
	    typeSportSelect = function (element, id) {	    	

	        // Remove all highlight in list
	        $('.typesportlist').each(function() {
	        	$(this).removeClass('sport-block-selected');
			});

			// Add highlight
			$(element).addClass('sport-block-selected');

	    };
	});


</script>
@endsection
