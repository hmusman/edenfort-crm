@include('inc.header')
@if(!session("user_id") && ucfirst(session('role'))!=(ucfirst('Admin') || ucfirst('SuperDuperAdmin')))
<script type="text/javascript">
   window.location='{{url("/")}}';
</script>
<?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
    .deals_table thead tr th{
        color:#ffffff;
    }
</style>
<div class="page-wrapper" style="margin-top: 2%;">
<div class="container-fluid">
<div class="row owner_main_row" >
   <h3 class="page_heading">Months</h3>
   <div class="col-12 col-sm-12">
      {!! session('success') !!}
      <div class="card">
         <div class="card-body">
            <div class="table-responsive m-t-10">
               <table class="table deals_table">
                  <thead >
                     <tr >
                        <th class="text-center">Month</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr class="current_com_row">
                        <td class="text-center">
                           <h6><b>{{date("M-Y",strtotime($month->month))}}</b></h6>
                        </td>
                        <td class="text-center">
                            <span style="font-size:12px;background-color:darkgreen;" class="label label-primary">
                                {{$month->status}}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{url('close-month')}}" class="btn btn-danger">Close</a>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         </form>
      </div>
      <style>
         .pagination{
         float:right;
         }
      </style>
   </div>
</div>
@include('inc.footer')
@if(ucfirst(session('role')) == (ucfirst('Admin')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == (ucfirst('SuperAgent')))
      @include('admin_SuperAgent_reminders')
    @elseif(ucfirst(session('role')) == ucfirst('Agent'))
      @include('reminder')
    @elseif(ucfirst(session('role')) == ucfirst('SuperDuperAdmin'))
      @include('admin_SuperAgent_reminders')
    @endif

</body>
</html>