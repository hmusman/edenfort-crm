<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\property;
use App\Models\coldcallingModel;
use DB;
use App\Models\Reminder;
class MoveDataController extends Controller
{
    
    public function MoveData(){
        $property = property::all();
        // dd($property);
        $total = count( $property );
        echo "Total Properties". $total. '<br>';
        foreach ($property as $key => $value) {
            $property_id = $value->id;
            $unit_no = $value->unit_no;
            $dewa_no = $value->dewa_no;
            $Building = $value->Building;
            $area = $value->area;
            $LandLord = $value->LandLord;
            $email = $value->email;
            $contact_no = $value->contact_no;
            $Bedroom = $value->Bedroom;
            $Washroom = $value->Washroom;
            $Conditions = $value->Conditions;
            $Area_Sqft = $value->Area_Sqft;
            $Price = $value->Price;
            $comment = $value->comment;
            $access = $value->access;
            $add_by = $value->add_by;
            $sale_status = $value->sale_status;
            $sale_price = $value->sale_price;
            $rented_status = $value->rented_status;
            $user_id = $value->user_id;
            $type = $value->type;
            $property_status = $value->property_status;
            $rented_date = $value->rented_date;
            $rented_price = $value->rented_price;
            $created_at = $value->created_at;
            $updated_at = $value->updated_at;
            $property_type = $value->property_type;
            $coldcallingsheet = $value->coldcallingsheet;

            echo $value->id.'<br>'.$unit_no.'<br>'.$dewa_no.'<br>'.$Building.'<br>'.$area.'<br>'.$LandLord.'<br>'.$email.'<br>'.$contact_no.'<br>'.$Bedroom.'<br>'.$Washroom.'<br>'.$Conditions.'<br>'.$Area_Sqft.'<br>'.$Price.'<br>'.$comment.'<br>'.$access.'<br>'.$add_by.'<br>'.$sale_status.'<br>'.$sale_price.'<br>'.$rented_status.'<br>'.$user_id.'<br>'.$type.'<br>'.$property_status.'<br>'.$rented_date.'<br>'.$rented_price.'<br>'.$created_at.'<br>'.$updated_at.'<br>'.$property_type.'<br>'.$coldcallingsheet.'<br>';
            echo "End property <br>";
            echo '<br><br><br><br>';

            $id = coldcallingModel::insertGetId(['unit_no'=>$unit_no,'dewa_no'=>$dewa_no,'Building'=>$Building,'area'=>$area,'LandLord'=>$LandLord,'email'=>$email,'contact_no'=>$contact_no,'Bedroom'=>$Bedroom,'Washroom'=>$Washroom,'Conditions'=>$Conditions,'Area_Sqft'=>$Area_Sqft,'access'=>$access,'sale_status'=>$sale_status,'sale_price'=>$sale_price,'rented_status'=>$rented_status,'rented_price'=>$rented_price,'rented_date'=>$rented_date,'price'=>$Price,'type'=>$type,'comment'=>$comment,'user_id'=>$user_id,'created_at'=>$created_at,'updated_at'=>$updated_at,'property_type'=>$property_type,'add_by'=>$add_by,'property_status'=>$property_status,'coldcallingsheet'=>$coldcallingsheet]);

            if($id){
                echo '<h2>PROPERTY INSERTED TO COLDCALLING TABLE SUCCESSFULLY</h2>';

                $Update_reminder = Reminder::where('property_id',$property_id)->update(['property_id'=>$id]);

                if($Update_reminder){
                    echo "<h3>REMINDER UPDATED SUCCESSFULLY</h3>";
                }else{
                    echo "<h3>Something Wents Wrong With Reminder.</h3>";
                }

                $delete_property = property::where('id',$property_id)->delete();

                if($delete_property){
                    echo "<h3>PROPERTY DELETED SUCCESSFULLY</h3>";
                }else{
                    echo "<h3>PROPERTY DELETED UN-SUCCESSFULLY</h3>";
                }

            }else{
                echo "<h3>Something Wents Wrong With Property.</h3>";
            }

        }
    }

}
