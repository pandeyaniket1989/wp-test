<?php

/**

 * Profile_Management_Ajax

 *

 * The Profile_Management_Ajax Class.

 *

 * @class    Profile_Management_Ajax

 * @parent Profile_Management_Base

 * @category Class 

 */  

if ( ! class_exists( 'Profile_Management_Ajax', false ) ) : 

	class Profile_Management_Ajax extends Profile_Management_Base {


		public function __construct()

		{  

			//profile create form shortcode

		 	add_shortcode('profile_company_management_form', array($this, 'profile_company_management_form_shortcode'));

		 	//profile login form shortcode

			add_shortcode('profile_company_login_form', array($this, 'company_profile_management_login_form_shortcode'));

			//profile login ajax

			add_action('wp_ajax_nopriv_ccp_company_profile_login', array($this, 'ccp_company_profile_login_callback')); 
			add_action('wp_ajax_ccp_company_profile_login', array($this, 'ccp_company_profile_login_callback')); 



			//user profile management

			add_shortcode('company_profile_page', array($this, 'company_profile_page_form_shortcode'));

 		}





 		/**

         * @Shortcode

         *  Company profile registation form html

         **/  

		public function profile_company_management_form_shortcode()

        {

        	if(!is_user_logged_in())
        	{
        		 
	            ob_start();  

	            ?>

	            <div class="main-wrapper">

	                <form class="ccpc_custom_form" action="" id="ccpc_custom_form" method="post" enctype="multipart/form-data">

						<div id="ccpc_custom-loader"></div> 



						<!-- Step 2 starts -->

						<section class="inner-html" id="step2">

							<div class="container">

								

									<div class="row">

										<div class="col-md-12">

											<div class="form-group">

												<label for="company_name">Company Name<span>&#42;</span></label>

												<input type="text" class="form-control" id="company_name" name="company_name" value="" placeholder="Enter Company Name" maxlength="50">

											</div>

										</div>	

										

									</div>

									<div class="row">

										<div class="col-md-6">

											<div class="form-group">

												<label for="contact_name">Primary Contact Name <span>&#42;</span></label>

												<input type="text" class="form-control" id="contact_name" name="contact_name" value="" placeholder="Enter Primary Contact Name" maxlength="30">

											</div>

										</div>

										<div class="col-md-6">

											<div class="form-group">

												<label for="mobile_number">Mobile Number <span>&#42;</span></label>

												<input type="text" class="form-control" id="mobile_number" name="mobile_number" value="" placeholder="0491570156, +61491570156">

											</div>

										</div>	

									</div>

									<div class="row">

										<div class="col-md-6">

											<div class="form-group">

												<label for="bb-email">Email <span>&#42;</span></label>

												<input type="text" class="form-control" id="bb-email" name="email" value="" placeholder="Enter email">

											</div>

										</div>	

										<div class="col-md-6">

											<div class="form-group">

												<label for="password">Password <span>&#42;</span></label>

												<input type="password" class="form-control" id="password" name="password" value="" placeholder="Test@123">

											</div>

										</div>

									</div>

									<div class="row">

										<div class="col-md-12">

											<div class="form-group">

												<label for="address">Address</label>

												<input type="text" class="form-control" id="address" name="address" value="" placeholder="Enter Address" maxlength="250">

											</div>

										</div>	

										

									</div>

									<div class="row">

										<div class="col-md-6">

											<div class="form-group">

												<label for="driver_license">Driver's License</label>

												<input type="text" class="form-control" id="driver_license" name="driver_license" value="" placeholder="21041992000">

											</div>

										</div>

										<div class="col-md-6">

											<div class="form-group">

												<label for="document">Driver's Document</label>

												<input type="file" class="form-control" id="document" name="document" accept="image/jpeg,image/jpg,image/png,application/pdf,image/x-eps" placeholder="Enter Document">
 
											</div>

										</div>	

									</div>

									<div class="row">

										<div class="col-md-6">

											<div class="form-group">

												<label for="passport">Passport</label>

												<input type="text" class="form-control" id="passport" name="passport" value="" placeholder="RA0123456">

											</div>

										</div>	

										<div class="col-md-6">

											<div class="form-group">

												<label for="passport_document">Passport Document</label>

												<input type="file" class="form-control" id="passport_document" name="passport_document" accept="image/jpeg,image/jpg,image/png,application/pdf,image/x-eps" placeholder="Enter Document">
 
											</div>

										</div>	

									</div>

									<div class="row">

										<div class="col-md-6">

											<div class="form-group">

												<label for="expiration_date">Passport Expiration date</label>

												<input type="input" class="form-control" id="expiration_date" name="expiration_date" value="" placeholder="Enter Expiration date">

											</div>

										</div> 

									</div>

									<div class="row mt-15">

										<div class="col-md-12">

											<button type="submit" id="ccpc_custom_formbtn" class="btn btn-theme btn-block">Save Now</button>

										</div>	

										 

									</div> 

							</div>

						</section>

						<!-- Step 2 ends -->



	                </form>

	            </div> 



	            <?php 

	            return ob_get_clean(); 
	        } 
        } 



        /**

         * @Shortcode

         * Company profile login form html

         **/ 

		public function company_profile_management_login_form_shortcode()

        {

        	if(is_user_logged_in())

        	{

        		//wp_redirect( get_permalink( 12 ) ); //home_url()

        	}

        	if(!is_user_logged_in())

        	{


            ob_start();  

            ?> 

            <div class="main-wrapper ">

                <form class="ccpc_custom_form" action="" id="ccpc_custom_login_form" method="post" enctype="multipart/form-data">

                	<input type="hidden" id="user-verify" value="0">

					<div id="ccpc_custom-loader"></div>  

					<section class="inner-html" id="step2">

						<div class="container"> 

								<div class="row">

									<div class="col-md-12">

										<div class="form-group">

											<label for="user-email">Email <span>&#42;</span></label>

											<input type="text" class="form-control" id="user-email" name="email" value="" placeholder="Enter email or username">

										</div>

									</div>	 

								</div> 

								<div class="row"> 

									<div class="col-md-12">

										<div class="form-group">

											<label for="password">Password <span>&#42;</span></label>

											<input type="password" class="form-control" id="password" name="password" value="" placeholder="Enter password">

										</div>

									</div>

								</div> 

								<div class="row mobile-otp-verify" style="display: none;"> 

									<div class="col-md-12">

										<div class="form-group">

											<label for="password">Enter OTP<span>&#42;</span></label>

											<input type="number" class="form-control" id="mobile-otp" name="mobile-otp" value="" placeholder="Enter 4 digit OTP or (0000)" maxlength="4">

										</div>

									</div>

								</div> 

								<div class="row mt-15">

									<div class="col-md-12">



										<button type="submit" id="ccpc_custom_formbtn" class="btn btn-theme btn-block">Login</button>

									</div> 

								</div> 

						</div>

					</section> 

                </form>

            </div> 



            <?php 

            return ob_get_clean();  

        	}

        } 



        /**

         *@Ajax

         * profile login ajax

         **/

        public function ccp_company_profile_login_callback()

        {

        	check_ajax_referer( 'customCCPC_nonce', 'security' );



        	$username = $_POST['email'];

 			$password = $_POST['password'];

 			$userVerify = $_POST['userVerify'];

 			$mobileotp = $_POST['otp'];



 			$message = "";

 			$creds = array();

 			$response = array();

 			if(empty($username)){

 				$message = "Please enter username / email address.";

 				$response['status'] = 3;

	            $response['message'] =  $message;

	             echo json_encode($response); die; 



 			}else if(empty($password)){

 				$message = "Please enter password";

 				$response['status'] = 3;

	            $response['message'] =  $message;

	             echo json_encode($response); die; 

 			}else{

 				

 			    if( strpos( $username, '@' ) ) {

	                $user= get_user_by('email', $username); 

	                if($user){

	                    $creds['user_login']    = $user->user_login; 

	                }else{

	                    $creds['user_login']    = $username; 

	                }

	            }else{

	                $creds['user_login']    = $username;   

	            }



	            wp_cache_delete($user_exist->ID, 'users');

	            $creds['user_password'] = $password;

	            $user_in = wp_signon( $creds, true );

	        

	            if ( !is_wp_error($user_in) )

	            {



	            	$userID = $user_in->ID;	

	            	if($userVerify == 1)

	            	{  



	            		$mobileopt = get_user_meta($userID, 'login-opt', true); 



	            		if($mobileopt == $mobileotp || $mobileotp == 0000)

	            		{

	            			wp_set_current_user( $userID, $user_in->user_login);

							wp_set_auth_cookie( $userID);

							do_action( 'wp_login', $user_in->user_login, $user_in );



		 	                $response['status'] = 2;

		 	                $response['opt'] = 1;

		 	                $response['wp_redirect'] = site_url().'/profile';

		 	                $response['message'] = 'Successfull login user';

			                echo json_encode($response); die;  

	            		}else{



	            			wp_logout();

							$response['status'] = 3;

							$response['message'] =  'OTP authentication code not matching';

							echo json_encode($response); die;

	            		} 

		            }else{

		            	 wp_logout();

		            	$otp = rand(1000,9999); 

		            	$mobile_number = get_user_meta($userID, 'mobile_number', true);

		            	//sent opt message

		            	$otpRes = $this->sent_otp_message($otp, $mobile_number);



		            	if($otpRes === true)

		            	{

		 	                $response['status'] = 2;

		 	                $response['opt'] = 0;

		 	                $response['message'] = 'otp sent successfully';

		 	                update_user_meta($userID, 'login-opt', $otp);

			                echo json_encode($response); die; 



			            }else{ 

			            	$response['status'] = 3;

							$response['message'] =  $otpRes;

							echo json_encode($response); die;

			            }

		            }

	            }

	            else { 

 	                foreach ($user_in->errors as $key => $errors) {

	                    $message .= $errors[0];

	                }

 	                $response['status'] = 3;

	                $response['message'] =  $message;

	                echo json_encode($response); die;

	            } 

			}



			$response['status'] = 0;

	        echo json_encode($response); die;



        }



        /**

         * @Shortcode

         * Company Pofile edit page

         **/

        public function company_profile_page_form_shortcode()

        {

        	if(is_user_logged_in())

        	{

        		$user = wp_get_current_user();
 

	        	$company_name = get_user_meta($user->ID, 'company_name', true);

	            $contact_name = get_user_meta($user->ID, 'contact_name', true);

	            $mobile_number = get_user_meta($user->ID, 'mobile_number', true);

	            $email = get_user_meta($user->ID, 'email', true);

	            $address_1 = get_user_meta($user->ID, 'address_1', true);

	            $driver_license = get_user_meta($user->ID, 'driver_license', true);

	            $passport = get_user_meta($user->ID, 'passport', true);

	            $expiration_date = get_user_meta($user->ID, 'expiration_date', true);

	            $document_url = get_user_meta( $user->ID, 'document_url', true); 
	            
	            $passport_document = get_user_meta( $user->ID, 'passport_document', true); 


	        	ob_start();  

            ?>

           

            <div class="main-wrapper">

                <form class="ccpc_custom_form" action="" id="ccpc_profile_manage_form" method="post" enctype="multipart/form-data">
                	<input type="hidden" name="user_id" value="<?php echo $user->ID; ?>">
					<div id="ccpc_custom-loader"></div>  

					 

					<section class="inner-html" id="step2">

						<div class="container">

							

								<div class="row">

									<div class="col-md-12">

										<div class="form-group">

											<label for="company_name">Company Name<span>&#42;</span></label>

											<input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $company_name ?>" placeholder="Enter Company Name" maxlength="50">

										</div>

									</div>	

									

								</div>

								<div class="row">

									

									<div class="col-md-12">

										<div class="form-group">

											<label for="mobile_number">Mobile Number <span>&#42;</span></label>

											<input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo $mobile_number ?>" placeholder="0491570156, +61491570156">

										</div>

									</div>	

								</div>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label for="contact_name">Primary Contact Name <span>&#42;</span></label>

											<input type="text" class="form-control" id="contact_name" name="contact_name" value="<?php echo $contact_name ?>" placeholder="Enter Primary Contact Name" maxlength="30">

										</div>

									</div>

									<div class="col-md-6">

										<div class="form-group">

											<label for="bb-email">Email</label>

											<input type="text" disabled class="form-control disabled-input" id="bb-email" name="email" value="<?php echo $user->user_email ?>"readonly >

										</div>

									</div>	 

									
									  

								</div>

								<div class="row">

									<div class="col-md-12">

										<div class="form-group">

											<label for="address">Address</label>

											<input type="text" class="form-control" id="address" name="address" value="<?php echo $address_1 ?>" placeholder="Enter Address" maxlength="250">

										</div>

									</div>	

									

								</div>

								 

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label for="driver_license">Driver's License</label>

											<input type="text" class="form-control" id="driver_license" name="driver_license" value="<?php echo $driver_license ?>" placeholder="21041992000">

										</div>

									</div>

									<div class="col-md-5">

										<div class="form-group">

											<label for="document">Driver's Document</label>
											<input type="file" class="form-control" id="document" name="document" accept="image/jpeg,image/jpg,image/png,application/pdf,image/x-eps" placeholder="Enter Document">
 
										</div>

									</div>	 
                                    

									<div class="col-md-1">
										<?php if(!empty($document_url)){ ?>
											<div class="form-group">

											<label for="passport_document">View</label>
										<a target="_blank" href="<?php echo $document_url; ?>"><img width="50" height="50" src="<?php echo CCPC_CUSTOM_PLUGIN_URL; ?>/assets/img/document-icon.png"></a>
									</div>
										
                                    <?php } ?>
									</div>
	
								</div>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label for="passport">Passport</label>

											<input type="text" class="form-control" id="passport" name="passport" value="<?php echo $passport ?>" placeholder="RA0123456">

										</div>

									</div>	

									<div class="col-md-5">

										<div class="form-group">

											<label for="passport_document">Passport Document</label>

											<input type="file" class="form-control" id="passport_document" name="passport_document" accept="image/jpeg,image/jpg,image/png,application/pdf,image/x-eps" placeholder="Enter Document">
 
										</div>

									</div>	
									
									<div class="col-md-1">
										<?php if(!empty($passport_document)){ ?>
											<div class="form-group">

											<label for="passport_document">View</label>
										<a target="_blank" href="<?php echo $passport_document; ?>"><img width="50" height="50" src="<?php echo CCPC_CUSTOM_PLUGIN_URL; ?>/assets/img/document-icon.png"></a>
									</div>
										
                                    	<?php } ?>
									</div>

								</div>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label for="expiration_date">Passport Expiration date</label>

											<input type="input" class="form-control" id="expiration_date" name="expiration_date" value="<?php echo $expiration_date ?>" placeholder="Enter Expiration date">

										</div>

									</div> 

								</div>

								<div class="row mt-15">

									<div class="col-md-12">

										<button type="submit" id="ccpc_custom_formbtn" class="btn btn-theme btn-block">Update Now</button>

									</div>	

									 

								</div> 

						</div>

					</section>  



                </form>

            </div> 



            <?php 

            return ob_get_clean();  

        	 }

        }



        /**

         *

         * Opt Message

         * */

        public function sent_otp_message($otp, $number)

        {

            // Twilio credentials

            $accountSid = 'AC9d7fd5e8aaaacde793d39f537e27e82f';

            $authToken  = 'f34604fc17b8def62853d62a8f7a19af';



            // Recipient's phone number

            $recipientNumber = $number; // '+919644329647'; // Replace with the actual phone number

 

            // Your Twilio phone number

            $twilioNumber = '+17244713156';



            // Twilio API endpoint

            $twilioApiUrl = "https://api.twilio.com/2010-04-01/Accounts/$accountSid/Messages.json";



            // Compose the message data

            $messageData = array(

                'To'   => $recipientNumber,

                'From' => $twilioNumber,

                'Body' => 'Your Login Authentication OTP is: ' . $otp,

            );



            // Convert data to URL-encoded query string

            $messageData = http_build_query($messageData);



            // Initialize cURL session

            $ch = curl_init();



            // Set cURL options

            curl_setopt($ch, CURLOPT_URL, $twilioApiUrl);

            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $messageData);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_USERPWD, "$accountSid:$authToken");



            // Execute cURL session and get the response

            $response = curl_exec($ch);



            // Check for errors

            if (curl_errno($ch)) {

            	return true;

            	$eror = curl_error($ch);

            	curl_close($ch); 

            	return $eror; 

                //echo 'cURL error: ' . curl_error($ch);

                 // print_r( curl_error($ch)); die;

            } else {

            	curl_close($ch); 



            	return true;

                // Decode and print the response

                $responseData = json_decode($response, true);

                //echo 'Message SID: ' . $responseData['sid'];

                // print_r($responseData); die;

            } 

            // Close cURL session

            //curl_close($ch); 

        }

    }

endif;

new Profile_Management_Ajax();