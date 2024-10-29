<?php

/************************************/
/* Filter wordpress data            */
/************************************/


function amader_rsvp_form($atts){
?>

<!-- Start RSVP -->
<div class="form-wrapper">

    <?php
    global $wpdb;
    ob_start();
    $html = ob_get_clean();

    $error_1st_name = $error_last_name = $error_phone_number = $error_email = $error_attending = $error_kids_menu = $error_vegetarian_menus = $error_invite_code = $error_empty = "";

    $first_name = $last_name = $rsvp_phone = $rsvp_email = $rsvp_attending = $rsvp_kids_menus = $rsvp_vegetarian_menus = $invite_code = "";

    if(isset($_POST['submit'])) {

        $table = $wpdb->prefix."amader_rsvp";


        if(empty(strip_tags($_POST["first_name"]))){
            $error_1st_name = '* First name is required.';
        }elseif(ctype_alpha(sanitize_text_field(strip_tags($_POST["first_name"], "")))){
            $first_name = sanitize_text_field(strip_tags($_POST["first_name"], ""));
        }else{
            $error_1st_name = 'Only letters are allowed.';
        }

        if(empty(strip_tags($_POST["last_name"], ""))){
            $error_last_name = '* Last name is required.';
        }elseif (ctype_alpha(sanitize_text_field(strip_tags($_POST["last_name"], "")))){
            $last_name = sanitize_text_field(strip_tags($_POST["last_name"], ""));
        }else{
            $error_last_name = 'Only letters are allowed.';
        }

        if(empty(strip_tags($_POST["rsvp_phone"], ""))){
            $error_phone_number = '* Phone number is required.';
        }elseif (is_numeric(sanitize_text_field(strip_tags($_POST["rsvp_phone"], "")))){
            $rsvp_phone = sanitize_text_field(strip_tags($_POST["rsvp_phone"], ""));
        }else{
            $error_phone_number = 'Please enter a valid phone number';
        }

        $user_email = sanitize_email(strip_tags($_POST["rsvp_email"], ""));
        if (empty(filter_var($user_email, FILTER_VALIDATE_EMAIL))){
            $error_email = '* Email address is required.';
        }elseif (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $rsvp_email = sanitize_email(strip_tags($_POST["rsvp_email"], ""));
        }else{
            $error_email = 'Please enter a valid email address';
        }

        if(empty(strip_tags($_POST["rsvp_attending"], ""))){
            $error_attending = '* This field is required.';
        }elseif (is_numeric(sanitize_text_field(strip_tags($_POST["rsvp_attending"], "")))){
            $rsvp_attending = sanitize_text_field(strip_tags($_POST["rsvp_attending"], ""));
        }else{
            $error_attending = 'Unacceptable value';
        }

        if(empty(strip_tags($_POST["rsvp_kids_menus"], ""))){
            $error_kids_menu = '* Kids menu is required.';
        }elseif (is_numeric(sanitize_text_field(strip_tags($_POST["rsvp_kids_menus"], "")))){
            $rsvp_kids_menus = sanitize_text_field(strip_tags($_POST["rsvp_kids_menus"], ""));
        }else{
            $error_kids_menu = 'Unacceptable value';
        }

        if(empty(strip_tags($_POST["rsvp_vegetarian_menus"], ""))){
            $error_vegetarian_menus = '* Vegetarian menu is required.';
        }elseif(is_numeric(sanitize_text_field(strip_tags($_POST["rsvp_vegetarian_menus"], "")))){
            $rsvp_vegetarian_menus = sanitize_text_field(strip_tags($_POST["rsvp_vegetarian_menus"], ""));
        }else{
            $error_vegetarian_menus = 'Unacceptable value';
        }

        $invitation_code = sanitize_text_field(strip_tags($_POST["invite_code"], ""));
        if (empty($invitation_code)){
            $error_invite_code = '* Invitation code is required.';
        }elseif(preg_match('/^[a-z0-9]+$/',$invitation_code)){
            $invite_code = sanitize_text_field(strip_tags($_POST["invite_code"], ""));
        }else{
            $error_invite_code = 'Unacceptable value';
        }


        if (empty($first_name && $last_name && $rsvp_phone && $rsvp_email && $rsvp_attending && $rsvp_kids_menus && $rsvp_vegetarian_menus && $invite_code)){
            $error_empty = 'Please fill all the required fields with correct data.';
        }else{
            $wpdb->insert(
                $table,
                array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'rsvp_phone' => $rsvp_phone,
                    'rsvp_email' => $rsvp_email,
                    'rsvp_attending' => $rsvp_attending,
                    'rsvp_kids_menus' => $rsvp_kids_menus,
                    'rsvp_vegetarian_menus' => $rsvp_vegetarian_menus,
                    'invite_code' => $invite_code,
                )
            );
            $html = "<div class='alert alert-success alert-dismissible fade in h5'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Thanks for your confirmation.</div>";
            echo $html;
        }

    }
    ?>

    <form class="form" data-toggle="validator" action="#v_form" method="POST" id="v_form">
        <div class="col-md-6">
            <span class="text-danger"><?php echo $error_1st_name;?></span>
            <div class="form-group input-container">
                <i class="fa fa-user fa-lg icon"></i>
                <input type="text" class="form-control input-field rsvp-input" id="first_name" name="first_name" placeholder="First Name" aria-required="true" required="">
            </div>
            <span class="text-danger"><?php if(isset($_POST['submit'])) {echo $error_last_name;}?></span>
            <div class="form-group input-container">
                <i class="fa fa-user fa-lg icon"></i>
                <input type="text" class="form-control input-field rsvp-input" id="last_name" name="last_name" placeholder="Last Name" aria-required="true" required="">
            </div>
            <span class="text-danger"><?php if(isset($_POST['submit'])) {echo $error_phone_number;}?></span>
            <div class="form-group input-container">
                <i class="fa fa-phone fa-lg icon"></i>
                <input type="text" class="form-control input-field rsvp-input" id="rsvp_phone" name="rsvp_phone"
                       placeholder="Phone Number" aria-required="true" required="">
            </div>
            <span class="text-danger"><?php if(isset($_POST['submit'])) {echo $error_email;}?></span>
            <div class="form-group input-container">
                <i class="fa fa-envelope fa-lg icon"></i>
                <input type="email" class="form-control input-field rsvp-input" id="rsvp_email" name="rsvp_email"
                       placeholder="Your Email" aria-required="true" required="">
            </div>

        </div>

        <div class="col-md-6">
            <span class="text-danger"><?php if(isset($_POST['submit'])) {echo $error_attending;}?></span>
            <div class="form-group input-container">
                <i class="fa fa-users fa-lg icon"></i>
                <input type="number" class="form-control input-field rsvp-input" id="rsvp_attending" name="rsvp_attending" placeholder="No of persons attending" aria-required="true" required="">
            </div>

            <span class="text-danger"><?php if(isset($_POST['submit'])) {echo $error_kids_menu;}?></span>
            <div class="form-group input-container">
                <i class="fa fa-child fa-lg icon"></i>
                <input type="number" class="form-control input-field rsvp-input" id="rsvp_kids_menus" name="rsvp_kids_menus" placeholder="No of kids menus" aria-required="true" required="">
            </div>

            <span class="text-danger"><?php if(isset($_POST['submit'])) {echo $error_vegetarian_menus;}?></span>
            <div class="form-group input-container">
                <i class="fa fa-male fa-lg icon"></i>
                <input type="number" class="form-control input-field rsvp-input" id="rsvp_vegetarian_menus" name="rsvp_vegetarian_menus" placeholder="No of vegetarian menus" aria-required="true" required="">
            </div>

            <span class="text-danger"><?php if(isset($_POST['submit'])) {echo $error_invite_code;}?></span>
            <div class="form-group input-container">
                <i class="fa fa-paperclip fa-lg icon"></i>
                <input type="text" class="form-control input-field rsvp-input" id="invite_code" name="invite_code" placeholder="Your Invite Code" aria-required="true" required="">
            </div>
        </div>

        <div class="col-md-12">
            <p class="text-center text-danger"><?php echo $error_empty;?></p>
            <div class="text-center">
                <input type="submit" name="submit" id="submit" class="btn btn-outline" value="RSVP">
            </div>
        </div>
    </form>
</div>
<!-- End RSVP -->

<?php
}

add_shortcode('amader_rsvp','amader_rsvp_form');









