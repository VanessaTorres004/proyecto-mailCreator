<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blocks extends Model{

	protected $table='blocks';

	protected $fillable = ['id','content','position','type','campaign_id'];

	public function getMaxPosition($campaign_id){
		return \DB::table($this->table)->where('campaign_id','=',$campaign_id)->max('position');
	}
    
	public function getTemplate($position=0){
    $html="";
		switch($position){
			case "1":{
			    
				$html = '<!-- START LAYOUT-1/1 -->
        		<tr class="actions" style=" border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
                 <tr>
                   <td align="center" valign="top"   class="fix-box">
                     <!-- start  container width 600px -->
                     <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; padding-left:20px; padding-right:20px;">
                       <tr>
                         <td valign="top">
                           <!-- start container width 560px -->
                           <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">
                             <!-- start text content -->
                             <tr>
                               <td valign="top">
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
                                   <tr>
                                     <td valign="top" width="auto" align="center">
                                       <!-- start button -->
                                       <table border="0" align="center" cellpadding="0" cellspacing="0">
                                         <tr>
                                           <td width="auto"  align="center" valign="middle" height="28" style="background-color:#ffffff; border:1px solid #ececed; background-clip: padding-box; font-size:18px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:#727272; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                             <span style="color: $$color$$; font-weight: 300;">
                                               <a href="$$link$$" style="text-decoration: none; color: $$color$$; font-weight: 300;font-size:35px;" id="title_type_1">
                                               $$title$$
                                               </a>
                                             </span>
                                           </td>
                                         </tr>
                                       </table>
                                       <!-- end button -->
                                      </td>
                                   </tr>
                                 </table>
                               </td>
                             </tr>
                             <!-- end text content -->
                           </table>
                           <!-- end  container width 560px -->
                         </td>
                       </tr>
                     </table>
                     <!-- end  container width 600px -->
                   </td>
                 </tr>
                 <!-- END LAYOUT-1/1 -->
                 <!-- START LAYOUT-1/2 -->
                  <tr>
                   <td align="center" valign="top"   class="fix-box">

                     <!-- start  container width 600px -->
                     <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; padding-left:20px; padding-right:20px;">


                       <tr>
                         <td valign="top">

                           <!-- start container width 560px -->
                           <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">


                             <!-- start text content -->
                             <tr>
                               <td valign="top">
                                 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >


                                   <!-- start text content -->
                                   <tr>
                                     <td valign="top">
                                       <table border="0" cellspacing="0" cellpadding="0" align="center" >


                                         <!--start space height -->
                                         <tr>
                                           <td height="15" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <tr>
                                           <td  style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; " id="content_mail_1" >
                                               $$content$$
                                           </td>
                                         </tr>

                                        <!--start space height -->
                                         <tr>
                                           <td height="15" ></td>
                                         </tr>
                                         <!--end space height -->



                                       </table>
                                     </td>
                                   </tr>
                                   <!-- end text content -->

                                    <tr>
                                     <td valign="top" width="auto" align="center">
                                       <!-- start button -->
                                       <table border="0" align="center" cellpadding="0" cellspacing="0">
                                         <tr>
                                           <td width="auto"  align="center" valign="middle" height="32" style="$$exists_button1$$background-color:$$color$$;  border-radius:15px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                             <span style="color: #ffffff; font-weight: 300;">
                                               <a href="$$principal$$" id="button_1" style="text-decoration: none; color: #ffffff; font-weight: 300;">
                                                $$name-principal$$
                                               </a>
                                             </span>
                                           </td>

                                           <!-- start space width -->
                                            <td valign="top" >
                                              <table width="20" border="0" align="center" cellpadding="0" cellspacing="0">
                                                <tr>
                                                  <td valign="top">
                                                    &nbsp;
                                                  </td>
                                                </tr>
                                              </table>
                                            </td>
                                            <!--end space width -->


                                           <td width="auto" align="center" valign="middle" height="32" style="$$exists_button2$$background-color:#ffffff; border-radius:15px; border:1px solid #ececed; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:$$color$$; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                             <span title="textColor" style="color: $$color$$; font-weight: 300;">
                                               <a id="button_2" href="$$secondary$$" title="textColor" style="text-decoration: none; color: $$color$$; font-weight: 300;">
                                                $$name-secondary$$
                                               </a>
                                             </span>
                                           </td>
                                         </tr>
                                       </table>
                                       <!-- end button -->
                                      </td>

                                   </tr>

                                 </table>
                               </td>
                             </tr>
                             <!-- end text content -->

                            <!--start space height -->
                           <tr>
                             <td height="20" ></td>
                           </tr>
                           <!--end space height -->


                           </table>
                           <!-- end  container width 560px -->
                         </td>
                       </tr>
                     </table>
                     <!-- end  container width 600px -->
                   </td>
                 </tr>

                 <!-- END LAYOUT-1/2 -->
                 <!--START IMAGE HEADER LAYOUT-->


                 <tr>
                   <td align="center" valign="top" class="fix-box">

                     <!-- start HEADER LAYOUT-container width 600px -->
                     <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" >
                       <tr>
                         <td valign="top" class="image-100-percent">


                            <img  src="$$image$$" width="600" alt="header-image" style="display:block !important;  max-width:600px;">

                         </td>
                       </tr>
                     </table>
                     <!-- end HEADER LAYOUT-container width 600px -->
                   </td>
                 </tr>

                  <!--END IMAGE HEADER LAYOUT-->

                <!-- START SHADOW-->
                 <tr>
                   <td valign="top" align="center"  class="fix-box">
                     <table width="600" height="11"  align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff;"  class="full-width">
                       <tr>
                         <td valign="top" height="11" class="image-100-percent">
                          <img  src="$$shadow$$" width="600" alt="space" style="display:block; max-height:11px; max-width:600px;"> </td>
                       </tr>
                     </table>
                   </td>
                 </tr>
                 <!-- END SHADOW-->';
        break;
		  }
      case "2":{
        $html = '<!-- START LAYOUT 2-->
                <tr  class="actions" style=" border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
                 <tr>
                   <td align="center" valign="top" class="fix-box">
                     <!-- start layout-2 container width 600px -->
                     <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color: #ffffff;  padding-left:20px; padding-right:20px;">
                       <tr>
                         <td valign="top">
                           <!-- start layout-2 container width 600px -->
                           <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color:#ffffff; ">
                             <!-- start image and content -->
                             <tr>
                               <td valign="top" width="100%">
                                 <!-- start content left -->
                                 <table width="270" border="0" cellspacing="0" cellpadding="0" align="left" class="full-width" >
                                   <tr>
                                     <td  valign="bottom" align="center"  >
                                       <a href="#">
                                         <img src="$$image$$" width="270" alt="image1_480x501" style="display:block; max-width:270px; " border="0" hspace="0" vspace="0"/>
                                       </a>

                                     </td>
                                   </tr>

                                 </table>
                                 <!-- end content left -->
                                 <!-- start space width -->
                                 <table class="remove" width="1" border="0" cellpadding="0" cellspacing="0" align="left" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                   <tr>
                                     <td width="0" height="2" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                       <p style="padding-left: 20px;">&nbsp;</p>
                                     </td>
                                   </tr>
                                 </table>
                                 <!-- end space width -->
                                 <!-- start content right -->
                                 <table width="270" border="0" cellspacing="0" cellpadding="0" align="right" class="full-width-text"   >
                                  <!--start space height -->
                                   <tr>
                                     <td height="5" ></td>
                                   </tr>
                                   <!--end space height -->

                                  <!--start space height -->
                                   <tr>
                                     <td height="5" class="remove"></td>
                                   </tr>
                                   <!--end space height -->
                                   <!-- start text content -->
                                   <tr>
                                     <td valign="top">
                                       <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                         <tr>
                                           <td  style="font-size: 22px; line-height: 24px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                             <span style="color: #555555; font-weight: 300;">
                                               <a href="$$link$$" style="text-decoration: none; color: #555555; font-weight: 300;" id="title_type_2" >
                                              $$title$$</a><br/><span style="color:#727272; font-size:16px; line-height: 20px; font-weight: 300;" id="subtitle">$$subtitle$$</span>
                                             </span>
                                           </td>
                                         </tr>

                                         <!--start space height -->
                                         <tr>
                                           <td height="15" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <tr>
                                           <td id="content_view_2" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">

                                            $$content$$

                                           </td>
                                         </tr>

                                         <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <tr>
                                           <td valign="top" width="auto" >

                                             <!-- start button -->
                                             <table border="0" align="left" cellpadding="0" cellspacing="0" style="border:1px solid #ececed; border-radius:5px;">
                                               <tr>
                                                 <td width="auto"  align="center" valign="middle" height="30" style="$$exists_button1$$background-color:#ffffff;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:$$color$$; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                   <span style="color: $$color$$; font-weight: 300;">
                                                     <a href="$$boton_1$$" id="button_2_1" style="text-decoration: none; color: $$color$$; font-weight: 300;">
                                                       $$name-principal$$
                                                     </a>
                                                   </span>
                                                 </td>
                                               </tr>
                                             </table>
                                             <!-- end button -->

                                            <!-- start space width -->
                                            <table width="10"  border="0" cellpadding="0" cellspacing="0" align="left" style=" font-size: 0;line-height: 0;border-collapse: collapse;">
                                              <tr>
                                                <td width="10" height="2" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                                  <p style="padding-left: 10px;"></p>
                                                </td>
                                              </tr>
                                            </table>
                                            <!-- end space width-->

                                             <!-- start button -->
                                             <table border="0" align="left" cellpadding="0" cellspacing="0" style="border:1px solid #ececed; border-radius:5px;">
                                               <tr>
                                                 <td width="auto"  align="center" valign="middle"  height="30" style="$$exists_button3$$background-color:#ffffff;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:$$color$$; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                   <span style="color: $$color$$; font-weight: 300;">
                                                     <a href="$$boton_2$$" id="button_2_2" style="text-decoration: none; color: $$color$$; font-weight: 300;">
                                                       $$name-boton_2$$
                                                     </a>
                                                   </span>
                                                 </td>
                                               </tr>
                                             </table>
                                             <!-- end button -->
                                           </td>

                                         </tr>

                                       </table>
                                     </td>
                                   </tr>
                                   <!-- end text content -->

                                     <!--start space height -->
                                   <tr>
                                     <td height="20" ></td>
                                   </tr>
                                   <!--end space height -->

                                 </table>
                                 <!-- end content right -->
                               </td>
                             </tr>
                             <!-- end image and content -->

                           </table>
                           <!-- end layout-2 container width 600px -->
                         </td>
                       </tr>
                     </table>
                     <!-- end layout-2 container width 600px -->
                   </td>
                 </tr>
                 <!-- END LAYOUT 2  -->

                 <!-- START SHADOW-->
                 <tr>
                   <td valign="top" align="center"  class="fix-box">
                     <table width="600" height="11"  align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff;"  class="full-width">
                       <tr>
                         <td valign="top" height="11" class="image-100-percent">
                          <img  src="images/shadow.png" width="600" alt="space" style="display:block; max-height:11px; max-width:600px;"> </td>
                       </tr>
                     </table>
                   </td>
                 </tr>
                 <!-- END SHADOW-->';
        break;
      }
      case "3":{
        $html='<!-- START LAYOUT-3-->
        <tr  class="actions" style=" border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
               <tr>
                 <td align="center" valign="top" class="fix-box">

                   <!-- start layout-3 container width 600px -->
                   <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color: #ffffff; border-radius:5px; padding-left:20px; padding-right:20px;">
                     <tr>
                       <td valign="top">

                         <!-- start layout-3 container width 600px -->
                         <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">



                           <!-- start image and content -->
                           <tr>
                             <td valign="top" width="100%">

                               <!-- start content left -->
                               <table width="270" border="0" cellspacing="0" cellpadding="0" align="right" class="full-width" >

                                 <tr>
                                   <td  valign="bottom" align="center"  >
                                     <a href="$$link$$">
                                       <img src="$$image$$" width="270" alt="image2_480x501" style="display:block; max-width:270px; " border="0" hspace="0" vspace="0"/>
                                     </a>

                                   </td>
                                 </tr>

                               </table>
                               <!-- end content left -->


                               <!-- start space width -->
                               <table class="remove" width="1" border="0" cellpadding="0" cellspacing="0" align="right" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                 <tr>
                                   <td width="0" height="2" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                     <p style="padding-left: 20px;">&nbsp;</p>
                                   </td>
                                 </tr>
                               </table>
                               <!-- end space width -->


                               <!-- start content right -->
                               <table width="270" border="0" cellspacing="0" cellpadding="0" align="left"  class="full-width-text" style="padding-left:20px;">
                                <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                <!--start space height -->
                                 <tr>
                                   <td height="40" class="remove"></td>
                                 </tr>
                                 <!--end space height -->


                                 <!-- start text content -->
                                 <tr>
                                   <td valign="top">
                                     <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                       <tr>
                                         <td  style="font-size: 22px; line-height: 24px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                           <span style="color: #555555; font-weight: 300;">
                                             <a href="$$link$$" style="text-decoration: none; color: #555555; font-weight: 300;" id="link_3">
                                              $$title$$</a><br/><span style="color:#727272; font-size:16px; line-height: 20px; font-weight: 300;" id="subtitle_3">$$subtitle$$.</span>
                                             </span>
                                         </td>
                                       </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="15" ></td>
                                       </tr>
                                       <!--end space height -->

                                       <tr>
                                         <td id="content_3" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">

                                          $$content$$

                                         </td>
                                       </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="20" ></td>
                                       </tr>
                                       <!--end space height -->

                                       <tr>
                                         <td valign="top" width="auto" >

                                           <!-- start button -->
                                           <table border="0" align="left" cellpadding="0" cellspacing="0" style="border:1px solid #ececed; border-radius:5px;">
                                             <tr>
                                               <td width="auto"  align="center" valign="middle" height="30" style="$$exists_button1$$background-color:#ffffff;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:$$color$$; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                 <span style="color: $$color$$; font-weight: 300;">
                                                   <a href="$$boton_1$$" id="button_3_1" style="text-decoration: none; color: $$color$$; font-weight: 300;">
                                                     $$name-boton_1$$
                                                   </a>
                                                 </span>
                                               </td>
                                             </tr>
                                           </table>
                                           <!-- end button -->

                                          <!-- start space width -->
                                          <table width="10"  border="0" cellpadding="0" cellspacing="0" align="left" style=" font-size: 0;line-height: 0;border-collapse: collapse;">
                                            <tr>
                                              <td width="10" height="2" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                                <p style="padding-left: 10px;"></p>
                                              </td>
                                            </tr>
                                          </table>
                                          <!-- end space width-->

                                           <!-- start button -->
                                           <table border="0" align="left" cellpadding="0" cellspacing="0" style="border:1px solid #ececed; border-radius:5px;">
                                             <tr>
                                               <td width="auto"  align="center" valign="middle"  height="30" style="$$exists_button3$$background-color:#ffffff;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:$$color$$; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                 <span style="color: $$color$$; font-weight: 300;">
                                                   <a href="$$boton_2$$" id="button_3_2" style="text-decoration: none; color: $$color$$; font-weight: 300;">
                                                     $$name-boton_2$$
                                                   </a>
                                                 </span>
                                               </td>
                                             </tr>
                                           </table>
                                           <!-- end button -->
                                         </td>

                                       </tr>

                                     </table>
                                   </td>
                                 </tr>
                                 <!-- end text content -->

                                   <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                               </table>
                               <!-- end content right -->
                             </td>
                           </tr>
                           <!-- end image and content -->

                         </table>
                         <!-- end layout-3 container width 600px -->
                       </td>
                     </tr>
                   </table>
                   <!-- end layout-3 container width 600px -->
                 </td>
               </tr>
               <!-- END LAYOUT-3  -->

                <!-- START SHADOW-->
               <tr>
                 <td valign="top" align="center"  class="fix-box">
                   <table width="600" height="11"  align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff;"  class="full-width">
                     <tr>
                       <td valign="top" height="11" class="image-100-percent">
                        <img  src="images/shadow.png" width="600" alt="space" style="display:block; max-height:11px; max-width:600px;"> </td>
                     </tr>
                   </table>
                 </td>
               </tr>
               <!-- END SHADO-->';
        break;
      }
      case "4":{
        $html='<!-- START LAYOUT-4 -->
        <tr  class="actions" style=" border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
               <tr>
                 <td align="center" valign="top"  class="fix-box">

                   <!-- start LAYOUT-4 container width 600px -->
                   <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; border-bottom:1px solid #c7c7c7; padding-left:20px; padding-right:20px;">
                     <tr>
                       <td valign="top">

                         <!-- start LAYOUT-4 container width 560px -->
                         <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">

                           <!-- start image and content -->
                           <tr>
                             <td valign="top" width="100%">

                               <!-- start content left -->
                               <table width="270" border="0" cellspacing="0" cellpadding="0" align="left" class="col-2">

                                <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                 <tr>
                                   <td  valign="top" align="center" class="image-270px" >
                                     <a href="$$link_left$$" id="image_link_left">
                                       <img src="$$image_left$$" width="270" alt="image3_480x260" style="display:block !important; max-width:270px; " border="0" hspace="0" vspace="0"/>
                                     </a>

                                   </td>
                                 </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                 <!-- start text content -->
                                 <tr>
                                   <td valign="top">
                                     <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                       <tr>
                                         <td  style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                           <span style="color: #555555; font-weight: 300;">
                                             <a id="title_1" class="link_1" href="$$link_left$$" style="text-decoration: none; color: #555555; font-weight: 300;">
                                               $$title_left$$
                                             </a>
                                           </span>
                                         </td>
                                       </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="15" ></td>
                                       </tr>
                                       <!--end space height -->

                                       <tr>
                                         <td  style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; " id="content_left" >
                                            $$content_left$$
                                         </td>
                                       </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="20" ></td>
                                       </tr>
                                       <!--end space height -->

                                       <tr>
                                         <td valign="top" width="auto" >
                                           <!-- start button -->
                                           <table border="0" align="left" cellpadding="0" cellspacing="0">
                                             <tr>
                                               <td width="auto"   align="center" valign="middle"  height="32" style="$$exists_button4$$background-color:$$color$$;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                 <span style="color: #ffffff; font-weight: 300;">
                                                   <a id="learn_more_left" href="$$link_left$$" style="text-decoration: none; color: #ffffff; font-weight: 300;">
                                                      Leer M&aacute;s
                                                   </a>
                                                 </span>
                                               </td>
                                             </tr>
                                           </table>
                                           <!-- end button -->

                                         </td>
                                       </tr>
                                     </table>
                                   </td>
                                 </tr>
                                 <!-- end text content -->
                                   <!--start space height -->
                                 <tr>
                                   <td height="20" class="col-underline"></td>
                                 </tr>
                                 <!--end space height -->
                               </table>
                               <!-- end content left -->


                               <!-- start space width -->
                               <table class="remove" width="1" border="0" cellpadding="0" cellspacing="0" align="left" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                 <tr>
                                   <td width="0" height="2" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                     <p style="padding-left: 20px;">&nbsp;</p>
                                   </td>
                                 </tr>
                               </table>
                               <!-- end space width -->


                               <!-- start content right -->
                               <table width="270" border="0" cellspacing="0" cellpadding="0" align="right" class="col-2-last"  >
                                <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                 <tr>
                                   <td  width="100%" valign="top" align="center"  class="image-270px">
                                     <a href="$$link_right$$" id="image_link_right">
                                       <img  src="$$image_right$$" width="270" alt="image4_480x260" style="display:block !important; max-width:270px; " border="0" hspace="0" vspace="0"/>
                                     </a>

                                   </td>
                                 </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                 <!-- start text content -->
                                 <tr>
                                   <td valign="top">
                                     <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                       <tr>
                                         <td  style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                           <span style="color: #555555; font-weight: 300;">
                                             <a href="$$link_right$$" id="link_right" style="text-decoration: none; color: #555555; font-weight: 300;">
                                              $$title_right$$
                                             </a>
                                           </span>
                                         </td>
                                       </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="15" ></td>
                                       </tr>
                                       <!--end space height -->

                                       <tr>
                                         <td  style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; " id="content_right" >
                                            $$content_right$$
                                         </td>
                                       </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="20" ></td>
                                       </tr>
                                       <!--end space height -->

                                       <tr>
                                         <td valign="top" width="auto" >
                                           <!-- start button -->
                                           <table border="0" align="left" cellpadding="0" cellspacing="0">
                                             <tr>
                                               <td width="auto"  align="center" valign="middle"  height="32" style="$$exists_button5$$background-color:$$color$$;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                 <span style="color: #ffffff; font-weight: 300;">
                                                   <a id="learn_more_right" href="$$link_right$$" style="text-decoration: none; color: #ffffff; font-weight: 300;">
                                                    Leer M&aacute;s
                                                   </a>
                                                 </span>
                                               </td>
                                             </tr>
                                           </table>
                                           <!-- end button -->

                                         </td>
                                       </tr>
                                     </table>
                                   </td>
                                 </tr>
                                 <!-- end text content -->

                                   <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                               </table>
                               <!-- end content right -->
                             </td>
                           </tr>
                           <!-- end image and content -->

                         </table>
                         <!-- end LAYOUT-4 container width 560px -->
                       </td>
                     </tr>
                   </table>
                   <!-- end LAYOUT-4 container width 600px -->
                 </td>
               </tr>
               <!-- END LAYOUT-4 -->';
        break;
      }
      case "5":{
        $html='<!-- START LAYOUT-5 -->
        <tr  class="actions" style=" border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
               <tr>
                 <td align="center" valign="top"  class="fix-box">

                   <!-- start LAYOUT-5 container width 600px -->
                   <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; border-bottom:1px solid #c7c7c7; padding-left:20px; padding-right:20px;">
                     <tr>
                       <td valign="top">

                         <!-- start LAYOUT-5 container width 560px -->
                         <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">


                            <!-- start image and content -->
                            <tr>
                              <td valign="top" >
                                <!-- start content left -->
                                <table width="170" border="0" cellspacing="0" cellpadding="0" align="left" class="col-3"  >

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                  <tr>
                                    <td  width="100%" valign="top" align="left"class="image-170px">
                                      <a href="$$link_1$$" class="link_1">
                                        <img id="img_1" src="$$image_1$$" width="170" alt="image5_280x210" style="max-width:170px; display:block !important; " border="0" hspace="0" vspace="0"/>
                                      </a>
                                    </td>
                                  </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                  <tr>
                                    <td>
                                      <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                        <tr>
                                          <td  style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                            <span style="color: #555555; font-weight: 300;">
                                              <a id="title_1" class="link_1" href="$$link_1$$" style="text-decoration: none; color: #555555; font-weight: 300;">
                                                $$title_1$$
                                              </a>
                                            </span>
                                          </td>
                                        </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="15" ></td>
                                       </tr>
                                       <!--end space height -->

                                        <tr>
                                          <td id="content_1" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">
                                              $$content_1$$
                                          </td>
                                        </tr>

                                         <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                        <tr>
                                          <td valign="top" width="auto" >
                                            <!-- start button -->
                                            <table border="0" align="left" cellpadding="0" cellspacing="0">
                                              <tr>
                                                <td width="auto"   align="center" valign="middle" height="32" style="$$exists_button6$$background-color:$$color$$;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                  <span style="color: #ffffff; font-weight: 300;">
                                                    <a id="button_1" class="link_1" href="$$link_1$$" style="text-decoration: none; color: #ffffff; font-weight: 300;">
                                                      Leer M&aacute;s
                                                    </a>
                                                  </span>
                                                </td>
                                              </tr>
                                            </table>
                                            <!-- end button -->

                                          </td>
                                        </tr>
                                      </table>

                                    </td>
                                  </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" class="col-underline"></td>
                                 </tr>
                                 <!--end space height -->

                                </table>
                                 <!-- end content left -->

                                <!-- start space width  -->
                                <table class="remove" width="1" border="0" cellpadding="0" cellspacing="0" align="left" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                  <tr>
                                    <td width="0" height="3" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                      <p style="padding-left: 20px;">&nbsp;</p>
                                    </td>
                                  </tr>
                                </table>
                                <!-- end space width  -->

                                <!-- start content center -->
                                <table width="170" border="0" cellspacing="0" cellpadding="0" align="left" class="col-3"  >

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                  <tr>
                                    <td  width="100%" valign="top" align="left" class="image-170px">
                                      <a href="$$link_2$$" class="link_2">
                                        <img id="img_2" src="$$image_2$$" width="170" alt="image6_280x210" style="max-width:170px; display:block !important; " border="0" hspace="0" vspace="0"/>
                                      </a>
                                    </td>
                                  </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                  <tr>
                                    <td>
                                      <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                        <tr>
                                          <td  style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                            <span style="color: #555555; font-weight: 300;">
                                              <a id="title_2" class="link_2" href="$$link_2$$" style="text-decoration: none; color: #555555; font-weight: 300;">
                                              $$title_2$$
                                              </a>
                                            </span>
                                          </td>
                                        </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="15" ></td>
                                       </tr>
                                       <!--end space height -->

                                        <tr>
                                          <td id="content_2" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">
                                              $$content_2$$
                                          </td>
                                        </tr>

                                         <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                        <tr>
                                          <td valign="top" width="auto" >
                                            <!-- start button -->
                                            <table border="0" align="left" cellpadding="0" cellspacing="0">
                                              <tr>
                                                <td width="auto"  align="center" valign="middle"  height="32" style="$$exists_button7$$background-color:$$color$$;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                  <span style="color: #ffffff; font-weight: 300;">
                                                    <a id="button_2" class="link_2" href="$$link_2$$" style="text-decoration: none; color: #ffffff; font-weight: 300;">
                                                     Leer M&aacute;s
                                                    </a>
                                                  </span>
                                                </td>
                                              </tr>
                                            </table>
                                            <!-- end button -->

                                          </td>
                                        </tr>
                                      </table>

                                    </td>
                                  </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" class="col-underline"></td>
                                 </tr>
                                 <!--end space height -->

                                </table>
                                 <!-- end content center -->

                                <!-- start space width  -->
                                <table class="remove" width="1" border="0" cellpadding="0" cellspacing="0" align="left" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                  <tr>
                                    <td width="0" height="3" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                      <p style="padding-left:20px ">&nbsp;</p>
                                    </td>
                                  </tr>
                                </table>
                                <!-- end space width  -->

                                 <!-- start content right -->
                                <table width="170" border="0" cellspacing="0" cellpadding="0" align="left" class="col-3-last"  >

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                  <tr>
                                    <td  width="100%" valign="top" align="left" class="image-170px" >
                                      <a href="" class="link_3">
                                        <img id="img_3" src="$$image_3$$" width="170" alt="image7_280x210" style="max-width:170px; display:block !important; " border="0" hspace="0" vspace="0"/>
                                      </a>
                                    </td>
                                  </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                  <tr>
                                    <td>
                                      <table  border="0" cellspacing="0" cellpadding="0" align="left" >
                                        <tr>
                                          <td  style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                            <span style="color: #555555; font-weight: 300;">
                                              <a id="title_3" class="link_3" href="$$link_3$$" style="text-decoration: none; color: #555555; font-weight: 300;">
                                                $$title_3$$
                                              </a>
                                            </span>
                                          </td>
                                        </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="15" ></td>
                                       </tr>
                                       <!--end space height -->

                                        <tr>
                                          <td id="content_3" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">
                                            $$content_3$$
                                          </td>
                                        </tr>

                                         <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                        <tr>
                                          <td valign="top" width="auto" >
                                            <!-- start button -->
                                            <table border="0" align="left" cellpadding="0" cellspacing="0">
                                              <tr>
                                                <td width="auto"  align="center" valign="middle"  height="32" style="$$exists_button8$$background-color:$$color$$;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                  <span style="color: #ffffff; font-weight: 300;">
                                                    <a href="$$link_3$$" id="button_3" class="link_3" style="text-decoration: none; color: #ffffff; font-weight: 300;">
                                                      Leer M&aacute;s
                                                    </a>
                                                  </span>
                                                </td>
                                              </tr>
                                            </table>
                                            <!-- end button -->

                                          </td>
                                        </tr>
                                      </table>

                                    </td>
                                  </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->

                                </table>
                                 <!-- end content right -->

                              </td>
                            </tr>
                             <!-- end image and content -->

                         </table>
                         <!-- end LAYOUT-5 container width 560px -->
                       </td>
                     </tr>
                   </table>
                   <!-- end LAYOUT-5 container width 600px -->
                 </td>
               </tr>
               <!-- END LAYOUT-5  -->';
        break;
      }
      case "6":{
        $html='<!-- START LAYOUT-6 -->
        <tr  class="actions" style=" border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
               <tr>
                 <td align="center" valign="top"  class="fix-box">

                   <!-- start LAYOUT-6 container width 600px -->
                   <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; border-bottom:1px solid #c7c7c7; padding-left:20px; padding-right:20px;">
                     <tr>
                       <td valign="top">

                         <!-- start LAYOUT-6 container width 560px -->
                         <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">


                           <!--start space height -->
                           <tr>
                             <td height="20" ></td>
                           </tr>
                           <!--end space height -->

                           <!-- start image content -->
                           <tr>
                             <td valign="top" width="100%">



                               <!-- start content left -->
                               <table width="270" border="0" cellspacing="0" cellpadding="0" align="left"  class="full-width"  >

                                <tr>
                                   <td valign="top">

                                     <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" >
                                       <tr>

                                        <td valign="top" align="left" class="image-270px">
                                           <a href="$$link$$" class="link">
                                             <img  src="$$image$$" width="270" alt="image8_480x260" style="display:block !important; max-width:270px; " border="0" hspace="0" vspace="0"/>
                                           </a>
                                         </td>


                                       </tr>
                                     </table>

                                   </td>
                                 </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="20" ></td>
                                 </tr>
                                 <!--end space height -->


                               </table>
                               <!-- end content left -->


                                <!-- start space width -->
                               <table class="remove" width="1" border="0" cellpadding="0" cellspacing="0" align="left" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                 <tr>
                                   <td width="0" height="2" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                     <p style="padding-left: 20px;">&nbsp;</p>
                                   </td>
                                 </tr>
                               </table>
                               <!-- end space width -->



                                 <!-- start content left -->
                               <table width="270" border="0" cellspacing="0" cellpadding="0" align="right" class="full-width"  >


                                 <!-- start text content -->
                                 <tr>
                                   <td valign="top">
                                     <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                       <tr>
                                         <td  style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                           <span style="color: #555555; font-weight: 300;">
                                             <a class="link" id="title" href="$$link$$" style="text-decoration: none; color: #555555; font-weight: 300;">$$title$$</a>
                                           </span>
                                         </td>
                                       </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="15" ></td>
                                       </tr>
                                       <!--end space height -->

                                       <tr>
                                         <td id="content" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">
                                           $$content$$
                                         </td>
                                       </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="15" ></td>
                                       </tr>
                                       <!--end space height -->

                                       <tr>
                                         <td valign="top" width="auto" >
                                           <!-- start button -->
                                           <table border="0" align="left" cellpadding="0" cellspacing="0">
                                             <tr>
                                               <td width="auto"  align="center" valign="middle" height="32" style="$$exists_button9$$background-color:$$color$$;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                                 <span style="color: #ffffff; font-weight: 300;">
                                                   <a href="$$link$$" class="link" id="button" style="text-decoration: none; color: #ffffff; font-weight: 300;">$$name-button$$</a>
                                                 </span>
                                               </td>
                                             </tr>
                                           </table>
                                           <!-- end button -->

                                         </td>
                                       </tr>

                                       <!--start space height -->
                                       <tr>
                                         <td height="20" ></td>
                                       </tr>
                                       <!--end space height -->
                                     </table>
                                   </td>
                                 </tr>
                                 <!-- end text content -->
                               </table>
                               <!-- end content left -->


                             </td>
                           </tr>
                           <!-- end image content -->

                         </table>
                         <!-- end LAYOUT-6 container width 560px -->
                       </td>
                     </tr>
                   </table>
                   <!-- end LAYOUT-6 container width 600px -->
                 </td>
               </tr>
               <!-- END LAYOUT-6  -->';
        break;
      }
      case "7":{
        $html='<!-- START LAYOUT-7 -->
              <tr class="actions" style=" border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
               <tr>
                 <td align="center" valign="top"  class="fix-box">

                 <!-- start container width 600px -->
                 <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; border-bottom:1px solid #c7c7c7; padding-left:20px; padding-right:20px;">
                   <tr>
                     <td valign="top">

                       <!-- start container width 560px -->
                       <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">


                         <!--start space height -->
                         <tr>
                           <td height="20" ></td>
                         </tr>
                         <!--end space height -->

                         <!-- start image content -->
                         <tr>
                           <td valign="top" width="100%">



                             <!-- start content right -->
                             <table width="270" border="0" cellspacing="0" cellpadding="0" align="right"  class="full-width"  >

                              <tr>
                                 <td valign="top">

                                   <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" >
                                     <tr>
                                        <td valign="top" align="left" class="image-270px">
                                         <a href="#" class="link">
                                           <img  src="$$image$$" width="270" alt="image9_480x260" style="display:block !important; max-width:270px; " border="0" hspace="0" vspace="0"/>
                                         </a>
                                       </td>

                                     </tr>
                                   </table>

                                 </td>
                               </tr>

                               <!--start space height -->
                               <tr>
                                 <td height="20" ></td>
                               </tr>
                               <!--end space height -->


                             </table>
                             <!-- end content right -->


                              <!-- start space width -->
                             <table class="remove" width="1" border="0" cellpadding="0" cellspacing="0" align="right" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                               <tr>
                                 <td width="0" height="2" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                   <p style="padding-left: 20px;">&nbsp;</p>
                                 </td>
                               </tr>
                             </table>
                             <!-- end space width -->



                               <!-- start content left -->
                             <table width="270" border="0" cellspacing="0" cellpadding="0" align="left" class="full-width"  >


                               <!-- start text content -->
                               <tr>
                                 <td valign="top">
                                   <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                     <tr>
                                       <td  style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                         <span style="color: #555555; font-weight: 300;">
                                           <a href="$$link$$" style="text-decoration: none; color: #555555; font-weight: 300;" class="link" id="title">$$title$$</a>
                                         </span>
                                       </td>
                                     </tr>

                                     <!--start space height -->
                                     <tr>
                                       <td height="15" ></td>
                                     </tr>
                                     <!--end space height -->

                                     <tr>
                                       <td id="content" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">
                                         $$content$$
                                       </td>
                                     </tr>

                                     <!--start space height -->
                                     <tr>
                                       <td height="15" ></td>
                                     </tr>
                                     <!--end space height -->

                                     <tr>
                                       <td valign="top" width="auto" >
                                         <!-- start button -->
                                         <table border="0" align="left" cellpadding="0" cellspacing="0">
                                           <tr>
                                             <td width="auto"   align="center" valign="middle" height="32" style="$$exists_button9$$background-color:$$color$$;  border-radius:5px; background-clip: padding-box;font-size:13px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; text-align:center;  color:#ffffff; font-weight: 300; padding-left:18px; padding-right:18px; ">

                                               <span style="color: #ffffff; font-weight: 300;">
                                                 <a href="$$link$$" class="link" id="button" style="text-decoration: none; color: #ffffff; font-weight: 300;">$$name-button$$</a>
                                               </span>
                                             </td>
                                           </tr>
                                         </table>
                                         <!-- end button -->

                                       </td>
                                     </tr>

                                     <!--start space height -->
                                     <tr>
                                       <td height="20" ></td>
                                     </tr>
                                     <!--end space height -->
                                   </table>
                                 </td>
                               </tr>
                               <!-- end text content -->
                             </table>
                             <!-- end content left -->


                           </td>
                         </tr>
                         <!-- end image content -->

                       </table>
                       <!-- end container width 560px -->
                     </td>
                   </tr>
                 </table>
                 <!-- end  container width 600px -->
               </td>
              </tr>

               <!-- END LAYOUT-7  -->';
        break;
      }
      case "8":{
        $html = '<!-- START LAYOUT-8/1 -->
                <tr class="actions" style=" border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
                 <tr>
                   <td align="center" valign="top"  class="fix-box">

                     <!-- start  container width 600px -->
                     <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; border-bottom:1px solid #c7c7c7; padding-left:20px; padding-right:20px;">
                       <tr>
                         <td valign="top">

                           <!-- start  container width 560px -->
                           <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">

                             <!--start space height -->
                             <tr>
                               <td height="6" ></td>
                             </tr>
                             <!--end space height -->
                           <!-- start heading -->
                           <tr>
                             <td valign="top" >
                               <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
                                 <tr>
                                   <td align="left" valign="top" width="20" style="padding-right:10px;">
                                     <table width="20" border="0" cellspacing="0" cellpadding="0" align="left">
                                       <tr valign="top">
                                         <td  align="left" valign="middle"  >
                                           <img src="'.asset('img/photo.png').'" width="20" alt="photo" style="max-width:20px; display:block !important;" border="0" hspace="0" vspace="0"/>
                                         </td>
                                       </tr>
                                     </table>
                                   </td>

                                   <td align="left" style="font-size: 16px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left;">
                                     <span style="color: #727272; font-weight:300;">
                                       <a href="#" id="title" style="text-decoration: none; color: #727272; font-weight: 300;">$$title$$</a>
                                     </span>
                                   </td>

                                    <td align="right" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:$$color$$; font-weight:300; text-align:right;">
                                     <span id="date" style="color: $$color$$; font-weight:300;">
                                      $$date$$
                                     </span>
                                   </td>

                                 </tr>
                               </table>
                             </td>
                           </tr>
                           <!-- end heading -->

                             <!--start space height -->
                             <tr>
                               <td height="6" ></td>
                             </tr>
                             <!--end space height -->
                           </table>
                           <!-- end  container width 560px -->
                         </td>
                       </tr>
                     </table>
                     <!-- end  container width 600px -->
                   </td>
                 </tr>

                 <!-- END LAYOUT-8/1 -->
                 <!-- START LAYOUT-8/2 -->
                 <tr>
                   <td align="center" valign="top"  class="fix-box">

                     <!-- start  container width 600px -->
                     <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; border-bottom:1px solid #c7c7c7; padding-left:20px; padding-right:20px;">
                       <tr>
                         <td valign="top">

                           <!-- start  container width 560px -->
                           <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">

                             <!-- start image and content -->
                             <tr>
                               <td valign="top" width="100%">

                                <!--  start image and content left -->

                                <table width="268" border="0" cellspacing="0" cellpadding="0" align="left" class="full-width" >
                                    <tr>

                                      <!-- start image1 / 4column  -->
                                      <td valign="top" width="0" >
                                       <table width="124" border="0" cellspacing="0" cellpadding="0" align="left" class="full-width">

                                        <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <tr>
                                           <td  valign="top" align="center" id="link_1" >
                                             <a href="$$link_1$$">
                                               <img  src="$$image_1$$" width="124" alt="image10_280x224" style="height:100%; display:block !important; max-width:124px;" border="0" hspace="0" vspace="0"/>
                                             </a>

                                           </td>
                                         </tr>

                                         <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <!-- start text content -->
                                         <tr>
                                           <td valign="top">
                                             <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" >

                                               <tr>
                                                 <td id="content_1" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:center; ">
                                                    $$content_1$$
                                                 </td>
                                               </tr>


                                             </table>
                                           </td>
                                         </tr>
                                         <!-- end text content -->
                                           <!--start space height -->
                                         <tr>
                                           <td height="20" class="col-underline"></td>
                                         </tr>
                                         <!--end space height -->
                                       </table>

                                      </td>
                                      <!-- end image1 / 4column  -->


                                         <!-- space width -->
                                        <td valign="top" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                          <table width="15" class="space-scale"  border="0" cellspacing="0" cellpadding="0" align="left" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                            <tr>
                                              <td valign="top" style="font-size: 0;line-height: 0;border-collapse: collapse;">&nbsp;</td>
                                            </tr>
                                          </table>
                                        </td>
                                        <!-- space width -->


                                      <!-- start image2 / 4column  -->
                                      <td valign="top"  width="0" >
                                       <table width="124" border="0" cellspacing="0" cellpadding="0" align="right" class="full-width">

                                        <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <tr>
                                           <td  valign="top" align="center"  >
                                             <a href="$$link_2$$" id="link_2">
                                               <img   src="$$image_2$$" width="124" alt="image11_280x224" style="display:block !important; max-width:124px;" border="0" hspace="0" vspace="0"/>
                                             </a>

                                           </td>
                                         </tr>

                                         <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <!-- start text content -->
                                         <tr>
                                           <td valign="top">
                                             <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" >

                                               <tr>
                                                 <td id="content_2" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:center; ">

                                                      $$content_2$$

                                                 </td>
                                               </tr>


                                             </table>
                                           </td>
                                         </tr>
                                         <!-- end text content -->
                                           <!--start space height -->
                                         <tr>
                                           <td height="20" class="col-underline"></td>
                                         </tr>
                                         <!--end space height -->
                                       </table>

                                      </td>
                                      <!-- end image2 / 4column  -->
                                    </tr>

                                </table>

                                <!--  end image and content left -->
                                 <!-- start space width -->
                                 <table class="remove" width="1" border="0" cellpadding="0" cellspacing="0" align="left" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                   <tr>
                                     <td width="0" height="2" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                       <p style="padding-left: 20px;">&nbsp;</p>
                                     </td>
                                   </tr>
                                 </table>
                                 <!-- end space width -->


                                <!--  start image and content right -->
                                 <table width="268" border="0" cellspacing="0" cellpadding="0" align="left" class="full-width" >
                                    <tr>

                                      <!-- start image3 / 4column  -->
                                      <td valign="top" width="0" >
                                       <table width="124" border="0" cellspacing="0" cellpadding="0" align="left" class="full-width">

                                        <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <tr>
                                           <td  valign="top" align="center" >
                                             <a href="$$link_3$$" id="link_3">
                                               <img  src="$$image_3$$" width="124" alt="image12_280x224" style="display:block !important; max-width:124px;" border="0" hspace="0" vspace="0"/>
                                             </a>

                                           </td>
                                         </tr>

                                         <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <!-- start text content -->
                                         <tr>
                                           <td valign="top">
                                             <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" >

                                               <tr>
                                                 <td id="content_3" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:center; ">

                                                      $$content_3$$

                                                 </td>
                                               </tr>


                                             </table>
                                           </td>
                                         </tr>
                                         <!-- end text content -->
                                           <!--start space height -->
                                         <tr>
                                           <td height="20" class="col-underline"></td>
                                         </tr>
                                         <!--end space height -->
                                       </table>

                                      </td>
                                      <!-- end image4 / 4column  -->


                                      <!-- space width -->
                                        <td valign="top" style="font-size: 0;line-height: 0;border-collapse: collapse;">
                                          <table width="15" class="space-scale" border="0" cellspacing="0" cellpadding="0" align="left" style="font-size: 0;line-height: 0;border-collapse: collapse;" >
                                            <tr>
                                              <td valign="top" style="font-size: 0;line-height: 0;border-collapse: collapse;">&nbsp;</td>
                                            </tr>
                                          </table>
                                        </td>
                                        <!-- space width -->


                                      <!-- start image2 / 4column  -->
                                      <td valign="top"  width="0" >
                                       <table width="124" border="0" cellspacing="0" cellpadding="0" align="right" class="full-width">

                                        <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <tr>
                                           <td  valign="top" align="center"  >
                                             <a href="$$link_4$$" id="link_4">
                                               <img id="content_4" src="$$image_4$$" width="124" alt="image13_280x224" style="display:block !important; max-width:124px; " border="0" hspace="0" vspace="0"/>
                                             </a>

                                           </td>
                                         </tr>

                                         <!--start space height -->
                                         <tr>
                                           <td height="20" ></td>
                                         </tr>
                                         <!--end space height -->

                                         <!-- start text content -->
                                         <tr>
                                           <td valign="top">
                                             <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" >

                                               <tr>
                                                 <td id="content_4" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:center; ">

                                                      $$content_4$$

                                                 </td>
                                               </tr>


                                             </table>
                                           </td>
                                         </tr>
                                         <!-- end text content -->
                                           <!--start space height -->
                                         <tr>
                                           <td height="20" class="col-underline"></td>
                                         </tr>
                                         <!--end space height -->
                                       </table>

                                      </td>
                                      <!-- end image2 / 4column  -->
                                    </tr>

                                </table>

                                <!--  end image and content right -->

                               </td>
                             </tr>
                             <!-- end image and content -->

                           </table>
                           <!-- end container width 560px -->
                         </td>
                       </tr>
                     </table>
                     <!-- end  container width 600px -->
                   </td>
                 </tr>
                 <!-- END LAYOUT-8/2 -->';
        break;
      }
      case "9":{
        $html = '<!-- START LAYOUT-9 -->
        <tr  class="actions" ><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
                 <tr>
                   <td align="center" valign="top" class="fix-box" >

                     <!-- start  container width 600px -->
                     <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container" style="background-color: #ffffff; border-bottom:1px solid #c7c7c7; padding-left:20px; padding-right:20px;">

                      <!--start space height -->
                       <tr>
                         <td height="20" valign="top"></td>
                       </tr>
                       <!--end space height -->

                       <tr>
                         <td valign="top">

                           <!-- start container width 560px -->
                           <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">
                           <!-- start heading -->
                           <tr>
                             <td valign="top" >
                               <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
                                 <tr>
                                   <td align="left" valign="top" width="39" style="padding-right:10px;">
                                     <table width="39" border="0" cellspacing="0" cellpadding="0" align="left">
                                       <tr valign="top">
                                         <td  align="left" valign="middle"  >
                                           <img src="'.asset('img/calendar.png').'" width="31" alt="calendar" style="max-width:31px; display:block !important;" border="0" hspace="0" vspace="0"/>
                                         </td>
                                       </tr>
                                     </table>
                                   </td>

                                   <td align="left" style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                     <span style="color: #555555; font-weight:300;">
                                       <a href="$$link$$" style="text-decoration: none; color: #555555; font-weight: 300;"  id="title" class="link">$$title$$</a>
                                     </span>
                                   </td>

                                 </tr>
                               </table>
                             </td>
                           </tr>
                           <!-- end heading -->

                            <!--start space height -->
                             <tr>
                               <td height="15" ></td>
                             </tr>
                             <!--end space height -->

                            <!-- start text content -->
                             <tr>
                               <td valign="top">
                                 <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                   <tr>
                                     <td id="content" style="font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">
                                        $$content$$
                                     </td>
                                   </tr>


                                 </table>
                               </td>

                             </tr>

                             <!-- end text content -->

                             <!--start space height -->
                             <tr>
                               <td height="15" ></td>
                             </tr>
                             <!--end space height -->


                          <!-- start button text -->
                              <tr>
                                <td>
                                  <table align="left" border="0" cellspacing="0" cellpadding="0" >
                                    <tr>
                                      <td  style="font-size: 12px; line-height: 18px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:$$color$$; font-weight:300; text-align:center;" >
                                          <span style="text-decoration: none; color: $$color$$;"><a href="$$link$$" style="text-decoration: none; color: $$color$$; " id="button" class="link">$$name-button$$</a></span>
                                      </td>
                                         <td  style="$$exists_image$$padding-left:5px;"  align="left" valign="middle"  >
                                            <img src="'.asset('img/arrow2.png').'" width="10" alt="arrow1" style="max-width:10px; display:block !important; background-color:$$color$$;" border="0" hspace="0" vspace="0"/>
                                        </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <!-- end button text -->

                             <!--start space height -->
                             <tr>
                               <td height="20" valign="top"></td>
                             </tr>
                             <!--end space height -->



                           </table>
                           <!-- end  container width 560px -->
                         </td>
                       </tr>
                     </table>
                     <!-- end  container width 600px -->
                   </td>
                 </tr>
                 <!-- END LAYOUT-9 -->';
        break;
      }
      case "10":{
        $html='<!-- START LAYOUT-10 -->
        <tr  class="actions" style=" border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
              <tr>
                 <td align="center" valign="top" class="fix-box" >

                   <!-- start layout-10 container width 600px -->
                   <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container"  style="background-color: #ffffff; border-bottom:1px solid #c7c7c7; padding-left:20px; padding-right:20px;">
                     <tr>
                       <td valign="top">

                         <!-- start layout-10 container width 560px -->
                         <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">

                           <!--start space height -->
                           <tr>
                             <td height="20" ></td>
                           </tr>
                           <!--end space height -->

                          <!-- start container date and content -->
                           <tr>

                            <!-- start date content -->
                            <td valign="top">
                               <table width="110" border="0" cellspacing="0" cellpadding="0" align="left" style="height:110px; border-right:1px solid #bababa; ">
                                  <!--start space height -->
                                 <tr>
                                   <td height="15" ></td>
                                 </tr>
                                 <!--end space height -->

                                 <tr>
                                   <td  style="font-size: 38px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif;  color:#727272; font-weight:300; text-align:center; ">
                                      <div style="line-height:100%; font-weight:300;">
                                        <singleline id="day"> $$day$$ </singleline>
                                      </div>
                                   </td>
                                 </tr>

                                 <!-- start line divider -->
                                  <tr>
                                    <td align="center" valign="top">

                                       <table width="40%" border="0" cellspacing="0" cellpadding="0" align="center" style="height:2px; background-color:#bababa;">
                                          <tr>
                                            <td valign="top" height="1"></td>
                                          </tr>
                                       </table>

                                      </td>
                                  </tr>
                                 <!-- end line divider -->

                                  <tr>
                                   <td valign="top" style="font-size: 22px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif;  color:$$color$$; font-weight:300; text-align:center; ">
                                      <div style="line-height:100%; font-weight:300;">
                                        <singleline  id="month"> $$month$$ </singleline>
                                       </div>
                                   </td>
                                 </tr>

                                  <!--start space height -->
                                 <tr>
                                   <td height="15" ></td>
                                 </tr>
                                 <!--end space height -->

                               </table>
                             </td>
                             <!-- end date content -->
                              <!-- start space width -->
                              <td valign="top" >
                                <table width="20" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td valign="top">
                                      &nbsp;
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <!--end space width -->
                              <!-- start text content -->
                             <td valign="top">
                               <table border="0" cellspacing="0" cellpadding="0" align="left" >
                                 <tr>
                                   <td  style="font-size: 18px; line-height: 22px; font-family:Roboto,Open Sans, Arial,Tahoma, Helvetica, sans-serif; color:#555555; font-weight:300; text-align:left;">
                                     <span style="color: #555555; font-weight:300;">
                                       <a href="$$link$$"  id="title" class="link" style="text-decoration: none; color: #555555; font-weight: 300;">
                                         $$title$$
                                       </a>
                                     </span>
                                   </td>
                                 </tr>

                                 <!--start space height -->
                                 <tr>
                                   <td height="15" ></td>
                                 </tr>
                                 <!--end space height -->

                                 <tr>
                                   <td id="content"  style="font-size: 13px; line-height: 22px; font-family:Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">

                                       $$content$$

                                   </td>
                                 </tr>

                                <!--start space height -->
                                 <tr>
                                   <td height="15" ></td>
                                 </tr>
                                 <!--end space height -->

                                <!-- start button text -->
                                <tr>
                                  <td>
                                    <table align="left" border="0" cellspacing="0" cellpadding="0" >
                                      <tr>
                                        <td  style="font-size: 12px; line-height: 18px; font-family: Arial,Tahoma, Helvetica, sans-serif; color:$$color$$; font-weight:300; text-align:center;" >
                                            <span style="text-decoration: none; color: $$color$$;"><a href="$$link$$" style="text-decoration: none; color: $$color$$; "  id="link-name" class="link">$$name-button$$</a></span>
                                        </td>
                                           <td  style="$$exists_image$$padding-left:5px;"  align="left" valign="middle"  >
                                              <img src="'.asset('img/arrow2.png').'" width="10" alt="arrow1" style="max-width:10px; display:block !important; background-color:$$color$$;" border="0" hspace="0" vspace="0"/>
                                          </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <!-- end button text -->


                               </table>
                             </td>
                             <!-- end text content -->
                           </tr>

                           <!-- end container date and content -->


                           <!--start space height -->
                           <tr>
                             <td height="20" ></td>
                           </tr>
                           <!--end space height -->
                         </table>
                         <!-- end layout-10 container width 560px -->
                       </td>
                     </tr>
                   </table>
                   <!-- end layout-10 container width 600px -->
                 </td>
               </tr>
               <!-- END LAYOUT-10 -->';
        break;
      }
      case 11:{
        $html='<!-- START LAYOUT-13 -->
        <tr  class="actions" style="border-top: 1px solid #CECECE;"><td style="text-align:right;"><a href="$$edit$$"><span class="fa fa-pencil" style="font-size:30px">&nbsp;</span></a><a href="$$trash$$"><span class="fa fa-trash-o" style="font-size:30px">&nbsp;</span></a></td></tr>
               <tr>
                 <td align="center" valign="top"  class="fix-box" >
                   <!-- start  container width 600px -->
                   <table width="600"  align="center" border="0" cellspacing="0" cellpadding="0" class="container" style="background-color:#ffffff; border-bottom:1px solid #c7c7c7; padding-left:20px; padding-right:20px;">
                     <tr>
                       <td valign="top">
                         <!-- start  container width 560px -->
                         <table width="560"  align="center" border="0" cellspacing="0" cellpadding="0" class="full-width"  style="background-color:#ffffff; ">
                           <!--start space height -->
                           <tr>
                             <td height="20" ></td>
                           </tr>
                           <!--end space height -->
                          <!-- start text content -->
                           <tr>
                             <td height="auto" style="width:2px; background-color:$$color$$;">
                                <table width="2" border="0" cellspacing="0" cellpadding="0" align="left" >
                                  <tr>
                                    <td valign="top" height="auto">
                                    </td>
                                  </tr>
                                </table>
                              </td>
                             <td valign="top">
                               <table border="0" cellspacing="0" cellpadding="0" align="left" style="background-color:#f6f6f6;  padding:10px;">
                                 <tr>
                                   <td  style="padding-left:10px; font-size: 13px; line-height: 22px; font-family:Roboto,Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:#727272; font-weight:300; text-align:left; ">
                                       " $$content$$ "
                                   </td>
                                 </tr>
                               </table>
                             </td>
                           </tr>
                           <!-- end text content -->
                           <!--start space height -->
                           <tr>
                             <td height="20" ></td>
                           </tr>
                           <!--end space height -->
                         </table>
                         <!-- end container width 560px -->
                       </td>
                     </tr>
                   </table>
                   <!-- end  container width 600px -->
                 </td>
               </tr>
               <!-- END LAYOUT-13 -->';
        break;
      }
		}
		return $html;
	}
  public function getForm($option){
    $html="";
    switch($option){
      case "1":{ 
        $html='<div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="title" id="title" class="form-control" name="title" value="$$title$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="link">Link:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="link" id="link" class="form-control" value="$$link$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido:</label>
                   <div class="col-sm-6 col-lg-8 controls">
                       <textarea name="content" id="content" class="form-control wysihtml5" rows="6">$$content$$</textarea>
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">Link bot&oacute;n "Principal":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="principal" id="principal" class="form-control" value="$$principal$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo bot&oacute;n "Principal":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="name-principal" id="name-principal" class="form-control" value="$$name-principal$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">Link bot&oacute;n "Secundario":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="secondary" id="secondary" class="form-control" value="$$secondary$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo bot&oacute;n "Secundario":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="name-secondary" id="name-secondary" class="form-control"  value="$$name-secondary$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Imagen</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                           <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                              <img src="$$image$$" alt="" />
                                           </div>
                                           <div class="fileupload-preview fileupload-exists img-thumbnail" id="image_1" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                           <div>
                                              <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                              <span class="fileupload-exists">Cambiar</span>
                                              <input type="file" name="image" class="file-input" /></span>
                                              <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                           </div>
                                        </div>
                                        <span style="font-size:12px">*Imagen de 600px x 300px</span>                
                                     </div>

              </div>';
        break; 
      }
      case "2":{ 
        $html='<div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="title" id="title_2" class="form-control" value="$$title$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Sub T&iacute;tulo:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="subtitle" id="subtitle_2" class="form-control" value="$$subtitle$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="link">Link:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="link" id="link_2" class="form-control"  value="$$link$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido:</label>
                   <div class="col-sm-6 col-lg-8 controls">
                       <textarea name="content" id="content_2" class="form-control wysihtml5" rows="5">$$content$$</textarea>
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">Link bot&oacute;n "Izquierdo":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="boton_1" id="boton_1" class="form-control" value="$$boton_1$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo bot&oacute;n "Izquierdo":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="name-principal" id="name-boton_1" class="form-control" value="$$name-principal$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">Link bot&oacute;n "Derecho":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="boton_2" id="boton_2" class="form-control" value="$$boton_2$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo bot&oacute;n "Secundario":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="name-boton_2" id="name-boton_2" class="form-control" value="$$name-boton_2$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Imagen</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                           <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                              <img src="$$image$$" alt="" />
                                           </div>
                                           <div class="fileupload-preview fileupload-exists img-thumbnail" id="image_1" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                           <div>
                                              <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                              <span class="fileupload-exists">Cambiar</span>
                                              <input type="file" name="image" class="file-input" /></span>
                                              <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                           </div>
                                        </div>
                                        <span style="font-size:12px">*Imagen de 270px x 328px</span> 
                                  </div>
              </div>';
        break; 
      }
      case "3" : {
        $html='<div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="title" id="title_form_3" class="form-control" value="$$title$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Sub T&iacute;tulo:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="subtitle" id="subtitle_form_3" class="form-control" value="$$subtitle$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="link">Link:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="link" id="link_form_3" class="form-control"  value="$$link$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido:</label>
                   <div class="col-sm-6 col-lg-8 controls">
                       <textarea rows="5" name="content" id="content_form_3" class="form-control wysihtml5">$$content$$"</textarea>
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">Link bot&oacute;n "Izquierdo":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="boton_1" id="boton_form_1" class="form-control" value="$$boton_1$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo bot&oacute;n "Izquierdo":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="name-boton_1" id="name-boton_form_1" class="form-control" value="$$name-boton_1$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">Link bot&oacute;n "Derecho":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="boton_2" id="boton_form_2" class="form-control" value="$$boton_2$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo bot&oacute;n "Secundario":</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="name-boton_2" id="name-boton_form_2" class="form-control" value="$$name-boton_2$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Imagen</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                           <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                              <img src="$$image$$" alt="" />
                                           </div>
                                           <div class="fileupload-preview fileupload-exists img-thumbnail" id="image_1" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                           <div>
                                              <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                              <span class="fileupload-exists">Cambiar</span>
                                              <input type="file" name="image" class="file-input" /></span>
                                              <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                           </div>
                                        </div>
                                        <span style="font-size:12px">*Imagen de 270px x 328px</span> 
                                  </div>
              </div>'; 
        break; 
      }
      case "4" : { 
        $html='<div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo Izquierdo:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="title_left" id="title_left_form" class="form-control" value="$$title_left$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo Derecho:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="title_right" id="title_right_form" class="form-control" value="$$title_right$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="link">Link Izquierdo:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="link_left" id="link_form_left" class="form-control"  value="$$link_left$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="content">Link Derecho:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="link_right" id="link_form_right" class="form-control" value="$$link_right$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">Descripci&oacute;n Izquierda:</label>
                   <div class="col-sm-6 col-lg-8 controls">
                       <input type="text" name="content_left" id="content_left_form" class="form-control wysihtml5" value="$$content_left$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">Descripci&oacute;n Derecha:</label>
                   <div class="col-sm-6 col-lg-8 controls">
                       <input type="text" name="content_right" id="content_right_form" class="form-control wysihtml5" value="$$content_right$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Imagen Izquierda</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                           <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                              <img src="$$image_left$$" alt="" />
                                           </div>
                                           <div class="fileupload-preview fileupload-exists img-thumbnail" id="image" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                           <div>
                                              <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                              <span class="fileupload-exists">Cambiar</span>
                                              <input type="file" name="image_left" class="file-input" /></span>
                                              <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                           </div>
                                        </div>
                                        <span style="font-size:12px">*Imagen de 270px x 328px</span> 
                                     </div>
              </div>
              <div class="form-group">
                                    <label class="col-sm-3 col-lg-2 control-label">Imagen Derecha</label>
                                    <div class="col-sm-9 col-lg-10 controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                           <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                              <img src="$$image_right$$" alt="" />
                                           </div>
                                           <div class="fileupload-preview fileupload-exists img-thumbnail" id="image" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                           <div>
                                              <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                              <span class="fileupload-exists">Cambiar</span>
                                              <input type="file" name="image_right" class="file-input" /></span>
                                              <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                           </div>
                                        </div>
                                        <span style="font-size:12px">*Imagen de 270px x 328px</span>           
                                     </div>
              </div>';
             
        break; 
      }
      case "5" : { 
        $html='<div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
              <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo 1:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="title_1" id="title_1_form" class="form-control" value="$$title_1$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo 2:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="title_2" id="title_2_form" class="form-control" value="$$title_2$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo 3:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="title_3" id="title_3_form" class="form-control" value="$$title_3$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="link">Link 1:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="link_1" id="link_form_1" class="form-control"  value="$$link_1$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">Link 2:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="link_2" id="link_form_2" class="form-control" value="$$link_2$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">Link 3:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="link_3" id="link_form_3" class="form-control" value="$$link_3$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="principal">Descripci&oacute;n 1:</label>
                     <div class="col-sm-6 col-lg-8 controls">
                         <textarea rows="5" name="content_1" id="content_1_form" class="form-control wysihtml5">$$content_1$$</textarea>
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="principal">Descripci&oacute;n 2:</label>
                     <div class="col-sm-6 col-lg-8 controls">
                         <textarea rows="5" name="content_2" id="content_2_form" class="form-control wysihtml5">$$content_2$$</textarea>
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="principal">Descripci&oacute;n 3:</label>
                     <div class="col-sm-6 col-lg-8 controls">
                         <textarea rows="5" name="content_3" id="content_3_form" class="form-control wysihtml5">$$content_3$$</textarea>
                     </div>
                </div>
                <div class="form-group">
                                      <label class="col-sm-3 col-lg-2 control-label">Imagen 1</label>
                                      <div class="col-sm-9 col-lg-10 controls">
                                          <div class="fileupload fileupload-new" data-provides="fileupload">
                                             <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                                <img src="$$image_1$$" alt="" />
                                             </div>
                                             <div class="fileupload-preview fileupload-exists img-thumbnail" id="image" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                             <div>
                                                <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                                <span class="fileupload-exists">Cambiar</span>
                                                <input type="file" name="image_1" class="file-input" /></span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                             </div>
                                          </div>   
                                          <span style="font-size:12px">*Imagen de 170px x 207px</span>             
                                      </div>
                </div>
                <div class="form-group">
                                      <label class="col-sm-3 col-lg-2 control-label">Imagen 2</label>
                                      <div class="col-sm-9 col-lg-10 controls">
                                          <div class="fileupload fileupload-new" data-provides="fileupload">
                                             <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                                <img src="$$image_2$$" alt="" />
                                             </div>
                                             <div class="fileupload-preview fileupload-exists img-thumbnail" id="image" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                             <div>
                                                <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                                <span class="fileupload-exists">Cambiar</span>
                                                <input type="file" name="image_2" class="file-input" /></span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                             </div>
                                          </div>
                                          <span style="font-size:12px">*Imagen de 170px x 207px</span> 
                                       </div>
                </div>
                <div class="form-group">
                                      <label class="col-sm-3 col-lg-2 control-label">Imagen 3</label>
                                      <div class="col-sm-9 col-lg-10 controls">
                                          <div class="fileupload fileupload-new" data-provides="fileupload">
                                             <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                                <img src="$$image_3$$" alt="" />
                                             </div>
                                             <div class="fileupload-preview fileupload-exists img-thumbnail" id="image" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                             <div>
                                                <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                                <span class="fileupload-exists">Cambiar</span>
                                                <input type="file" name="image_3" class="file-input" /></span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                             </div>
                                          </div>
                                          <span style="font-size:12px">*Imagen de 170px x 207px</span> 
                                       </div>
                </div>';
               
        break; 
      }
      case "6":{ 
        $html='<div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="title" id="title-form" class="form-control" value="$$title$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="link">Link:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="link" id="link-form" class="form-control"  value="$$link$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido:</label>
                   <div class="col-sm-6 col-lg-8 controls">
                       <textarea rows="5" name="content" id="content-form" class="form-control wysihtml5">$$content$$</textarea>
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo bot&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="name-button" id="name-boton-form" class="form-control" value="$$name-button$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                              <label class="col-sm-3 col-lg-2 control-label">Imagen</label>
                              <div class="col-sm-9 col-lg-10 controls">
                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                     <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                        <img src="$$image$$" alt="" />
                                     </div>
                                     <div class="fileupload-preview fileupload-exists img-thumbnail" id="image_1" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                     <div>
                                        <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                        <span class="fileupload-exists">Cambiar</span>
                                        <input type="file" name="image" class="file-input" /></span>
                                        <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                     </div>
                                  </div>
                                  <span style="font-size:12px">*Imagen de 270px x 328px</span> 
                              </div>
              </div>';
        break; 
      }
      case "7":{ 
        $html=' <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="title" id="title-form" class="form-control" value="$$title$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="link">Link:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="link" id="link-form" class="form-control"  value="$$link$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido:</label>
                     <div class="col-sm-6 col-lg-8 controls">
                         <textarea rows="5" name="content" id="content-form" class="form-control wysihtml5">$$content$$</textarea>
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo bot&oacute;n:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="name-button" id="name-boton-form" class="form-control" name="name-principal" value="$$name-button$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                               <label class="col-sm-3 col-lg-2 control-label">Imagen</label>
                               <div class="col-sm-9 col-lg-10 controls">
                                   <div class="fileupload fileupload-new" data-provides="fileupload">
                                      <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                         <img src="$$image$$" alt="" />
                                      </div>
                                      <div class="fileupload-preview fileupload-exists img-thumbnail" id="image_1" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                      <div>
                                         <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                         <span class="fileupload-exists">Cambiar</span>
                                         <input type="file" name="image" class="file-input" /></span>
                                         <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                      </div>
                                   </div>  
                                   <span style="font-size:12px">*Imagen de 270px x 328px</span>               
                             </div>
                </div>';
        break; 
      }
      case "8":{ 
        $html='<div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="title" id="title-form" class="form-control" value="$$title$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="title">Fecha:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="date" id="date-form" class="form-control" value="$$date$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="link">Link 1:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="link_1" id="link1-form" class="form-control"  value="$$link_1$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="link">Link 2:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="link_2" id="link2-form" class="form-control"  value="$$link_2$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="link">Link 3:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="link_3" id="link3-form" class="form-control"  value="$$link_3$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="link">Link 4:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="link_4" id="link4-form" class="form-control"  value="$$link_4$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido 1:</label>
                     <div class="col-sm-6 col-lg-8 controls">
                         <textarea rows="5" name="content_1" id="content1-form" class="form-control wysihtml5">$$content_1$$</textarea>
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido 2:</label>
                     <div class="col-sm-6 col-lg-8 controls">
                          <textarea rows="5" name="content_2" id="content2-form" class="form-control wysihtml5">$$content_2$$</textarea>
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido 3:</label>
                     <div class="col-sm-6 col-lg-8 controls">
                         <textarea rows="5" name="content_3" id="content3-form" class="form-control wysihtml5">$$content_3$$</textarea>
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido 4:</label>
                     <div class="col-sm-6 col-lg-8 controls">
                         <textarea rows="5" name="content_4" id="content4-form" class="form-control wysihtml5">$$content_4$$</textarea>
                     </div>
                </div>
                <div class="form-group">
                           <label class="col-sm-3 col-lg-2 control-label">Imagen 1</label>
                           <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new" data-provides="fileupload">
                                  <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                     <img src="$$image_1$$" alt="" />
                                  </div>
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" id="image_1" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                  <div>
                                     <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                     <span class="fileupload-exists">Cambiar</span>
                                     <input type="file" name="image_1" class="file-input" /></span>
                                     <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                  </div>
                               </div>
                               <span style="font-size:12px">*Imagen de 124px x 151px</span> 
                           </div>
               </div>
               <div class="form-group">
                           <label class="col-sm-3 col-lg-2 control-label">Imagen 2</label>
                           <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new" data-provides="fileupload">
                                  <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                     <img src="$$image_2$$" alt="" />
                                  </div>
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" id="image_1" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                  <div>
                                     <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                     <span class="fileupload-exists">Cambiar</span>
                                     <input type="file" name="image_2" class="file-input" /></span>
                                     <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                  </div>
                               </div>
                               <span style="font-size:12px">*Imagen de 124px x 151px</span> 
                           </div>
              </div>
              <div class="form-group">
                           <label class="col-sm-3 col-lg-2 control-label">Imagen 3</label>
                           <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new" data-provides="fileupload">
                                  <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                     <img src="$$image_3$$" alt="" />
                                  </div>
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" id="image_1" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                  <div>
                                     <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                     <span class="fileupload-exists">Cambiar</span>
                                     <input type="file" name="image_3" class="file-input" /></span>
                                     <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                  </div>
                               </div>
                               <span style="font-size:12px">*Imagen de 124px x 151px</span> 
                           </div>
              </div>
              <div class="form-group">
                           <label class="col-sm-3 col-lg-2 control-label">Imagen 4</label>
                           <div class="col-sm-9 col-lg-10 controls">
                               <div class="fileupload fileupload-new" data-provides="fileupload">
                                  <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                     <img src="$$image_4$$" alt="" />
                                  </div>
                                  <div class="fileupload-preview fileupload-exists img-thumbnail" id="image_1" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                  <div>
                                     <span class="btn btn-default btn-file"><span class="fileupload-new">Seleccionar Imagen</span>
                                     <span class="fileupload-exists">Cambiar</span>
                                     <input type="file" name="image_4" class="file-input" /></span>
                                     <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                  </div>
                               </div>
                               <span style="font-size:12px">*Imagen de 124px x 151px</span> 
                           </div>
               </div>';
        break; 
      }
      case "9":{ 
        $html='<div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="title" id="title-form" class="form-control" value="$$title$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="link">Link:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="link" id="link-form" class="form-control"  value="$$link$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido:</label>
                   <div class="col-sm-6 col-lg-8 controls">
                       <textarea rows="5" name="content" id="content-form" class="form-control wysihtml5">$$content$$</textarea>
                   </div>
              </div>
              <div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo link:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="text" name="name-button" id="name-link-form" class="form-control" value="$$name-button$$" data-rule-required="true" data-rule-minlength="3" />
                   </div>
              </div>';
        break; 
      }
      case "10":{ 
        $html='<div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
              <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="title">T&iacute;tulo:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="title" id="title-form" class="form-control" value="$$title$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="link">Link:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="link" id="link-form" class="form-control"  value="$$link$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido:</label>
                     <div class="col-sm-8 col-lg-8 controls">
                         <textarea rows="5" name="content" id="content-form" class="form-control wysihtml5">$$content$$</textarea>
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">D&iacute;a:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="day" id="day-form" class="form-control" value="$$day$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="content">Mes:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="month" id="month-form" class="form-control" value="$$month$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>
                <div class="form-group">
                     <label class="col-sm-3 col-lg-2 control-label" for="principal">T&iacute;tulo link:</label>
                     <div class="col-sm-6 col-lg-4 controls">
                         <input type="text" name="name-button" id="name-link-form" class="form-control" value="$$name-button$$" data-rule-required="true" data-rule-minlength="3" />
                     </div>
                </div>';
        break; 
      }
      case "11":{ 
        $html='<div class="form-group">
                   <label class="col-sm-3 col-lg-2 control-label" for="title">Posici&oacute;n:</label>
                   <div class="col-sm-6 col-lg-4 controls">
                       <input type="number" name="position" id="position" class="form-control" name="title" value="$$position$$" />
                   </div>
              </div>
              <div class="form-group">
                 <label class="col-sm-3 col-lg-2 control-label" for="content">Contenido:</label>
                 <div class="col-sm-6 col-lg-8 controls">
                   <textarea rows="5" name="content" id="content-form" class="form-control wysihtml5">$$content$$</textarea>
                 </div>
               </div>';
        break; 
      }
    }
   
    return $html;
  }
}