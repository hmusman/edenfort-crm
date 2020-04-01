@include('inc.header')
@if(!session("user_id") || ucfirst(session('role'))!=ucfirst('Admin'))
  <script type="text/javascript">
    window.location='{{url("/")}}';
  </script>
  <?php redirect('/'); ?>
@endif
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{url('public/assets/css/additional.css')}}">
<style>
    .font-size{
        font-size:12px;
    }
    .MultiCheckBox {
            border:1px solid #e2e2e2;
            padding: 5px;
            border-radius:4px;
            cursor:pointer;
            font-size: 13px;
            height: 40px;
            padding: 10px;
        }

        .MultiCheckBox .k-icon{ 
            font-size: 15px;
            float: right;
            font-weight: bolder;
            margin-top: -7px;
            height: 10px;
            width: 14px;
            color:#787878;
        } 

        .MultiCheckBoxDetail {
            display:none;
            position:absolute;
            border:1px solid #e2e2e2;
            overflow-y:hidden;
            background-color: white;
            font-size: 12px;
            width: 86%;
        }

        .MultiCheckBoxDetailBody {
            overflow-y:scroll;
        }

            .MultiCheckBoxDetail .cont  {
                clear:both;
                overflow: hidden;
                padding: 2px;
            }

            .MultiCheckBoxDetail .cont:hover  {
                background-color: #1976d2;
                color: white;
            }

            .MultiCheckBoxDetailBody > div > div {
                float:left;
                padding-left: 6px;
            }

        .MultiCheckBoxDetail>div>div:nth-child(1) {
        
        }

        .MultiCheckBoxDetailHeader {
            overflow:hidden;
            position:relative;
            height: 28px;
            background-color: #1976d2;
            padding-left: 9px;
            padding-top: 3px;
        }

            .MultiCheckBoxDetailHeader>input {
                position: absolute;
                top: 4px;
                left: 3px;
            }

            .MultiCheckBoxDetailHeader>div {
                position: absolute;
                top: 5px;
                left: 24px;
                color:#fff;
            }
</style>
<div class="page-wrapper" style="margin-top: 2%;">
<div class="container-fluid">
    <div class="row owner_main_row">
        <h3 class="page_heading">Direct Report</h3><br>
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom:0px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="agent" class="font-size">Select Agent</label>
                                <select id="agent" name="agent" class="form-control font-size" required>
                                    <option value="">Select Agent</option>
                                    @foreach($agents as $agent)
                                        <option value="{{$agent->id}}">{{$agent->user_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label for="report_type" class="font-size">Select Report Type</label>
                                <select id="report_type" name="report_type" class="form-control font-size" required>
                                    <option value="property">Agent Property</option>
                                    <option value="lead">Agent Lead</option>
                                    <option value="coldcallings">Agent ColdCallings</option>
                                </select>
                            </div>
                            <div class="col-sm-2" id="selected">
                                <label for="access_type" class="font-size">Access Type</label>
                                 <select id="access_type" class="form-control font-size" required>
                                    <!-- <option value="Pending">Pending</option> -->
                                    <option value="Call Back">Call Back</option>
                                    <option value="Not Answering">Not Answering</option>
                                    <option value="Not Interested">Not Interested</option>
                                    <option value="Interested">Interested</option>
                                    <option value="For Sale">For Sale</option>
                                    <option value="For Rent">For Rent</option>
                                    <option value="Upcoming">Upcoming</option>
                                    <option value="Off Plan">Off Plan</option>
                                    <option value="Investor">Investor</option>
                                    <option value="Check Availability">Check Availability</option>
                                    <option value="Switch Off">Switch Off</option>
                                    <option value="Wrong Number">Wrong Number</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Follow Up">Follow Up</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="font-size">From Date</label>
                                <input type="date" class="font-size form-control" name="from_date">
                            </div>
                            <div class="col-sm-2">
                                <label class="font-size">TO Date</label>
                                <input type="date" class="font-size form-control" name="to_date">
                            </div>
                            <div class="col-sm-1" style="padding-top: 32px;">
                                <button type="submit" class="font-size btn btn-danger"><b><span><i class="fa fa-file-pdf-o" ></i></span> Generate Report</b></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('inc.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" rel="stylesheet">
 <script>
        $(document).ready(function () {
            $("#access_type").CreateMultiCheckBox({defaultText : 'Select Access Type', height:'250px' });
        });
    </script>
<script>
            $(document).ready(function () {
            $(document).on("click", ".MultiCheckBox", function () {
                var detail = $(this).next();
                detail.show();
            });

            $(document).on("click", ".MultiCheckBoxDetailHeader input", function (e) {
                e.stopPropagation();
                var hc = $(this).prop("checked");
                $(this).closest(".MultiCheckBoxDetail").find(".MultiCheckBoxDetailBody input").prop("checked", hc);
                $(this).closest(".MultiCheckBoxDetail").next().UpdateSelect();
            });

            $(document).on("click", ".MultiCheckBoxDetailHeader", function (e) {
                var inp = $(this).find("input");
                var chk = inp.prop("checked");
                inp.prop("checked", !chk);
                $(this).closest(".MultiCheckBoxDetail").find(".MultiCheckBoxDetailBody input").prop("checked", !chk);
                $(this).closest(".MultiCheckBoxDetail").next().UpdateSelect();
            });

            $(document).on("click", ".MultiCheckBoxDetail .cont input", function (e) {
                e.stopPropagation();
                $(this).closest(".MultiCheckBoxDetail").next().UpdateSelect();

                var val = ($(".MultiCheckBoxDetailBody input:checked").length == $(".MultiCheckBoxDetailBody input").length)
                $(".MultiCheckBoxDetailHeader input").prop("checked", val);
            });

            $(document).on("click", ".MultiCheckBoxDetail .cont", function (e) {
                var inp = $(this).find("input");
                var chk = inp.prop("checked");
                inp.prop("checked", !chk);

                var multiCheckBoxDetail = $(this).closest(".MultiCheckBoxDetail");
                var multiCheckBoxDetailBody = $(this).closest(".MultiCheckBoxDetailBody");
                multiCheckBoxDetail.next().UpdateSelect();

                var val = ($(".MultiCheckBoxDetailBody input:checked").length == $(".MultiCheckBoxDetailBody input").length)
                $(".MultiCheckBoxDetailHeader input").prop("checked", val);
            });

            $(document).mouseup(function (e) {
                var container = $(".MultiCheckBoxDetail");
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.hide();
                }
            });
        });

        var defaultMultiCheckBoxOption = {defaultText: 'Select Access Type', height: '200px' };

        jQuery.fn.extend({
            CreateMultiCheckBox: function (options) {

                var localOption = {};
                localOption.width = (options != null && options.width != null && options.width != undefined) ? options.width : defaultMultiCheckBoxOption.width;
                localOption.defaultText = (options != null && options.defaultText != null && options.defaultText != undefined) ? options.defaultText : defaultMultiCheckBoxOption.defaultText;
                localOption.height = (options != null && options.height != null && options.height != undefined) ? options.height : defaultMultiCheckBoxOption.height;

                this.hide();
                this.attr("multiple", "multiple");
                var divSel = $("<div class='MultiCheckBox'>" + localOption.defaultText + "<span class='k-icon k-i-arrow-60-down'><svg aria-hidden='true' focusable='false'  data-prefix='fas' data-icon='sort-down' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 320 512' class='svg-inline--fa fa-sort-down fa-w-10 fa-2x' style='height: 34px; width: 8px; margin-left: 9px; margin-top: -4px;'><path fill='currentColor' d='M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z' class=''></path></svg></span></div>").insertBefore(this);
                divSel.css({ "width": localOption.width });

                var detail = $("<div class='MultiCheckBoxDetail'><div class='MultiCheckBoxDetailHeader'><input type='checkbox' class='mulinput' value='' /><div>Select All</div></div><div class='MultiCheckBoxDetailBody'></div></div>").insertAfter(divSel);
                detail.css({ "width": parseInt(options.width) + 10, "max-height": localOption.height });
                var multiCheckBoxDetailBody = detail.find(".MultiCheckBoxDetailBody");

                this.find("option").each(function () {
                    var val = $(this).attr("value");

                    if (val == undefined)
                        val = '';

                    multiCheckBoxDetailBody.append("<div class='cont'><div><input type='checkbox' class='mulinput' value='" + val + "' /></div><div>" + $(this).text() + "</div></div>");
                });

                multiCheckBoxDetailBody.css("max-height", (parseInt($(".MultiCheckBoxDetail").css("max-height")) - 28) + "px");
            },
            UpdateSelect: function () {
                var arr = [];

                this.prev().find(".mulinput:checked").each(function () {
                    arr.push($(this).val());
                });

                 this.val(arr);
                 
                 $('#selected ').append('<input type="hidden" name="point" value="'+arr+'"></input>');
                // alert(arr);
            },
        });
</script>
@include('reminder')