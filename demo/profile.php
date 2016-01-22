<?php
//load up your config file
include_once 'config.php';
require_once __DIR__ . '/classes/authentication.php';

//If user is not logged in then return to index page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$post_value = $_POST;

//Check logout request.
if (isset($post_value['value']) && $post_value['value'] == 'logout') {
    //Call logout function
    Authentication::logout();
}
//Check profile update request
elseif (!empty($post_value['update'])) {
    //Call Update profile function
    Authentication::updateProfile($post_value);
}
//Check change password request.
elseif (isset($post_value['newpassword']) && !empty($post_value['newpassword'])) {
    //Call change Password function
    Authentication::changePassword($post_value);
}
//Check set password request.
elseif (isset($post_value['password']) && !empty($post_value['password'])) {
    //Call Set password function
    Authentication::setPassword($post_value);
}
//Check account linking  request.
elseif (isset($post_value['value']) && $post_value['value'] == 'accountUnLink') {
    //Call Update profile function
    Authentication::unlinkAccount($post_value);
}
//Check account unlink request.
elseif (isset($post_value['value']) && $post_value['value'] == 'accountLink') {
    //Call Update profile function
    Authentication::linkAccount($post_value);
}
$data = $_SESSION['userprofile'];
include_once 'includes/header.php';
?>
<!-- Add Profile page content-->
<div class="lr-profile-frame lr-input-style">
    <div class="lr-profile-header">
        <?php
        $image_url = isset($data->ImageUrl) && !empty($data->ImageUrl) ? $data->ImageUrl : "assets/images/user.png";
        ?>
        <span class="lr-image-frame">
            <img src="<?php echo $image_url ?>" alt="<?php echo $data->Name ?>">
        </span>

        <div class="lr-heading">Hello, <span class="lr-user-name"><?php echo $data->Name; ?></span></div>

        <div class="lr-profile-info">
            <div class="lr-email-info">
                <span class="lr-value lr-em"><?php echo $data->Email; ?></span>
            </div>

            <div class="lr-uid-info">
                <span class="lr-label">UID: </span>
                <span class="lr-value"><?php echo $data->Uid; ?></span>
            </div>
        </div>

        <!-- Add Menu tab items -->
        <div class="lr-menu-buttons">
            <span class="lr-buttons lr-tab-active" data-tab="lr-profile">Profile</span>
            <span class="lr-buttons" data-tab="lr-account-prov">Account Providers</span>
            <span class="lr-buttons" id="lr-password-tab" data-tab="lr-set-pw">Set Password</span>
            <span class="lr-logout" onclick='profileLogout();'>Logout</span>
        </div>
    </div>
    <div id="lr-profile" class="lr-frame lr-align-left lr-tab-active">
        <div class="lr-submenu-buttons">
            <span id="lr-tab-basic" class="lr-buttons lr-tab-active" data-tab="lr-basic">Basic</span>
            <span id="lr-tab-extened" class="lr-buttons" data-tab="lr-extened">Extended</span>
            <?php if ($data->Provider != 'RAAS') { ?>
                <span id="lr-tab-contact" class="lr-buttons" data-tab="lr-contact">Contacts</span>
                <span id="lr-tab-likes" class="lr-buttons" data-tab="lr-likes">Likes</span>
                <span id="lr-tab-albums" class="lr-buttons" data-tab="lr-albums">Albums</span>
                <span id="lr-tab-checkins" class="lr-buttons" data-tab="lr-checkins">Checkins</span>
                <span id="lr-tab-audio" class="lr-buttons" data-tab="lr-audio">Audio</span>
                <span id="lr-tab-mentions" class="lr-buttons" data-tab="lr-mentions">Mentions</span>
                <span id="lr-tab-following" class="lr-buttons" data-tab="lr-following">Following</span>
                <span id="lr-tab-events" class="lr-buttons" data-tab="lr-events">Events</span>
                <span id="lr-tab-posts" class="lr-buttons" data-tab="lr-posts">Posts</span>
                <span id="lr-tab-companies" class="lr-buttons" data-tab="lr-companies">Companies</span>
                <span id="lr-tab-groups" class="lr-buttons" data-tab="lr-groups">Groups</span>
                <span id="lr-tab-status" class="lr-buttons" data-tab="lr-status">Status</span>
                <span id="lr-tab-videos" class="lr-buttons" data-tab="lr-videos">Videos</span>
                <?php
                if (in_array($data->Provider, array('facebook', 'twitter', 'linkedin'))) {
                    ?>
                    <span id="lr-tab-poststatus" class="lr-buttons" data-tab="lr-poststatus">Post Status</span>
                    <?php
                }if (in_array($data->Provider, array('twitter', 'linkedin'))) {
                    ?>
                    <span id="lr-tab-sendmessage" class="lr-buttons" data-tab="lr-sendmessage">Send Message</span>
                    <?php
                }
            }
            ?>
        </div>

        <div id="lr-basic" class="lr-frame lr-subframe lr-tab-active">
            <?php echo Authentication::getProfileForm($data); ?>
        </div>
        <div id="lr-extened" class="lr-frame lr-subframe lr-extened lr-align-left"></div>
        <?php if ($data->Provider != 'RAAS') { ?>
            <div id="lr-contact" class="lr-frame lr-subframe lr-contact lr-align-left"></div>
            <div id="lr-likes" class="lr-frame lr-subframe lr-likes lr-align-left"></div>
            <div id="lr-albums" class="lr-frame lr-subframe lr-albums lr-align-left"></div>
            <div id="lr-checkins" class="lr-frame lr-subframe lr-checkins lr-align-left"></div>
            <div id="lr-audio" class="lr-frame lr-subframe lr-audio lr-align-left"></div>
            <div id="lr-mentions" class="lr-frame lr-subframe lr-mentions lr-align-left"></div>
            <div id="lr-following" class="lr-frame lr-subframe lr-following lr-align-left"></div>
            <div id="lr-events" class="lr-frame lr-subframe lr-events lr-align-left"></div>
            <div id="lr-posts" class="lr-frame lr-subframe lr-posts lr-align-left"></div>
            <div id="lr-companies" class="lr-frame lr-subframe lr-companies lr-align-left"></div>
            <div id="lr-groups" class="lr-frame lr-subframe lr-groups lr-align-left"></div>
            <div id="lr-status" class="lr-frame lr-subframe lr-status lr-align-left"></div>
            <div id="lr-videos" class="lr-frame lr-subframe lr-videos lr-align-left"></div>
            <?php
            if (in_array($data->Provider, array('facebook', 'twitter', 'linkedin'))) {
                ?>
                <div id="lr-poststatus" class="lr-frame lr-subframe lr-poststatus lr-align-left">
                    <form action='' onsubmit="return false">
                        <h2>Post Status</h2>
                        <div id="postmessage"></div>
                        <br>
                        <label for="posttitle" class="faclable">Title :</label>
                        <input type="text" id="posttitle" class="factextbox"><br/>
                        <?php if ($data->Provider != 'twitter') { ?>
                            <label for="posturl" class="faclable">URL :</label>
                            <input type="text" id="posturl" class="factextbox"><br/>
                            <label for="postimageurl" class="faclable">Image URL :</label>
                            <input type="text" id="postimageurl" class="factextbox"><br/>
                        <?php } ?>
                        <label for="poststatus" class="faclable">Message :</label>
                        <textarea id="poststatus" class="facetextarea"></textarea><br/>
                        <?php if ($data->Provider != 'twitter') { ?>
                            <label for="postdescription" class="faclable">Description :</label>
                            <textarea id="postdescription" class="facetextarea"></textarea>
                            <br/>
                        <?php } ?>
                        <div class="lr-submit-frame lr-align-right">
                            <button onClick="postStatus('<?php echo $data->Provider; ?>');" class="facesend">Send</button>
                        </div>
                    </form>
                </div>
                <?php
            }
            if (in_array($data->Provider, array('twitter', 'linkedin'))) {
                ?>
                <div id="lr-sendmessage" class="lr-frame lr-subframe lr-sendmessage lr-align-left">
                    <form action='' onsubmit="return false">
                        <h2>Send Message</h2>
                        <div id="sendmessage"></div><br>
                        <label for="sendto" class="faclable">To :</label>
                        <select class="twilist" name="sendto" id="sendto">
                            <option value=""> --- Select --- </option>
                        </select>
                        <br/>
                        <label for="sendsub" class="faclable">Subject :</label>
                        <input type="text" id="sendsub" class="factextbox"><br/>
                        <label for="sendstatus" class="faclable">Message :</label>
                        <textarea id="sendstatus" class="facetextarea"></textarea><br/>
                        <div class="lr-submit-frame lr-align-right">
                            <button onClick="sendMessage();" class="facesend">Send</button>
                        </div>
                    </form>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <!-- Add Account Linking Tab content -->
    <div id="lr-account-prov" class="lr-frame lr-account-prov lr-align-left">
        <!-- Login social icons -->
        <!-- Spans are easier to manage than divs. But remember to not nest a div inside a span -->
        <div class="lr-login-buttons-frame lr-space-fix">
            <script type="text/html" id="loginradiuscustom_tmpl">
                <# if(isLinked) { #>
                <div class="lr-linked">
                    <div class="lr-linked-id"><span class="lr-icon-frame">
                            <span class="lr-icon lr-raas-<#= Name.toLowerCase() #>"></span>
                        </span>

                        <span class="lr-linked-label"><#= Name #> is connected</span>
                        <span class="lr-unlink lr-pull-right lr-tooltip" data-title="Unlink" onclick='return unLinkAccount(\"<#= Name.toLowerCase() #>\",\"<#= providerId #>\")'>&#215;</span>
                    </div>
                </div>
                <# }  else {#>
                <div class="lr-unlinked">
                    <span class="lr-icon-frame">
                        <span class="lr-icon lr-raas-<#= Name.toLowerCase() #>"
                              onclick="return $SL.util.openWindow('<#= Endpoint #>&is_access_token=true&callback=<?php echo PAGEPATH; ?>');">
                        </span>
                    </span>
                </div>
                <# } #>
                </script>
                <div class="accountlinkinginterface" id="accountlinkinginterface"></div>
                <div class="lr-linked-data lr-linked-frame"></div>
                <div style="clear:both"></div>
                <div class="lr-unlinked-data lr-not-linked-frame"></div>
                <div style="clear:both"></div>
            </div>
        </div>

        <!-- Add Set Password Container -->
        <div id="lr-set-pw" class="lr-frame lr-set-pw lr-align-left">
            <div id="lr-setpasswordbox-popup-message"></div>
            <div id="setpasswordbox"></div>
        </div>

        <!-- Add Change Password Container -->
        <div id="lr-change-pw" class="lr-frame lr-change-pw lr-align-left">
            <div id="lr-changepasswordbox-popup-message"></div>
            <div id="changepasswordbox"></div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            getAjaxRequest('lr-extened', {"func": 'extendedProfile'});
<?php if ($data->Provider != 'RAAS') { ?>
                var poststatus = false;
                <?php if (in_array($data->Provider, array('twitter', 'linkedin'))) { ?>
                    poststatus = true;
                <?php } ?>
                getAjaxRequest('lr-contact', {"func": 'contact', "poststatus": poststatus});
                getAjaxRequest('lr-likes', {"func": 'likes'});
                getAjaxRequest('lr-albums', {"func": 'albums'});
                getAjaxRequest('lr-checkins', {"func": 'checkins'});
                getAjaxRequest('lr-audio', {"func": 'audio'});
                getAjaxRequest('lr-mentions', {"func": 'mentions'});
                getAjaxRequest('lr-following', {"func": 'following'});
                getAjaxRequest('lr-events', {"func": 'events'});
                getAjaxRequest('lr-posts', {"func": 'posts'});
                getAjaxRequest('lr-companies', {"func": 'companies'});
                getAjaxRequest('lr-groups', {"func": 'groups'});
                getAjaxRequest('lr-status', {"func": 'status'});
                getAjaxRequest('lr-videos', {"func": 'videos'});
<?php } ?>
        });
<?php if (isset($_SESSION['mymessage']) && !empty($_SESSION['mymessage'])) { ?>
            window.onload = function () {
                handleResponse(true, '<?php echo $_SESSION['mymessage']; ?>', true);
            }
    <?php
    $_SESSION['mymessage'] = '';
}
?>
    </script>
    <!---//End-wrap---->
    <?php
    include_once 'includes/footer.php';
    