<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>
<link href="<?php echo $path_url; ?>css/easy-responsive-tabs.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $path_url; ?>css/intlTelInput.css">
<div id="myUserModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 style="padding-left: 40px;">User</h3>
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>
                                <th>Name</th>
                            </td>
                            <td id="user_name"></td>
                        </tr>
                        <tr>
                            <td>
                                <th>Email</th>
                            </td>
                            <td id="user_email"></td>
                        </tr>
                        <tr>
                            <td>
                                <th>Account Created Date</th>
                            </td>
                            <td id="user_acct_date"></td>
                        </tr>
                        <tr>
                            <td>
                                <th>Account Status</th>
                            </td>
                            <td id="user_acct_status"></td>
                        </tr>
                        <tr>
                            <td>
                                <th>Role</th>
                            </td>
                            <td id="user_role"></td>
                        </tr>
                    </tbody>
                </table>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-10 page-content col-xs-12 col-sm-10 col-md-10" id="page-content">
<?php
	// require_footer 
	require APPPATH.'views/__layout/filterlayout.php';
?>
	<!-- lower row -->
	<div class="row conent-area announcement" id="conent-area">
		<!-- first row -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<!-- item list-->
				<!-- item -->
				<div class="col-lg-12 col-md-4 col-sm-4 col-xs-4 widget widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<!-- widget title -->
					  			<div class="row">
					  				<div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 widget-title">
						  				<h4>Settings</h4>
					  				</div>
					  			</div>
							</div>
						</div>
							<div class="row widget-body">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div>
										<div class="setting-container">
											<div id="settings">          
										  		<ul class="resp-tabs-list vert">
									      			<li>General</li>
											      	<li>Change Password</li>
											      	<?php if(count($roles_right) > 0){ ?>
											      	<li>User</li>
											      	<?php } ?>
											  	</ul> 

									  			<div class="resp-tabs-container vert">                                                        
									      			<div id="general-setting-tab"> 
									      				<div class="form-container">
												          	<?php $attributes = array('name' => 'generalForm', 'id' => 'generalForm','class'=>'form-container'); echo form_open('', $attributes);?>
												               	<input type="hidden" value="" name="id" id="serial">
											                	<fieldset>
												                	<div class="field-container">
												                		<div class="upper-row">
												                			<label><span class="icon-user"></span> Name *</label>
												                		</div>
												                		<div class="field-row">
												                			<div class="left-column">
													                			<input type="text" id="inputFirstName" name="inputFirstName" placeholder="First Name"  tabindex="1" value="<?php if(isset($getUserInfo)){echo $getUserInfo[0]->first_name;} ?>">
													                		</div>
												                			<div class="right-column">
													                			<input type="text" id="inputLastName" name="inputLastName" placeholder="Last Name"  tabindex="1" value="<?php if(isset($getUserInfo)){echo $getUserInfo[0]->last_name;} ?>">
													                		</div>
												                		</div>
												                	</div>											                
												                	<div class="field-container">
												                		<div class="upper-row">
												                			<label><span class="icon-mail-alt"></span> Email *</label>
												                		</div>
												                		<div class="field-row">
												                			<div class="left-column">
												                				<input type="text" id="inputEmail" name="inputEmail" placeholder="Email"  tabindex="2" value="<?php if(isset($getUserInfo)){echo $getUserInfo[0]->email;} ?>">
												                			</div>
												                			<div class="right-column">
												                				<input type="text" id="inputPhone" name="inputPhone" placeholder="Phone" tabindex="3" value="<?php if(isset($getUserInfo)){echo $getUserInfo[0]->phone;} ?>">
												                			</div>
												                		</div>
												                	</div>
												                	<div class="field-container">
												                		<div class="upper-row">
												                			<label><span class="icon-globe"></span> Country *</label>
												                		</div>
												                		<div class="field-row">
												                			<div class="left-column">
													                			<select  class="js-chosen" id="inputCountry"  name="inputCountry"  tabindex="4">
												                                    <option value="US" selected="selected">United States</option>
												                                    <option value="GB">United Kingdom</option>
												                                    <option value="CA">Canada</option>
												                                    <option value="AF">Afghanistan</option>
												                                    <option value="AL">Albania</option>
												                                    <option value="DZ">Algeria</option>
												                                    <option value="AD">Andorra</option>
												                                    <option value="AO">Angola</option>
												                                    <option value="AI">Anguilla</option>
												                                    <option value="AG">Antigua And Barbuda</option>
												                                    <option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AC">Ascension Island</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia And Herzegovina</option><option value="BW">Botswana</option><option value="BR">Brazil</option><option value="BN">Brunei Darussalam</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CC">Cocos (keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CD">Congo</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DG">Diego Garcia</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="TL">East Timor</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands (malvinas)</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GN">Guinea</option><option value="GW">Guinea-bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="VA">Holy See (vatican City State)</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran (islamic Republic Of)</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KP">Korea, North</option><option value="KR">Korea, South</option><option value="XK">Kosovo</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libyan Arab Jamahiriya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macau</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MP">Mariana Islands</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova, Republic Of</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestine</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russian Federation</option><option value="RW">Rwanda</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="AS">Samoa, American</option><option value="WS">Samoa, Western</option><option value="SM">San Marino</option><option value="ST">Sao Tome and Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syrian Arab Republic</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania, United Republic Of</option><option value="TH">Thailand</option><option value="TG">Togo</option><option value="TO">Tonga</option><option value="TT">Trinidad And Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="VG">Virgin Islands (british)</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option>
												                                </select>
											                               	</div>
												                		</div>
												                	</div>
												                	<div class="field-container">
												                		<div class="upper-row">
												                			<label><span class="icon-address"></span> Street</label>
												                		</div>
												                		<div class="field-row">
												                			<div class="left-column">
																				<input type="text" id="inputStreet" name="inputStreet" tabindex="5" placeholder="Street" value="<?php if(isset($getUserInfo)){echo $getUserInfo[0]->street;} ?>">	
												                			</div>
												                		</div>
												                	</div>
												                	<div class="field-container">
												                		<div class="upper-row">
												                			<label><span class="icon-location"></span> Location</label>
												                		</div>
												                		<div class="field-row">
												                			<div class="small-column">
												                				<input type="text" id="inputCity" name="inputCity" placeholder="City" tabindex="6" value="<?php if(isset($getUserInfo)){echo $getUserInfo[0]->city;} ?>">
												                			</div>
												                			<div class="small-column">
												                				<input type="text" id="inputZipCode" name="inputZipCode" placeholder="Zip Code" tabindex="7" value="<?php if(isset($getUserInfo)){echo $getUserInfo[0]->zip;} ?>">
												                			</div>
												                			<div class="small-column">
												                				<select name="state" class="js-chosen" id="inputState" name="inputState" tabindex="8" >
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='AL'){ echo "selected='selected'";}} ?> value="AL">Alabama</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='AK'){ echo "selected='selected'";}} ?> value="AK">Alaska</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='AZ'){ echo "selected='selected'";}} ?> value="AZ">Arizona</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='AR'){ echo "selected='selected'";}} ?>value="AR">Arkansas</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='CA'){ echo "selected='selected'";}} ?>value="CA">California</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='CO'){ echo "selected='selected'";}} ?>value="CO">Colorado</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='CT'){ echo "selected='selected'";}} ?>value="CT">Connecticut</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='DE'){ echo "selected='selected'";}} ?>value="DE">Delaware</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='DC'){ echo "selected='selected'";}} ?>value="DC">District Of Columbia</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='FL'){ echo "selected='selected'";}} ?>value="FL">Florida</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='GA'){ echo "selected='selected'";}} ?>value="GA">Georgia</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='HI'){ echo "selected='selected'";}} ?>value="HI">Hawaii</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='ID'){ echo "selected='selected'";}} ?>value="ID">Idaho</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='IL'){ echo "selected='selected'";}} ?>value="IL">Illinois</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='IN'){ echo "selected='selected'";}} ?>value="IN">Indiana</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='IA'){ echo "selected='selected'";}} ?>value="IA">Iowa</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='KS'){ echo "selected='selected'";}} ?>value="KS">Kansas</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='KY'){ echo "selected='selected'";}} ?>value="KY">Kentucky</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='LA'){ echo "selected='selected'";}} ?>value="LA">Louisiana</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='ME'){ echo "selected='selected'";}} ?>value="ME">Maine</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='MD'){ echo "selected='selected'";}} ?>value="MD">Maryland</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='MA'){ echo "selected='selected'";}} ?>value="MA">Massachusetts</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='MI'){ echo "selected='selected'";}} ?>value="MI">Michigan</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='MN'){ echo "selected='selected'";}} ?>value="MN">Minnesota</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='MS'){ echo "selected='selected'";}} ?>value="MS">Mississippi</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='MO'){ echo "selected='selected'";}} ?>value="MO">Missouri</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='MT'){ echo "selected='selected'";}} ?> value="MT">Montana</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='NE'){ echo "selected='selected'";}} ?>value="NE">Nebraska</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='NV'){ echo "selected='selected'";}} ?>value="NV">Nevada</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='NH'){ echo "selected='selected'";}} ?>value="NH">New Hampshire</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='NJ'){ echo "selected='selected'";}} ?>value="NJ">New Jersey</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='NM'){ echo "selected='selected'";}} ?>value="NM">New Mexico</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='NY'){ echo "selected='selected'";}} ?>value="NY">New York</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='NC'){ echo "selected='selected'";}} ?>value="NC">North Carolina</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='ND'){ echo "selected='selected'";}} ?>value="ND">North Dakota</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='OH'){ echo "selected='selected'";}} ?>value="OH">Ohio</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='OK'){ echo "selected='selected'";}} ?>value="OK">Oklahoma</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='OR'){ echo "selected='selected'";}} ?>value="OR">Oregon</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='PA'){ echo "selected='selected'";}} ?>value="PA">Pennsylvania</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='RI'){ echo "selected='selected'";}} ?>value="RI">Rhode Island</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='SC'){ echo "selected='selected'";}} ?>value="SC">South Carolina</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='SD'){ echo "selected='selected'";}} ?>value="SD">South Dakota</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='TN'){ echo "selected='selected'";}} ?>value="TN">Tennessee</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='TX'){ echo "selected='selected'";}} ?>value="TX">Texas</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='UT'){ echo "selected='selected'";}} ?>value="UT">Utah</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='VT'){ echo "selected='selected'";}} ?>value="VT">Vermont</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='VA'){ echo "selected='selected'";}} ?>value="VA">Virginia</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='WA'){ echo "selected='selected'";}} ?>value="WA">Washington</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='WV'){ echo "selected='selected'";}} ?>value="WV">West Virginia</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='WI'){ echo "selected='selected'";}} ?>value="WI">Wisconsin</option>
												                                    <option <?php if(isset($getUserInfo)){if($getUserInfo[0]->state =='WY'){ echo "selected='selected'";}} ?>value="WY">Wyoming</option>
												                                </select>
												                			</div>
												                		</div>
												                	</div>
												                
												                	
												                	<div class="field-container">
												                		<div class="field-row">
												                			<button type="submit" tabindex="9" class="btn btn-default save-button">Save</button>
												                		</div>
												                	</div>
												                </fieldset>
												            <?php echo form_close();?>
														</div>
									      			</div>
									      			<div id="password-change-tab">
									      				<div class="form-container">
												          	<?php $attributes = array('name' => 'password_change', 'id' => 'password_change','class'=>'form-container'); echo form_open('', $attributes);?>
												               	<input type="hidden" value="" name="id" id="serial">
											                	<fieldset>
												                	<div class="field-container">
												                		<div class="upper-row">
												                			<label><span class="icon-lock-1"></span> Current Password *</label>
												                		</div>
												                		<div class="field-row">
												                			<div class="left-column">
													                			<input type="password" id="inputCurrentPassword" name="inputCurrentPassword" placeholder="Current Password"  tabindex="1" value="">
													                		</div>
												                		</div>
												                	</div>
												                	<div class="field-container">
												                		<div class="upper-row">
												                			<label><span class="icon-lock-1"></span> New Password *</label>
												                		</div>
												                		<div class="field-row">
												                			<div class="left-column">
													                			<input type="password" id="inputNewPassword" name="inputNewPassword" placeholder="New Password"  tabindex="2" value="">
				                			                                 	<span style='display:block;padding:1px 10px;' id="passwordError">Enter 8-20 character. Must contain(digit,uppercase & lowercase character and special character)</span>
													                		</div>
												                		</div>
												                	</div>
												                	<div class="field-container">
												                		<div class="upper-row">
												                			<label><span class="icon-lock-1"></span> Retype New Password *</label>
												                		</div>
												                		<div class="field-row">
												                			<div class="left-column">
													                			<input type="password" id="inputRetypeNewPassword" name="inputRetypeNewPassword" placeholder="Retype New Password"  tabindex="3" value="">
													                		</div>
												                		</div>
												                	</div>											                
												                	<div class="field-container">
												                		<div class="field-row">
												                			<button type="submit" tabindex="9" class="btn btn-default save-button">Save</button>
												                			<button type="button" tabindex="10" class="btn btn-default">Cancel</button>
												                		</div>
												                	</div>
												                </fieldset>
												            <?php echo form_close();?>
														</div>
									      			</div>
									      			<?php if(count($roles_right) > 0){ ?>
									      			<div id="user-managment-tab">
									      				<div class="action-element">
								  							<a href="<?php echo $path_url; ?>newuser" id="add-action">Add New</a>
								  						</div>
									      				<table class="table-body" id="table-body-phase-tow" >
									                        <thead>
										                        <tr>
										                            <th>First Name</th>
										                            <th>Last Name</th>
								                                    <th>Email</th>
								                                    <th>Role</th>
								                                    <th>Status</th>
								                                    <th>Options</th>
										                        </tr>
										                    </thead>
										                    <tfoot>
										                        <tr>
										                            <th>First Name</th>
										                            <th>Last Name</th>
								                                    <th>Email</th>
								                                    <th>Role</th>
								                                    <th>Status</th>
								                                    <th>Options</th>
										                        </tr>
										                    </tfoot>
									                        <tbody id="reporttablebody-phase-two" class="report-body">
									                       
									                        	<?php $i = 1 ; if(isset($users)){ ?>
									                                <?php foreach ($users as $key => $value) {?>
									                                <tr <?php if($i%2 == 0){echo "class='green-bar row-update'";} else{echo "class='yellow-bar row-update'";} ?> id="tr_<?php echo $value->row_slug ;?>" data-view="<?php echo $this->encrypt->encode($value->row_slug) ;?>">
									                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo ucwords($value->first_name); ?></td>
									                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo ucwords($value->last_name); ?></td>
									                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->email; ?></td>
									                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->roletype; ?></td>
									                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo ($value->account == 'a' ? "Active" : "Lock"); ?></td>
									                                    <td>
									                                        <a href="<?php echo $path_url; ?>newuser/<?php echo $value->row_slug ;?>" id="<?php echo $this->encrypt->encode($value->row_slug) ;?>" class='edit' title="Edit">
									                                            <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
									                                        </a>
									                                        <a href="#" title="Delete" id="<?php echo $this->encrypt->encode($value->row_slug) ;?>" class="del">
									                                            <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
									                                        </a>
									                                    </td>
									                                </tr>
									                                <?php $i++;} ?>
									                                <?php } else{ echo "<p id='novaluefound'>No user found.</p>";} ?>
											                </tbody>
									                    </table>
									      			</div>
									      			<?php } ?>
								  				</div>
											</div>  
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>
<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	var dvalue ;
	$(document).ready(function(){
		$(".table-choice").show();
		/*
	     * ---------------------------------------------------------
	     *   Country input settings
	     * ---------------------------------------------------------
	     */   
        $(document).on('change','#inputCountry',function(){
            if($("#inputCountry").val() == 'US'){
                $("#inputState").removeAttr('disabled');
                $("#inputState").css('background','none');
            }
            else{
                $("#inputState").attr('disabled','disabled');
                $("#inputState").css('background','beige');
            }
        });      
		loaddatatable();
	  	/**
     	 * ---------------------------------------------------------
	     *   load table
	     * ---------------------------------------------------------
	     */
	    function loaddatatable()
	    {
	        $('#table-body-phase-tow').DataTable( {
	            responsive: true,
	             "order": [[ 0, "asc"  ]],
	            initComplete: function () {
	                this.api().columns().every( function () {
	                    var column = this;
	                    var select = $('<select><option value=""></option></select>')
	                        .appendTo( $(column.footer()).empty() )
	                        .on( 'change', function () {
	                            var val = $.fn.dataTable.util.escapeRegex(
	                                $(this).val()
	                            );
	     
	                            column
	                                .search( val ? '^'+val+'$' : '', true, false )
	                                .draw();
	                        });
	                    column.data().unique().sort().each( function ( d, j ) {
	                        select.append( '<option value="'+d+'">'+d+'</option>' )
	                    });
	                });
	            }
	        });
	    }
	});
</script>
<script src="<?php echo $path_url; ?>js/jquery.easyResponsiveTabs.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#settings').easyResponsiveTabs({ tabidentify: 'vert' });
		/*
	     * ---------------------------------------------------------
	     *   Save general Settings
	     * ---------------------------------------------------------
	     */    
        $("#generalForm").submit(function(){
            
            var inputFirstName = $("#inputFirstName").val();
            var inputLastName = $("#inputLastName").val();
            var inputEmail = $("#inputEmail").val();
            var inputCountry = $("#inputCountry").val();
            var inputStreet = $("#inputStreet").val();
            var inputCity = $("#inputCity").val();
            var inputZipCode = $("#inputZipCode").val();
            var inputState = $("#inputState").val();
            var inputPhone = $("#inputPhone").val();
            var reg = new RegExp(/^[A-Za-z0-9 ]{3,50}$/);
          
         	if(reg.test(inputFirstName) == false){
                jQuery("#inputFirstName").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputFirstName").css("border", "1px solid #C9C9C9");                                 
            }
            if(reg.test(inputLastName) == false){
                jQuery("#inputLastName").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputLastName").css("border", "1px solid #C9C9C9");                                 
            }
            var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            if(reg.test(inputEmail) == false){
                jQuery("#inputEmail").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputEmail").css("border", "1px solid #C9C9C9");                                 
            }

            if (inputPhone){
                var reg = new RegExp(/^((\(\d{3,4}\)|\d{3,4}-)\d{4,9}(-\d{1,5}|\d{0}))|(\d{4,12})$/);
                if(reg.test(inputPhone) == false){
                    jQuery("#inputPhone").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputPhone").css("border", "1px solid #C9C9C9");                                 
                }
            }
             var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            if (inputStreet){
                if(inputStreet.length == '' || inputStreet.length < 3){
                    jQuery("#inputStreet").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputStreet").css("border", "1px solid #C9C9C9");                                 
                }
            }
            if (inputCity){
                var reg = new RegExp(/^[A-Za-z ]{3,50}$/);
                if(reg.test(inputCity) == false){
                    jQuery("#inputCity").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputCity").css("border", "1px solid #C9C9C9");                                 
                }
            }
            if (inputZipCode){
                var reg = new RegExp(/^\d{5}((-|\s)?\d{4})?$/);
                if(reg.test(inputZipCode) == false){
                    jQuery("#inputZipCode").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputZipCode").css("border", "1px solid #C9C9C9");                                 
                }
            }
            
            $("#page-loader").css('display','block');
            var userData = jQuery('#generalForm').serializeArray();
            ajaxType = "POST";
            urlpath = "savegeneralsetting";
     
            ajaxfunc(urlpath,userData,userDerailErrorhandler,userDetailResponse);
            return false;
        });
		function userDerailErrorhandler()
		{
			if(response.message == false){
				$(".user-message").show();
	    		$(".message-text").text("Personal details has been not saved").fadeOut(10000);
	    	}

		}
		function userDetailResponse(response)
		{
			if(response.message == true){
				$(".user-message").show();
	    		$(".message-text").text("Personal details has been saved").fadeOut(10000);
	    	}
		}


	    /*
	     * ---------------------------------------------------------
	     *   Save account setting
	     * ---------------------------------------------------------
	     */ 
        $("#password_change").submit(function(e){
            e.preventDefault();

            var inputCurrentPassword = $("#inputCurrentPassword").val();
            var inputNewPassword = $("#inputNewPassword").val();
            var inputRetypeNewPassword = $("#inputRetypeNewPassword").val();

            var reg = new RegExp(/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{6,20})$/);
            
            if(reg.test(inputCurrentPassword) == false){
                jQuery("#inputCurrentPassword").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputCurrentPassword").css("border", "1px solid #C9C9C9");                                 
            }

            if(reg.test(inputNewPassword) == false){
                jQuery("#inputNewPassword").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputNewPassword").css("border", "1px solid #C9C9C9");                                 
            }

            if(reg.test(inputRetypeNewPassword) == false){
                jQuery("#inputRetypeNewPassword").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputRetypeNewPassword").css("border", "1px solid #C9C9C9");                                 
            }
            
            if(inputRetypeNewPassword != inputNewPassword ){
                jQuery("#inputRetypeNewPassword").css("border", "1px solid red");
                jQuery("#inputNewPassword").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputRetypeNewPassword").css("border", "1px solid #C9C9C9");                           
                jQuery("#inputNewPassword").css("border", "1px solid #C9C9C9"); 
            }
            $("#page-loader").css('display','block');
            var userData = jQuery('#password_change').serializeArray();
            ajaxType = "POST";
            urlpath = "users/changePassword";
            ajaxfunc(urlpath,userData,passwordFaliureReponse,savedPasswordResponse);
            return false;
        });
        
        function passwordFaliureReponse()
        {
          	$(".user-message").show();
    		$(".message-text").text("Password has been not saved. Try again").fadeOut(10000);
        }

        function savedPasswordResponse(response)
        {
            if(response.message == true){
                $("#inputCurrentPassword").val('');
                $("#inputNewPassword").val('');
                $("#inputRetypeNewPassword").val('');
            	$(".user-message").show();
	    		$(".message-text").text("Password changed. For now use new password").fadeOut(10000);
	    
            }
            if(response.message == 'pass_not_match'){
            	$(".user-message").show();
	    		$(".message-text").text("Current password is incorrect. Please provide correct current password").fadeOut(10000);

            }
            if(response.message == false){
                $("#inputCurrentPassword").val('');
                $("#inputNewPassword").val('');
                $("#inputRetypeNewPassword").val('');
               	$(".user-message").show();
	    		$(".message-text").text("Password has been not saved. Try again").fadeOut(10000);

            }
        }

      	$(document).on('click','.row-bar-user',function(){
          
            var dataString = ({'id':dvalue,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'});
      		ajaxType = "GET";
            urlpath = "<?php echo $path_url; ?>users/singleUser";
            ajaxfunc(urlpath,dataString,loadUserReponseError,loadUserResponse);
        });

      	function loadUserReponseError(){}

        function loadUserResponse(response)
        {
        	if (data.message === true){
                $("#serial").val(dvalue);
                $("#inputUserName").val(data.name);
                var status = (data.status == 'a' ? 'a' : 'l');
                if(status == 'a'){
                    $("#optionsRadios1").prop('checked',true);
                }
                else{  
                    $("#optionsRadios2").prop('checked',true); 
                }
                $("#udestinationFields").html("");
                var cont_str = '';
                var counter = 1;
                if(data.userRoleId != null){  
                     $.each(data.userRoleId,function(i,key){  
                        cont_str +='<div value="'+data.userRoleId[counter]+'" class = "fc-field ui-sortable-handle " tabindex="1">'+data.role[counter]+'</div>';
                        counter++;
                     });    
                    $("#udestinationFields").append(cont_str);
                }
                $("#usourceFields").html("");
                cont_str = '';
                var counter = 1;
                if(data.unFoundRoleId != null){
                    $.each(data.unFoundRoleId,function(i,key){
                        cont_str +='<div value="'+data.unFoundRoleId[counter]+'" class="fc-field ui-sortable-handle" tabindex="1">'+data.unFoundName[counter]+'</div>';
                        counter++;
                    });
                }

            } 
        }
   
        $(document).on('click','.row-bar-user',function(){
        	dvalue =  $(this).attr('data-view');
       	 	var dataString = "id="+dvalue;
        	$("#myModal").modal('show');
      		ajaxType = "GET";
            urlpath = "<?php echo $path_url; ?>users/singleUser";
            var dataString = ({'id':dvalue,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'});
            ajaxfunc(urlpath,dataString,loadSingleUserReponseError,loadSingleUserResponse);
        });

        function loadSingleUserReponseError(){}

        function loadSingleUserResponse(response)
        {
	 		$("#user_name").text(response.name);
            $("#user_email").text(response.email);
            $("#user_acct_date").text(response.created);
            var status = (data.status == 'a' ? 'a' : 'l');
            if(status == 'a'){
                $("#user_acct_status").text('Active');
            }
            else{  
                $("#user_acct_status").text('In-Active'); 
            }
            var cont_str = '';
            var counter = 1 ;
            if(response.role != null){  
         		$.each(response.role,function(i,key){ 
         			if(counter != 1){
         				cont_str += response.role[counter]+'/';	
         			}
         			else{
         				cont_str += response.role[counter];
         			}
         			
                	counter++;
             	});
             	lastchar = cont_str.charAt(cont_str.length - 1);
				if(lastchar == "/"){
					cont_str = cont_str.substring(0, cont_str.length - 1);	
				} 
               
            	$("#user_role").text(cont_str);
            }

        }
         /*
         * ---------------------------------------------------------
         *   Delete User
         * ---------------------------------------------------------
         */
        $(document).on('click','.del',function(){
            $("#myUserModal").modal('show');
            dvalue =  $(this).attr('id');
         
            row_slug =   $(this).parent().parent().attr('id');
            
        });
        
        /*
         * ---------------------------------------------------------
         *   User notification on deleting user 
         * ---------------------------------------------------------
         */
        $(document).on('click','#UserDelete',function(){
            $("#myUserModal").modal('hide');
    		ajaxType = "GET";
            urlpath = "<?php echo $path_url; ?>users/removeUser";
            var dataString = ({'id':dvalue});
            ajaxfunc(urlpath,dataString,userDeleteFailureHandler,loadUserDeleteResponse);
    	});

        function userDeleteFailureHandler()
        {
        	if (data.message === true){
     		 	$(".user-message").show();
		    	$(".message-text").text("User has been not deleted").fadeOut(10000);
         	} 
        }

        function loadUserDeleteResponse(response)
        {
        	if (data.message === true){
                $("#"+row_slug).remove();
     		 	$(".user-message").show();
		    	$(".message-text").text("User has been deleted").fadeOut(10000);
         	} 
        }
        
	});
</script>

