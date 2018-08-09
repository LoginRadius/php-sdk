<?php

use LoginRadiusSDK\LoginRadius;
//load up your config file
include_once 'config.php';
require_once __DIR__ . '/classes/authentication.php';

ob_start();

$post_value = $_POST;

// If user is logged in then redirect to profile page.
if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit();
}

//Handle LoginRadius token and provide login to user.
if (isset($post_value['token']) && $post_value['token'] != '') {
    //Call login constructor
    Authentication::getProfiles();
    Authentication::login();
}
//Load scripts
include_once 'includes/header.php';
?>
<!-- Add Page content here-->
<div class="lr-frame lr-input-style">
    <h2>A Complete User Authentication Solution </h2>

    <div style="  text-align: left;margin-top:20px;">
        Want to offer your users a choice between Social Login and Traditional Registration?
        We offer both, so you can manage all of your authentication systems in one place. LoginRadius Customer Registration
        and Social Login solutions work seamlessly together for a simplified registration system.
    </div>
    <div style="  text-align: left;margin-top:20px;">
        <h3>1. Managed Registration Service</h3>
        Our Managed Registration Service is a full user authentication solution for your web and mobile applications.
        The managed solution eliminates all the associated hassles with maintaining registration forms, and saves your
        engineering team significant time and resources.

        <h3>Fully Customizable</h3>
        LoginRadius Registration Service allows you to fully customize the registration form and login screen to match
        the look and feel of your website.

        <h3>Email Verification & Forgotten Service</h3>
        Email Verification of new sign-ups and forgotten username/password retrieval are simple fixes with LoginRadius
        Managed Registration.

        <h3>Custom Emails</h3>
        You can easily set custom email templates and content for email verification and forgotten usernames and
        password service. LoginRadius system also has the capability to connect to your existing email service
        provider.

        <h3>User Data Management</h3>
        Data storage is provided to help you manage your users and their data. You keep full ownership of the data and
        have full access at all times. LoginRadius also delivers a copy of the data to your local database.

        <h3>Works with Social Login</h3>
        Our Registration Service comes with Social Login and Social Account Linking. Your existing users can choose to
        migrate to Social Login if they would prefer, or log-in through Traditional Registration. Both systems work
        together seamlessly.

        <h3>Works with all Major Technologies</h3>
        The LoginRadius Platform works with all popular web technologies; WordPress, Drupal, Joomla, PHP, .NET,
        Javascript, Android, iOS and many more. You can see the complete list here.
    </div>
</div>
</div>
<!---//End-wrap---->
<!-- Add Footer content here -->
<?php include_once 'includes/footer.php'; ?>