@extends('layouts.app')

@section('header')
<h1 class="page-title"> Dashboard
	<small>Dashboard Asian Games Panel</small>
</h1>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<span>Dashboard</span>
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
					<i class="icon-settings font-green"></i>
					<span class="caption-subject font-green sbold uppercase">DASHBOARD</span>
				</div>
	        </div>
	        <div class="portlet-body">
	        	<!-- MAIN CONTENT -->
	        	<p>Lorem ipsum dolor sit amet, nam illud apeirian ex. Eam ne ludus primis, quas percipitur mea ea. Te vis dictas albucius. Omnesque scaevola vel an. His an movet eloquentiam, no affert graece gubergren eam, saepe tempor phaedrum vel id. Usu id primis pericula torquatos, pro in abhorreant percipitur.

				Sea tota doming salutandi cu, ut ubique oporteat cotidieque his, wisi interesset reformidans ea eam. Mel te augue oporteat consetetur, et nobis denique pri. Detracto adversarium vel ne, graeci ocurreret vulputate cu his, vis melius urbanitas ut. Vis ne debet molestie sapientem, an sed odio lorem doming. His eu epicuri signiferumque.</p>

				<p>Lorem ipsum dolor sit amet, nam illud apeirian ex. Eam ne ludus primis, quas percipitur mea ea. Te vis dictas albucius. Omnesque scaevola vel an. His an movet eloquentiam, no affert graece gubergren eam, saepe tempor phaedrum vel id. Usu id primis pericula torquatos, pro in abhorreant percipitur.

				Sea tota doming salutandi cu, ut ubique oporteat cotidieque his, wisi interesset reformidans ea eam. Mel te augue oporteat consetetur, et nobis denique pri. Detracto adversarium vel ne, graeci ocurreret vulputate cu his, vis melius urbanitas ut. Vis ne debet molestie sapientem, an sed odio lorem doming. His eu epicuri signiferumque.</p>

				<p>Lorem ipsum dolor sit amet, nam illud apeirian ex. Eam ne ludus primis, quas percipitur mea ea. Te vis dictas albucius. Omnesque scaevola vel an. His an movet eloquentiam, no affert graece gubergren eam, saepe tempor phaedrum vel id. Usu id primis pericula torquatos, pro in abhorreant percipitur.

				Sea tota doming salutandi cu, ut ubique oporteat cotidieque his, wisi interesset reformidans ea eam. Mel te augue oporteat consetetur, et nobis denique pri. Detracto adversarium vel ne, graeci ocurreret vulputate cu his, vis melius urbanitas ut. Vis ne debet molestie sapientem, an sed odio lorem doming. His eu epicuri signiferumque.</p>
				<!-- END MAIN CONTENT -->
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>
	
@endsection