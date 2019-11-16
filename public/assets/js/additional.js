$(document).ready(function(){
        // var counter=0;
        // var temp=[];
        // $('.access_select').each(function(){
        //      $('.access_select option').each(function(){
        //         var attr = $(this).attr('selected');
        //         if (typeof attr !== typeof undefined && attr !== false) {
        //             temp.push($(this).val());
        //             $(this).removeAttr('selected');
        //         }
        //      })
        //     $(this).val(temp[counter++]);
        // })
        $("body").delegate("#add_cheque","click",function(){
            var parent=$(this).parent().parent().parent();
            parent.append('<tr><td> <input required="" type="number" name="Cheque_number[]" class="form-control"></td><td><input required="" type="number" name="Cheque_amount[]" class="form-control"></td><td><input required="" type="Date" name="Cheque_date[]" class="form-control"></td><td> <input required="" type="Date" name="Cheque_deposit_date[]" class="form-control"></td><td><input required="" type="file" class="file" name="Cheque_attach_file[]" ></td><td style="padding-left:0px;padding-right:0px;"><input required="" type="button" value="Add" class="btn btn-primary apply" id="add_cheque" style="width: 100%;"><input required="" type="button" value="Remove" class="btn btn-danger" id="delete" style="margin-top: 5%;width:100%"></td></tr>');
        })
        $("body").delegate("#add_maintenance","click",function(){
            var parent=$(this).parent().parent().parent();
            parent.append('<tr><td><input required="" type="Date" name="maintenance_date[]" class="form-control"></td><td><textarea required="" class="form-control" name="maintenance_description[]" cols="5" rows="5"></textarea></td><td> <input required="" type="number" name="maintenance_AED[]" class="form-control"></td><td><input required="" type="text" class="form-control" name="maintenance_type[]"></td><td><input required="" type="file" class="file" name="maintenance_attach_file[]" style="width: 172px;"></td><td style="padding-left:0px;padding-right:0px;"><input required="" type="button" value="Add" class="btn btn-primary apply" id="add_maintenance" style="width:100%"><input required="" type="button" value="Remove" class="btn btn-danger" id="delete" style="margin-top: 5%;width:100%"></td></tr>');
        })
        $("body").delegate("#add_complain","click",function(){
            var parent=$(this).parent().parent().parent();
            parent.append('<tr><td> <input required="" type="Date" name="complain_date[]" class="form-control"></td><td><textarea required="" class="form-control" name="complain_description[]" cols="5" rows="5"></textarea></td><td><input required="" type="Date" name="action_date[]" class="form-control"></td><td><input required="" type="Date" class="form-control" name="resolve_date[]"></td><td><input required="" type="file" class="file" name="complain_attach_file[]"></td><td style="padding-left:0px;padding-right:0px;"><input required="" type="button" value="Add" class="btn btn-primary apply" id="add_complain" style="width:100%"><input required="" type="button" value="Remove" class="btn btn-danger" id="delete" style="margin-top: 5%;width:100%"></td></tr>');
        })
         $("body").delegate("#delete","click",function(){
            var parent=$(this).parent().parent().remove();
         })
         $("#supervision").validate({
            rules:{
                "action":{
                    required:false,
                }
            }
         });
         $("body").delegate(".form-control,.file,textarea","focusout",function(){
            $(this).siblings("span").remove();
         })
           $("body").delegate(".form-control,.file,textarea","keyup",function(){
           $(this).siblings("span").remove();
         })
         $("#supervision").submit(function(e){
            $('.form-control,textarea,.file').each(function(){
                if($(this).val()==""){
                    if($('.action_select').val()==""){
                        e.preventDefault(); 
                        $(this).next("span").remove();
                         $(this).next("label").remove();
                        $(this).siblings("span").remove();
                        $(this).siblings("label").remove();
                        $("<span class='error'>This field is required.</span>").insertAfter(this);
                    }
                }else{
                     $(this).next("span").remove();
                     $(this).next("label").remove();
                    $(this).siblings("span").remove();
                    $(this).siblings("label").remove();
                }
            })
        })
         // Bulk action
         $("body").delegate(".apply","click",function(e){
            var action=$(".action_select option:selected").val();
            if(action=="NULL"){
                e.preventDefault();
                return;
            }
        })
    })