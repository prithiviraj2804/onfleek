<div bgcolor="#EEEEEE" style="width:100%!important;min-width:100%;color:#222222;font-family:'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight:normal;text-align:left;line-height:19px;font-size:14px;background:#eeeeee;margin:0;padding:0">
   <div> </div>
   <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;height:100%;width:100%;color:#222222;font-family:'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0">
      <tbody>
         <tr align="left" style="vertical-align:top;text-align:left;padding:0">
            <td align="center" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:center;color:#222222;font-family:'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0" valign="top">
               <center style="width:100%;min-width:580px">
                  <table bgcolor="#FFFFFF" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:580px;border-radius:4px;background:#ffffff;margin:0 auto;padding:0;border:1px solid #e2e2e2">
                     <tbody>
                        <tr align="left" style="vertical-align:top;text-align:left;padding:0">
                           <td align="left" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222222;font-family:'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:30px 40px" valign="top">
                              <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;display:block;padding:0px">
                                 <tbody>
                                    <tr align="left" style="vertical-align:top;text-align:left;padding:0">
                                    </tr>
                                 </tbody>
                              </table>
                              <table width="100%">
                                 <tr width="100%">
                                    <td style="width:50%;text-align: left;padding: 10px 10px;">
                                       <div class="company_logo">
                                             <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details();
                                                         if ($company_details->workshop_logo) { ?>
                                             <img class="hidden-md-down" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="300" height="100" alt="<?php echo $company_details->workshop_name; ?>">
                                             <?php 
                                                      } ?>
                                       </div>
                                    </td>
                                    <td style="width:50%;text-align: right; padding: 10px 10px;">
                                       <div>
                                             <?php echo $company_details->workshop_name; ?>
                                             <?php if ($company_details->branch_street) {
                                                   echo $company_details->branch_street;
                                                }
                                                if ($company_details->area_name) {
                                                   echo ", <br>" . $company_details->area_name;
                                                }
                                                if ($company_details->state_name) {
                                                   echo ", <br>" . $company_details->state_name;
                                                }
                                                if ($company_details->branch_pincode) {
                                                   echo " - " . $company_details->branch_pincode;
                                                }
                                                if ($company_details->branch_country) {
                                                   echo  ", <br>" .$company_details->branch_country;
                                                }
                                                ?>
                                             <?php if ($company_details->branch_contact_no) {
                                                            echo '<br><span>' . $company_details->branch_contact_no . '</span>';
                                                         } ?>
                                             <?php if ($company_details->branch_email_id) {
                                                            echo '<br><span>' . $company_details->branch_email_id . '</span>';
                                                         } ?>
                                             <?php if ($company_details->branch_gstin) {
                                                            echo '<br><span>' . $company_details->branch_gstin . '</span>';
                                                         } ?>
                                       </div>
                                    </td>
                                 </tr>
                              </table>
                              <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;display:block;padding:0px">
                                 <tbody>
                                    <tr align="left" style="vertical-align:top;text-align:left;padding:0">
                                       <td align="left" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222222;font-family:'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px" valign="top">
                                          <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:580px;margin:0 auto;padding:0">
                                             <tbody>
                                                <tr align="left" style="vertical-align:top;text-align:left;padding:0">
                                                   <td align="left" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:left;color:#222222;font-family:'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px 0px 10px" valign="top">
                                                      <h1 style="font-family:arial;font-size:18px;color:#000;padding:10px 0 5px 10px;margin:0">Dear <?php echo ucfirst($client_name); ?>,</h1>
															         <p style="font-family:arial;font-size:13px;color:#333;padding:10px 0 5px 10px;margin:0;line-height:22px">
                                                          Your service for vehicle has been created with <?php echo$company_details->workshop_name;?> Successfully. Thank you for choosing us. <?php echo $company_details->branch_contact_no; ?>
                                                      </p>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <hr style="color:#d9d9d9;height:1px;background:#d9d9d9;border:none">
                              <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;display:block;padding:0px;">
                                 <tbody style="width: 100%;float: left;text-align: right;">
                                    <tr align="right" style="vertical-align:top;text-align:left;padding:0;width: 100%;float: left;text-align: right;">
                                       <td align="right" style="word-break: break-word;border-collapse: collapse!important;vertical-align: top;text-align: left;color: #222222;font-family: 'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight: normal;line-height: 19px;font-size: 14px;margin: 0;padding: 10px 20px 0px 0px;width: 100%;float: left;text-align: right;" valign="top">
                                          Powered By MechToolz
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <table style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:inherit;width:580px;margin:0 auto;padding:0">
                                 <tbody>
                                    <tr align="left" style="vertical-align:top;text-align:left;padding:0">
                                       <td align="center" style="word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:center;color:#222222;font-family:'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px" valign="top">
                                          <div>
                                             <span style="float:none;display:block;text-align:center">
                                                <a href="<?php echo base_url(); ?>" target="_blank" data-saferedirecturl="<?php echo base_url(); ?>">
                                                   <img align="none" height="50" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolz-logo.png" style="outline:none;text-decoration:none;width:150px;max-width:100%;clear:both;display:block;float:left;text-align:center;margin:0px auto;height:50px" width="150">
                                                </a>
                                             </span>
                                          </div>
                                       </td>
                                       <td align="right" style="width: 50px;word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:right;color:#222222;font-family:'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px" valign="top">
                                          <div>
                                             <span style="float:right;display:block;text-align:right">
                                                <a href="https://www.facebook.com/mechtoolz08/" target="_blank" data-saferedirecturl="https://www.facebook.com/mechtoolz08/">
                                                   <img align="right" height="30" src="<?php echo base_url(); ?>assets/mp_backend/img/facebook-logo-button.png" style="outline:none;text-decoration:none;width:30px;max-width:100%;clear:both;display:block;float:left;text-align:right;margin:10px auto;height:30px" width="30">
                                                </a>
                                             </span>
                                          </div>
                                       </td>
                                       <td align="right" style="width: 50px;word-break:break-word;border-collapse:collapse!important;vertical-align:top;text-align:right;color:#222222;font-family:'Avenir-Next','Avenir','Helvetica','Arial',sans-serif;font-weight:normal;line-height:19px;font-size:14px;margin:0;padding:0px" valign="top">
                                          <div>
                                             <span style="float:right;display:block;text-align:right">
                                                <a href="https://www.linkedin.com/company/mechtoolz/people/" target="_blank" data-saferedirecturl="https://www.linkedin.com/company/mechtoolz/people/">
                                                   <img align="right" height="30" src="<?php echo base_url(); ?>assets/mp_backend/img/linkedin-logo.png" style="outline:none;text-decoration:none;width:30px;max-width:100%;clear:both;display:block;float:left;text-align:right;margin:10px auto;height:30px" width="30">
                                                </a>
                                             </span>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </center>
            </td>
         </tr>
      </tbody>
   </table>
   <u></u> <u></u>
   <img src="https://ci3.googleusercontent.com/proxy/H6Hw8lJxel4_JjjBxmgwodgTX_54WxoWS9YhFmPCV8OIw792UhsuOns2cBsBJCtRsHxYYL1gc3nccFBm6FTuz-7rfdq7qjXLlHAGy96atj7GIpP4R-onS9hpOQdDSpvD3p29PZIFCAmLqP4f_ztxBfyJxLh10AVBHdrBoMGZKzhYzVCxzJtaMj1V3PoXfFobueac_jnjt2jtem_uHQXT2uVDEThsdB0wUiJuLMC5pJm6ICanjqZUh0hamsARz5GZH2825vJJnmUsrug1APxfp9BFhB6LFkdOL8mxpFsTiFyXx_1hADBywG_8zziLQZ9hDukPTCOZDFCpz-xaw7FaU_5sWjjhFqFBotWFj6CVsG9rjvw1dFt2j5LITNVW_mz70XbPiVm2pwVXUuucKzsZrV0CGy-gt2USEh418QUHtn0Plowyn-iXdWqkKzYzYw442FNxUhS0nv3sXGTzMajqzsGPZx1Az9rqV18Ok2QwvgheiWlgykr3aKfK0kUky2bSeiDvP1kPISzHLABUpBoqZTw6F9hgumwustY3-pC3yyMUVN9SwoGynVWNLv8NYfudryvh5uBISpNFrsYLaoTwQ1-23-EjTdXygd30PEQDHbZBGLjqw8NLA4LD6FewZCFnkBDxWIi5NPh0763iui5HZqhhvnVwi-0PdK_GS0CFy6E6UEIRWRE3jd_cow6f0X7bpw=s0-d-e1-ft#http://click.yourmechanic.com/wf/open?upn=rqi-2BLyPKV6KqZlVCWwPAfZpNiuu3VgumePet7NG2mEAA1eXg4DS-2B5bihSbsx3rPjG2TJ3wAw5yUUhD9quF-2BqakZnoGzgHjNEnUddDOhOI4y1OnC3NnQEbipNRyB2EBxdf54fFP9pkvUv48Jn7UhQ2Fnub4EmQG5Z7xKyA6pp2N7q7l5UlimCV4YRAt5pp3vjjwuKO6C7DjTCfuzbO1t8EvEsJkXKRFpyAOXMvIpneohBFxjhK757POybukolc7EMhzM3pbV3WjA-2BCuI34CpszhpRdIcX6omdbFZurNIj5zr7FEIzVEStE-2BbxbzV-2Bvw2ucUEQ7K1Mni-2BjHxbu5pZTXdH1URipPFRxbsBhApGzrCJHngqiK1EaeFCHQFLzMFQt3Yps0JurdULKvQXCL2azXvXO2qGSg5xXNN1kroVyeGSNf1qwQfSjC-2FceXHCbkokp" alt="" width="1" height="1" border="0" style="height:1px!important;width:1px!important;border-width:0!important;margin-top:0!important;margin-bottom:0!important;margin-right:0!important;margin-left:0!important;padding-top:0!important;padding-bottom:0!important;padding-right:0!important;padding-left:0!important">
</div>