<script type="text/javascript">
    // $.notify.defaults( {autoHideDelay: 10000} )
    setInterval(function(){ 
        $.ajax({
                url:'<?php echo url('agent-reminder') ?>',
                type:'get',
                dataType: "json",
                success:function(data){
                    var temp="";
                    for(var i=0; i < data.length; i++){
                        $('.notification_counter').text(data.length);
                       temp+='<a href="<?php echo url('get-reminder-record')  ?>?property_id='+data[i]['property_id']+'&ref='+data[i]['reminder_of']+'&active='+data[i]['add_by']+'" class="notification_link"><div class="col-sm-12 notification"><span><strong>'+data[i]['reminder_type']+'</strong></span><span class="unit_no">('+data[i]['reminder_of']+')</span><span style="float: right;"><a id="property_id" property_id="'+data[i]['property_id']+'"class="close-notification property_id"><i class="mdi mdi-close close_noti"></i></a></span><p>'+data[i]['description']+'</p></div></a>';
                    }
                    $('.notification_bucket').html(temp);
                }
            })
            },3000);
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
                           temp+='<div class="col-sm-12 notification"><a href="<?php echo url('get-reminder-record')  ?>?property_id='+data[i]['property_id']+'&ref='+data[i]['reminder_of']+'&active='+data[i]['add_by']+'" class="notification_link"><span><strong>'+data[i]['reminder_type']+'</strong></span><span class="unit_no">('+data[i]['reminder_of']+')</span><span style="float: right;"><a id="property_id" property_id="'+data[i]['property_id']+'"  class="close-notification property_id"><i class="fa fa-close"></i></a></span><p>'+data[i]['description']+'</p></a></div>';
                       }else{
                         // $.notify("Reminder Alert", "warn");
                         alertify.warning("Reminder Alert");
                       }
                    }
                    $('.notification_bucket').html(temp);
                }
            })
         }, 5000);
      $('body').delegate('.close-notification','click',function(){
        var property_id=$(this).attr('property_id');
        var notification = $(this);
        // $('.property_id').val(property_id);
        $.confirm({
            title: 'Disable Reminder!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label><i class="fa fa-info-circel"></i>Reason:</label>' +
            '<input type="text" placeholder="Please enter the valid reason." class="name form-control" required />' +
            '</div>' +
            '</form>',
             type: 'blue',
             icon: 'fa fa-warning',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue submit',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if(!name){
                            $.alert('provide a valid reason');
                            return false;
                        }else{
                            // $('body').delegate('click','.formSubmit',function(){
                            
                                    $.ajax({
                                    url:'<?php echo url('delete-reminder')  ?>',
                                    type:'get',
                                    data:{property_id, name},
                                    success:function(data){
                                      console.log(data);
                                        if($.trim(data)=="false"){
                                            $.notify("something Went Wrong", "warn",{
                                                globalPosition: 'top right',
                                            });
                                        }else{
                                            $.notify("Reminder Disable Successfully", "warn",{elementPosition: 'bottom left',
                                                globalPosition: 'top left'});
                                            $('.ti-close').trigger('click');
                                            $('.notification_counter').text(data);
                                            notification.parent().remove();
                                            location.reload();
                                            // $('.notification_bucket').html("");
                                        }
                                    }
                                });
                                // });
                        }
                        // $.alert('Reminder Disable Successfully!');
                    }
                },
                cancel: function () {
                    //close
                },
            },
            // onContentReady: function () {
            //     // bind to events
            //     var jc = this;
            //     this.$content.find('form').on('submit', function (e) {
            //         // if the user submits the form by pressing enter in the field.
            //         e.preventDefault();
            //         // jc.$$formSubmit.trigger('click'); // reference the button and click it
            //     });
            // }
        });
      })
      
</script>


