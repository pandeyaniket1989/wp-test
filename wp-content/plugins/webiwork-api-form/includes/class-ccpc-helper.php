<?php

/**

 * Profile_Management_Helper

 *

 * The Profile_Management_Helper Class.

 *

 * @class Profile_Management_Helper 

 * @category Class 

 */  

if ( ! class_exists( 'Profile_Management_Helper', false ) ) : 

	class Profile_Management_Helper {



		public function __construct()

		{  

            //Enqueue Script

			add_action( 'wp_enqueue_scripts', array($this,  'pm_custom_company_script_style'));



            //Register company API route

            add_action('rest_api_init', array($this, 'pm_company_api_route'));



            //auto logout hook

            add_action('init',array($this,'wp_autologout_hook'));



        }



        public function wp_autologout_hook()

        {

            if(!isset($_GET['auto-logout']) || ($_GET['auto-logout'] != '1'))

                return; 
 
            if(is_user_logged_in()) {

                wp_logout();

                wp_redirect( site_url() ); exit;

            } 

        } 


        //check header authentication key

        public function validate_auth_key($auth_key)

        {

            if($auth_key == 'A54dsNLNLfd4ADLBDJBasiasab42adA2ADCSdad')

            {

                return true;

            }else{

                return false;

            }

        } 



        //Register company API route and include authentication

        public function pm_company_api_route() 

        {
            register_rest_route(

                'v1',  

                '/profile/',  

                array(

                    'methods'   => 'POST',

                    'callback'  => array($this, 'custom_company_api_callback'),

                    'permission_callback' => function ($request) {

                        $auth_key = $request->get_header('X-Auth-Key');

                        if (!$auth_key || !$this->validate_auth_key($auth_key)) {

                            return new WP_Error('rest_forbidden', 'Invalid authentication key.', array('status' => 403));

                        }

                        return true;

                    },

                    'args'=> array( 

                        'company_name' => array(

                            'required'          => true, 

                            'type'     => 'string',

                        ),

                        'contact_name' => array(

                            'required'          => true,

                            'type'     => 'string',  

                        ),

                        'mobile_number' => array(

                            'required'  => true,   

                        ),

                        'email' => array(

                            'required'  => true,

                            'type'     => 'string',   

                        ),

                        'password' => array(

                            'required' => true, 

                            'type'     => 'string',  

                        ),

                        'address' => array(

                            'required' => true, 

                            'type'     => 'string',  

                        ),

                    ),

                )

            ); 



            register_rest_route(

                'v1/profile',  

                '/update/', 

                array(

                    'methods'   => 'POST',

                    'callback'  => array($this, 'company_profile_update_api_callback'),

                    'permission_callback' => function ($request) {

                        $auth_key = $request->get_header('X-Auth-Key');

                        if (!$auth_key || !$this->validate_auth_key($auth_key)) {

                            return new WP_Error('rest_forbidden', 'Invalid authentication key.', array('status' => 403));

                        }

                        return true;

                    },

                    'args'=> array( 

                        'user_id' => array(

                            'required'  => true, 

                            'type'     => 'number',

                        ),

                        'company_name' => array(

                            'required'          => true, 

                            'type'     => 'string',

                        ),

                        'contact_name' => array(

                            'required'          => true,

                            'type'     => 'string',  

                        ),

                        'mobile_number' => array(

                            'required'  => true,   

                        ), 

                        'address' => array(

                            'required' => true, 

                            'type'     => 'string',  

                        ),

                    ),

                )

            ); 

        }



        //create api callback 

        public function custom_company_api_callback($request) 

        {

            // Your custom logic goes here

            $company_name = $request->get_param('company_name');

            $contact_name = $request->get_param('contact_name');

            $mobile_number = $request->get_param('mobile_number');

            $email = $request->get_param('email');

            $password = $request->get_param('password');

            $address = $request->get_param('address'); 


            $driver_license = $request->get_param('driver_license');

            $passport = $request->get_param('passport');

            $expiration_date = $request->get_param('expiration_date');
 

            //check validation



            //Password 6 to 8 regex pattern

            $pattern = '/^.{6,15}$/'; 
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{8,15}$/'; 

            // Australian phone number regex pattern

            $regex = '/^(?:\+61|0)[2-478](?:[ -]?[0-9]){8}$/';

            $passportVali = '/^(?!^0+$)[a-zA-Z0-9]{3,20}$/'; 
            $passportVali = '/^[A-Za-z]{1,2}[0-9]{7}$/'; 

            $drivRegex = '/^[A-Za-z0-9]{8,11}$/';

 

            $mobile_number = sanitize_text_field($mobile_number); 

            $password = sanitize_text_field($password); 

            $email = sanitize_email($email); 

            $expiration_date = isset($expiration_date) ? sanitize_text_field($expiration_date) : '';

            

            if(!preg_match($regex, $mobile_number))

            { 

                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Please enter a valid Australian phone number' ) ),

                    array(

                        'status' => 400,

                        'params' => 'document',

                    )

                );

            }

            if (!is_email($email)) {



                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Please enter a valid email' ) ),

                    array(

                        'status' => 400,

                        'params' => 'email',

                    )

                );

            }



            if(!empty($passport) && !preg_match($passportVali, $passport))

            { 

                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Passport number is invalid' ) ),

                    array(

                        'status' => 400,

                        'params' => 'passport',

                    )

                );

            }



            if(!empty($driver_license) && !preg_match($drivRegex, $driver_license))

            { 

                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Invalid license number' ) ),

                    array(

                        'status' => 400,

                        'params' => 'driver_license',

                    )

                );

            }

            // Validate the date format
            if (!empty($expiration_date) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {

                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Invalid date format. Please use YYYY-MM-DD' ) ),

                    array(

                        'status' => 400,

                        'params' => 'expiration_date',

                    ) 
                );
            }

            if (!empty($expiration_date))
            {

                // Convert the date string to a DateTime object
                $event_datetime = new DateTime($expiration_date);

                // Get the current date
                $current_datetime = new DateTime();

                // Compare the event date with the current date
                if ($event_datetime < $current_datetime) {

                    return new WP_Error(

                        'rest_invalid_param', 

                        sprintf( __( 'Past dates are not allowed' ) ),

                        array(

                            'status' => 400,

                            'params' => 'expiration_date',

                        ) 
                    );
                 }
            }
 


            // Define the regular expression for password validation (6 to 8 characters)

            if (!preg_match($pattern, $password)) {

                return new WP_Error(

                    'invalid_password_length', 

                    sprintf( __( 'Password must be between 8 and 15 characters(Test@123)' ) ),

                    array(

                        'status' => 400,

                        'params' => 'password',

                    )

                );

            }

            //get files

            $file = $request->get_file_params(); 

            //check documents

            if(array_key_exists('document', $file))
            {
                if(!empty($file['document']['name']))
                {

                    $imageFileType = pathinfo($file['document']['name'],PATHINFO_EXTENSION);

                    $valid_extensions = array("jpg","jpeg","png", "pdf");

                    //This checks if the file is an document.

                    if(!in_array(strtolower($imageFileType), $valid_extensions)) {

                        return new WP_Error(

                            'invalid_file_type', 

                            sprintf( __( 'Invalid file type. You can only upload : %s' ), implode( ', ', $valid_extensions ) ),

                            array(

                                'status' => 400,

                                'params' => 'document',

                            )

                        ); 

                    }  
                }

            }

            if(array_key_exists('passport_document', $file))
            {

                if(!empty($file['passport_document']['name']))
                {
                    $imageFileType = pathinfo($file['passport_document']['name'],PATHINFO_EXTENSION);

                    $valid_extensions = array("jpg","jpeg","png", "pdf");

                    //This checks if the file is an document.

                    if(!in_array(strtolower($imageFileType), $valid_extensions)) {

                        return new WP_Error(

                            'invalid_file_type', 

                            sprintf( __( 'Invalid file type. You can only upload : %s' ), implode( ', ', $valid_extensions ) ),

                            array(

                                'status' => 400,

                                'params' => 'passport_document',

                            )

                        ); 

                    }  
                }
            } 



            // check if email exists already

            if ( email_exists( $email ) ) { 



                return new WP_Error(

                    'rest_missing_callback_param', 

                    sprintf( __( 'This email is already exist: %s' ), $email ),

                    array(

                        'status' => 409,

                        'params' => 'email',

                    )

                ); 

            }   



            $uploaddir = wp_upload_dir();  

            if(array_key_exists('document', $file))
            {
                if(!empty($file['document']['name']))
                {

                    $document = $file['document'];

                    $document_file = time().'-document-'.$document['name'];

                    $document_sourcePath = $document['tmp_name']; 

                    $filename_profile = $uploaddir['url'] . '/' . basename( $document_file );

                    $uploadfile_profile = $uploaddir['path'] . '/' . basename( $document_file );

                    $uploaded_profile = move_uploaded_file( $document_sourcePath , $uploadfile_profile );
                      

                    if (isset($uploaded_profile['error'])) {

                        return new WP_Error(

                            'upload_failed', 

                            sprintf( __( 'Upload Failed: %s' ), $uploaded_profile['error'] ),

                            array(

                                'status' => 422,

                                'params' => 'document',

                            )

                        );

                    }
                }
            }

            if(array_key_exists('passport_document', $file))
            {
                if(!empty($file['passport_document']['name']))
                {

                    $passport_document = $file['passport_document'];

                    $document_file = time().'-passport-document-'.$passport_document['name'];

                    $document_sourcePath = $passport_document['tmp_name']; 

                    $filename_passport_document = $uploaddir['url'] . '/' . basename( $document_file );

                    $uploadfile_profile = $uploaddir['path'] . '/' . basename( $document_file );

                    $uploaded_profile = move_uploaded_file( $document_sourcePath , $uploadfile_profile );
                      

                    if (isset($uploaded_profile['error'])) {

                        return new WP_Error(

                            'upload_failed', 

                            sprintf( __( 'Upload Failed: %s' ), $uploaded_profile['error'] ),

                            array(

                                'status' => 422,

                                'params' => 'document',

                            )

                        );

                    }
                }
            }


            $userReg=wp_insert_user(array(

                'user_login'     => $email,

                'user_email'     => $email,

                'user_pass'      => $password, 

                'display_name'   => $contact_name, 

            ));

 

            if( isset( $userReg ) && is_numeric( $userReg ) ){



                update_user_meta($userReg, 'company_name', $company_name);

                update_user_meta($userReg, 'contact_name', $contact_name);

                update_user_meta($userReg, 'mobile_number', $mobile_number);

                update_user_meta($userReg, 'email', $email);

                update_user_meta($userReg, 'address_1', $address);

                update_user_meta($userReg, 'driver_license', $driver_license);

                update_user_meta($userReg, 'passport', $passport);

                update_user_meta($userReg, 'expiration_date', $expiration_date);

                update_user_meta( $userReg, 'document_url', $filename_profile ); 

                update_user_meta( $userReg, 'passport_document', $filename_passport_document );  

                 $response = array('success' => true, 'message' => 'Sucessfull create user');

                return rest_ensure_response($response);



            }else{
                $massage = '';
                foreach ($userReg->errors as $key => $errors) {

                    $massage .= $errors[0];

                }

                return new WP_Error(

                    'register failed', 

                    sprintf( __( $massage ) ),

                    array(

                        'status' => 422,

                        'params' => 'register error',

                    )

                );

            } 

        }



        //create api callback 

        public function company_profile_update_api_callback($request) 

        {

            // Your custom logic goes here

            $company_name = $request->get_param('company_name');

            $contact_name = $request->get_param('contact_name');

            $mobile_number = $request->get_param('mobile_number');

            $user_id = $request->get_param('user_id'); 

            $address = $request->get_param('address');  

            $driver_license = $request->get_param('driver_license');

            $passport = $request->get_param('passport'); 

            //check validation


            //Password 6 to 8 regex pattern

            $pattern = '/^.{6,15}$/'; 
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{8,15}$/'; 

            // Australian phone number regex pattern

            $regex = '/^(?:\+61|0)[2-478](?:[ -]?[0-9]){8}$/';

            $passportVali = '/^(?!^0+$)[a-zA-Z0-9]{3,20}$/'; 

            $passportVali = '/^[A-Za-z]{1,2}[0-9]{7}$/'; 

            $drivRegex = '/^[A-Za-z0-9]{8,11}$/'; 
 

            $mobile_number = sanitize_text_field($mobile_number);

            $expiration_date = isset($expiration_date) ? sanitize_text_field($expiration_date) : '';

 

            if(!preg_match($regex, $mobile_number))

            { 

                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Please enter a valid Australian phone number' ) ),

                    array(

                        'status' => 400,

                        'params' => 'document',

                    )

                );

            }



            if(!empty($passport) && !preg_match($passportVali, $passport))

            { 

                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Passport number is invalid' ) ),

                    array(

                        'status' => 400,

                        'params' => 'passport',

                    )

                );

            }



            if(!empty($driver_license) && !preg_match($drivRegex, $driver_license))

            { 

                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Invalid license number' ) ),

                    array(

                        'status' => 400,

                        'params' => 'driver_license',

                    )

                );

            } 
 
            // Validate the date format
            if (!empty($expiration_date) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {

                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Invalid date format. Please use YYYY-MM-DD' ) ),

                    array(

                        'status' => 400,

                        'params' => 'expiration_date',

                    ) 
                );
            }

            if (!empty($expiration_date))
            {

                // Convert the date string to a DateTime object
                $event_datetime = new DateTime($expiration_date);

                // Get the current date
                $current_datetime = new DateTime();

                // Compare the event date with the current date
                if ($event_datetime < $current_datetime) {

                    return new WP_Error(

                        'rest_invalid_param', 

                        sprintf( __( 'Past dates are not allowed' ) ),

                        array(

                            'status' => 400,

                            'params' => 'expiration_date',

                        ) 
                    );
                 }
            }
            //get files

            $file = $request->get_file_params(); 



            //check documents

            if(array_key_exists('document', $file))

            {

                if(!empty($file['document']['name']))

                {

                    $imageFileType = pathinfo($file['document']['name'],PATHINFO_EXTENSION);

                    $valid_extensions = array("jpg","jpeg","png", "pdf");


                    //This checks if the file is an document.

                    if(!in_array(strtolower($imageFileType), $valid_extensions)) {

                        return new WP_Error(

                            'invalid_file_type', 

                            sprintf( __( 'Invalid file type. You can only upload : %s' ), implode( ', ', $valid_extensions ) ),

                            array(

                                'status' => 400,

                                'params' => 'document',

                            )

                        ); 

                    } 

                } 

            } 

            //check documents

            if(array_key_exists('passport_document', $file))

            {

                if(!empty($file['passport_document']['name']))

                {

                    $imageFileType = pathinfo($file['passport_document']['name'],PATHINFO_EXTENSION);

                    $valid_extensions = array("jpg","jpeg","png", "pdf");

                    //This checks if the file is an document.

                    if(!in_array(strtolower($imageFileType), $valid_extensions)) {

                        return new WP_Error(

                            'invalid_file_type', 

                            sprintf( __( 'Invalid file type. You can only upload : %s' ), implode( ', ', $valid_extensions ) ),

                            array(

                                'status' => 400,

                                'params' => 'passport_document',

                            )

                        ); 

                    } 

                } 

            } 



            $user = get_user_by('ID', $user_id);



            if(!$user)

            {

                return new WP_Error(

                    'invalid_file_type', 

                    sprintf( __( 'User not found : %s' ), $user_id ),

                    array(

                        'status' => 400,

                        'params' => 'user_id',

                    )

                ); 

            } 

    
            $uploaddir = wp_upload_dir(); 

            if(array_key_exists('document', $file))

            {

                if(!empty($file['document']['name']))

                {
                    $document = $file['document'];

                    $document_file = time().'-document-'.$document['name'];

                    $document_sourcePath = $document['tmp_name']; 

                    $filename_profile = $uploaddir['url'] . '/' . basename( $document_file );

                    $uploadfile_profile = $uploaddir['path'] . '/' . basename( $document_file );

                    $uploaded_profile = move_uploaded_file( $document_sourcePath , $uploadfile_profile );

                    if (isset($uploaded_profile['error'])) {

                        return new WP_Error(

                            'upload_failed', 

                            sprintf( __( 'Upload Failed: %s' ), $uploaded_profile['error'] ),

                            array(

                                'status' => 422,

                                'params' => 'document',

                            )

                        );

                    }

                    update_user_meta( $user_id, 'document_url', $filename_profile ); 

                }

            }

            if(array_key_exists('passport_document', $file))

            {

                if(!empty($file['passport_document']['name']))

                {

                    $passport_document = $file['passport_document'];

                    $document_file = time().'-passport-document-'.$passport_document['name'];

                    $document_sourcePath = $passport_document['tmp_name']; 

                    $filename_passport_document = $uploaddir['url'] . '/' . basename( $document_file );

                    $uploadfile_profile = $uploaddir['path'] . '/' . basename( $document_file );

                    $uploaded_profile = move_uploaded_file( $document_sourcePath , $uploadfile_profile );


                    if (isset($uploaded_profile['error'])) {

                        return new WP_Error(

                            'upload_failed', 

                            sprintf( __( 'Upload Failed: %s' ), $uploaded_profile['error'] ),

                            array(

                                'status' => 422,

                                'params' => 'passport_document',

                            )

                        );

                    }

                    update_user_meta( $user_id, 'passport_document', $filename_passport_document ); 

                }

            }



            update_user_meta($user_id, 'company_name', $company_name);

            update_user_meta($user_id, 'contact_name', $contact_name);

            update_user_meta($user_id, 'mobile_number', $mobile_number); 

            update_user_meta($user_id, 'address_1', $address);

            update_user_meta($user_id, 'driver_license', $driver_license);

            update_user_meta($user_id, 'passport', $passport);

            update_user_meta($user_id, 'expiration_date', $expiration_date);

            $response = array('success' => true, 'message' => 'Sucessfull user update');

            return rest_ensure_response($response);

 

        }



        //Enqueue Script

        public function pm_custom_company_script_style()
        {

            wp_enqueue_script('ccpc_custom_jquery', CCPC_CUSTOM_PLUGIN_URL.'/assets/js/jquery.min.js', array('jquery'), '1.0.0', true);


            //js for custom  
            
            wp_enqueue_script('ccpc_custom_front_js', CCPC_CUSTOM_PLUGIN_URL.'/assets/js/custom-front-ajax.js', array('jquery'), '1.0.0', true);

			wp_localize_script('ccpc_custom_front_js','profileManagement',array( 

				'ajax_url'			=> site_url().'/wp-admin/admin-ajax.php',

                'ajax_site_url'      => site_url(),

				'ajax_nonce'		=> wp_create_nonce('customCCPC_nonce')

			));

			wp_enqueue_style('ccpc_custom_css', CCPC_CUSTOM_PLUGIN_URL.'/assets/css/custom-style.css',false,'1.5','all');
			wp_enqueue_style( 'ccpc_custom_css' ); 


            wp_enqueue_style('ccpc_jquery-ui-css', 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css',false,'0.1','all');
            wp_enqueue_style( 'ccpc_jquery-ui-css' );

            wp_enqueue_script('ccpc_jquery-ui-js', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array('jquery'), '1.0.0', true);
        }
    }

endif;

new Profile_Management_Helper();