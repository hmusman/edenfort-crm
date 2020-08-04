
<!-- showing reminders to admin, superagent-->
<script type="text/javascript">
    // $.notify.defaults( {autoHideDelay: 10000} );
    setTimeout(function(){ 
        $.ajax({
                url:'<?php echo url('get-all-reminder') ?>',
                type:'get',
                dataType: "json",
                success:function(data){
                    var temp="";
                    for(var i=0; i < data.length; i++){
                        $('.notification_counter').text(data.length);
                       temp+='<a href="<?php echo url('get-single-user-reminder')  ?>/'+data[i]['uid']+'" class="notification_link"><div class="col-sm-12 notification"><span class="round bg-light mr-2 avatar" style="color: black;">'+data[i]['unam']+'</span><span class="avatar_name"><strong>'+data[i]['user_name']+'</strong></span><span class="unit_no avatar_count">('+data[i]['rid']+')</span></div></a>';
                    }
                    $('.notify').html(temp);
                }
             })
         }, 3000);
         var audio = new Audio("<?php echo url('public/reminder.mp3')  ?>");
         setInterval(function(){ 
        var temp="";
            $.ajax({
                url:'<?php echo url('get-admin-reminder') ?>',
                type:'get',
                dataType: "json",
                success:function(data){
                  // console.log(data);s
                    temp+=$('.notify').html();
                    for(var i=0; i < data.length; i++){
                        audio.play();
                       if(data[i]['status']!='viewed'){
                            // var getCount = parseInt($('.notification_counter').text());
                          // $('.notification_counter').text(getCount + data.length);
                         alertify.warning("Reminder Alert");
                         // $.notify("Reminder Alert", "warn");
                           temp+='<a href="<?php echo url('get-single-user-reminder')  ?>/'+data[i]['user_id']+'" class="notification_link"><div class="col-sm-12 notification"><span class="round bg-light mr-2 avatar" style="color: black;">'+data[i]['user_name'].charAt(0).toUpperCase()+'</span><span class="avatar_name"><strong>'+data[i]['user_name']+'</strong></span></div></a>';
                       }
                       else{
                         // $.notify("Reminder Alert", "warn");
                         alertify.warning("Reminder Alert");
                       }
                    }
                    $('.notify').html(temp);
                }
            })
         }, 5000);
      // $('body').delegate('.close_notification','click',function(){
      //   var notification = $(this);
      //       $.ajax({
      //       url:'<?php echo url('delete-single-reminder');  ?>',
      //       type:'get',
      //       data:{user_id:$(this).attr('user_id')},
      //       success:function(data){
      //         console.log(data);
      //           if($.trim(data)=="false"){
      //               $.notify("something Went Wrong", "warn",{
      //                   globalPosition: 'top right',
      //               });
      //           }else{
      //               $.notify("Reminder Disable Successfully", "warn",{elementPosition: 'bottom left',
      //                   globalPosition: 'top left'});
      //               $('.ti-close').trigger('click');
      //               $('.notification_counter').text(data);
      //               notification.parent().remove();
      //               // $('.notification_bucket').html("");
      //           }
      //       }
      //   })
      // })
</script>


<script type="text/javascript">
    setTimeout(function(){
        $.ajax({
            url:'<?php echo url('remindersCount') ?>',
                type:'get',
                dataType: "json",
                success:function(data){
                    for(var i=0; i < data.length; i++){
                        var id = data[i]['userid'];
                    if (data[i]['User']=='Admin' || data[i]['User']=='SuperAgent' || data[i]['User']=='Agent') {
                        $.confirm({
                            title: 'Reminder Alert!',
                            content: 'Dear <strong><b>'+data[i]['user_name']+'</b></strong>, you have <strong><b>' +data[i]['unviewed_reminders']+ '</b></strong> unviewed reminders, please select the following options. ',
                            theme: 'material',
                            type: 'blue',
                             icon: 'fa fa-warning',
                            buttons: {
                                visit: {
                                    text: 'Visit',
                                    btnClass: 'btn-blue',
                                    keys: ['enter', 'shift'],
                                    action:function(){
                                        window.location ='<?php echo url('get-single-user-reminder') ?>/'+id;
                                    }
                                },
                                cancel:{
                                    btnClass: 'btn-danger',
                                    action: function(){
                                    $.alert('Do you really want to cancel!');
                                    }
                                }
                            }
                        });
                    }
                }

                    
                }
      });
    },900000);
</script>