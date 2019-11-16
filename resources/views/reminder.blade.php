<script type="text/javascript">
    $.notify.defaults( {autoHideDelay: 10000} )
        $.ajax({
                url:'<?php echo url('get-all-reminder') ?>',
                type:'get',
                dataType: "json",
                success:function(data){
                    var temp="";
                    for(var i=0; i < data.length; i++){
                        $('.notification_counter').text(data.length);
                       temp+='<div class="col-sm-12 notification"><a href="<?php echo url('get-reminder-record')  ?>?property_id='+data[i]['property_id']+'&ref='+data[i]['reminder_of']+'&active='+data[i]['add_by']+'" class="notification_link"><span><strong>'+data[i]['reminder_type']+'</strong></span><span class="unit_no">('+data[i]['reminder_of']+')</span><span style="float: right;"><a property_id="'+data[i]['property_id']+'"  class="close_notification"><i class="fa fa-close"></i></a></span><p>'+data[i]['description']+'</p></a></div>';
                    }
                    $('.notification_bucket').html(temp);
                }
            })
         var audio = new Audio("<?php echo url('public/reminder.mp3')  ?>");
      setInterval(function(){ 
        var temp="";
            $.ajax({
                url:'<?php echo url('get-reminder') ?>',
                type:'get',
                dataType: "json",
                success:function(data){
                    temp+=$('.notification_bucket').html();
                    for(var i=0; i < data.length; i++){
                        audio.play();
                       if(data[i]['status']!='viewed'){
                            var getCount = parseInt($('.notification_counter').text());
                          $('.notification_counter').text(getCount + data.length);
                         $.notify("Reminder Alert", "warn");
                           temp+='<div class="col-sm-12 notification"><a href="<?php echo url('get-reminder-record')  ?>?property_id='+data[i]['property_id']+'&ref='+data[i]['reminder_of']+'&active='+data[i]['add_by']+'" class="notification_link"><span><strong>'+data[i]['reminder_type']+'</strong></span><span class="unit_no">('+data[i]['reminder_of']+')</span><span style="float: right;"><a property_id="'+data[i]['property_id']+'"  class="close_notification"><i class="fa fa-close"></i></a></span><p>'+data[i]['description']+'</p></a></div>';
                       }else{
                         $.notify("Reminder Alert", "warn");
                       }
                    }
                    $('.notification_bucket').html(temp);
                }
            })

         }, 5000);
      $('body').delegate('.close_notification','click',function(){
        var notification = $(this);
            $.ajax({
            url:'<?php echo url('delete-reminder');  ?>',
            type:'get',
            data:{property_id:$(this).attr('property_id')},
            success:function(data){
              console.log(data);
                if($.trim(data)=="false"){
                    $.notify("something Went Wrong", "warn",{
                        globalPosition: 'top right',
                    });
                }else{
                    $.notify("Reminder Deleted Successfully", "warn",{elementPosition: 'bottom left',
                        globalPosition: 'top left'});
                    $('.ti-close').trigger('click');
                    $('.notification_counter').text(data);
                    notification.parent().remove();
                    // $('.notification_bucket').html("");
                }
            }
        })
      })
</script>