@include('inc.header')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">

        <!-- Page-Title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">TroubleShooting</h4>
                        <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">CRM TroubleShooting</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            <!-- <div class="dropdown">
                                <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-settings-outline mr-1"></i> Settings
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="timeline" dir="ltr">
                            <div class="timeline-item timeline-left">
                                <div class="timeline-block">
                                    <div class="time-show-btn mt-0">
                                        <a href="#" class="btn btn-info w-lg">TroubleShooting</a>
                                    </div>
                                </div>
                            </div>
                            @foreach($troubleshooting as $key => $trouble)
                            @if($loop->iteration % 2 == 1)
                            <div class="timeline-item">
                                <div class="timeline-block">
                                    <div class="timeline-box card">
                                        <div class="card-body">
                                            <div class="timeline-icon icons-md">
                                                <i class="uim uim-layer-group"></i>
                                            </div>
                                            <div class="d-inline-block py-1 px-3 bg-primary text-white badge-pill">
                                                {{$trouble->heading}}
                                            </div>
                                            <p class="mt-3 mb-2">{{date('Y-m-d', strtotime($trouble->created_at))}}</p>
                                            <div class="text-muted">
                                                <p class="mb-0">{!! $trouble->description !!}</p>
                                                <p class="mt-5">if you are looking for more specific detail just click on the following video link for more detail.</p>
                                                <a href="{{url('public/troubleVideo')}}/{{$trouble->video}}" target="_blank">{{$trouble->video}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif($loop->iteration % 2 == 0)
                            <div class="timeline-item timeline-left">
                                <div class="timeline-block">
                                    <div class="timeline-box card">
                                        <div class="card-body">
                                            <div class="timeline-icon icons-md">
                                                <i class="uim uim-layer-group"></i>
                                            </div>
                                            <div class="d-inline-block py-1 px-3 bg-primary text-white badge-pill">
                                                {{$trouble->heading}}
                                            </div>
                                            <p class="mt-3 mb-2">2015 - 17</p>
                                            <div class="text-muted">
                                                <p class="mb-0">{!! $trouble->description !!}</p>
                                                <p class="mt-5">if you are looking for more specific detail just click on the following video link for more detail.</p>
                                                <a href="{{url('public/troubleVideo')}}/{{$trouble->video}}" target="_blank">{{$trouble->video}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>

                    </div>
                </div>
                <!-- end row -->

            </div>
            <!-- end container-fluid -->
        </div> 
        <!-- end page-content-wrapper -->
    </div>
    <!-- End Page-content -->

@include('inc.footer')
@if(session('msg'))
 <script>alertify.success("{!! session('msg') !!}")</script>
@endif
@if(session('error'))
 <script>alertify.error("{!! session('error') !!}")</script>
@endif
@if(ucfirst(session('role')) == (ucfirst('Admin')))
  @include('admin_SuperAgent_reminders')
@elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
  @include('admin_SuperAgent_reminders')
@elseif(ucfirst(session('role')) == ucfirst('Agent'))
  @include('reminder')
 @elseif(ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
  @include('admin_SuperAgent_reminders')
@endif