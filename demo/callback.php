<?php
include_once('config.php');
include_once('LoginRadius_functions.php');
include_once('LoginRadiusSDK.php');
?>
<html>
    <head>
        <!-- CSS goes in the document HEAD or added to your external stylesheet -->
        <title>SocialLogin :: UserProfile</title>
        <script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/tabcontent.js" type="text/javascript"></script>
        <link href="css/tabs.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        if (isset($_REQUEST['token']) && !empty($_REQUEST['token'])) {
            $loginradius = new LoginRadius();
            try {
                $result_accesstoken = $loginradius->loginradius_exchange_access_token(LR_SECRETKEY);
				$lraccesstoken = $result_accesstoken->access_token;
            } catch (LoginRadiusException $e) {
                echo ' Access Token API :- ';
                echo $e->getMessage() . '<br><br>';
                echo 'Redirecting to home page in 5 seconds.....<br>';
                header( "refresh:5;url=".YOUR_DOMAIN );
                exit();
            }
            if (isset($lraccesstoken) && !empty($lraccesstoken)) {
                $UserPhotoalbums = '';
                $UserPhotos = '';
                $UserCheckins = '';
                $UserAudio = '';
                $UserSendMessage = '';
                $UserContacts = '';
                $UserMentions = '';
                $UserFollowing = '';
                $UserEvents = '';
                $UserGetPost = '';
                $UserFollowedCompanies = '';
                $UserGroups = '';
                $UserGetStatus = '';
                $UserPostStatus = '';
                $UserVideos = '';
                $UserLikes = '';
                $post_status = '';
                $sendmessage = '';
                try {
                    $UserProfileData = $loginradius->loginradius_get_user_profiledata($lraccesstoken);
                } catch (LoginRadiusException $e) {
                    echo ' User Profile Data API :- ';
                    echo $e->getMessage() . '<br>';
                }
                if (!empty($UserProfileData) && is_object($UserProfileData)) {
                    if (in_array($UserProfileData->Provider, array('foursquare'))) {
                        try {
                            $UserPhotos = $loginradius->loginradius_get_photos($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Photo API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('facebook', 'google', 'live', 'vkontakte', 'renren'))) {
                        try {
                            $UserPhotoalbums = $loginradius->loginradius_get_photo_albums($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Photo Albums API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('foursquare', 'vkontakte'))) {
                        try {
                            $UserCheckins = $loginradius->loginradius_get_checkins($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Checkins API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('live', 'vkontakte'))) {
                        try {
                            $UserAudio = $loginradius->loginradius_get_audio($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Audio API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('facebook', 'google', 'twitter', 'linkedin', 'yahoo', 'live', 'vkontakte', 'foursquare', 'renren'))) {
                        try {
                            $UserContacts = $loginradius->loginradius_get_contacts($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Contact API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                        if (isset($UserContacts->isProviderError)) {
                            $UserContacts = '';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('twitter'))) {
                        try {
                            $UserMentions = $loginradius->loginradius_get_mentions($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Mentions API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('twitter'))) {
                        try {
                            $UserFollowing = $loginradius->loginradius_get_following($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Following API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('facebook', 'live'))) {
                        try {
                            $UserEvents = $loginradius->loginradius_get_events($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Events API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('facebook'))) {
                        try {
                            $UserGetPost = $loginradius->loginradius_get_posts($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Posts API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('facebook', 'linkedin'))) {
                        try {
                            $UserFollowedCompanies = $loginradius->loginradius_get_followed_companies($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Companies API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('facebook', 'linkedin', 'vkontakte'))) {
                        try {
                            $UserGroups = $loginradius->loginradius_get_groups($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Groups API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('facebook', 'twitter', 'linkedin', 'vkontakte', 'renren'))) {
                        try {
                            $UserGetStatus = $loginradius->loginradius_get_status($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Status API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('facebook', 'google', 'live', 'vkontakte'))) {
                        try {
                            $UserVideos = $loginradius->loginradius_get_videos($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Videos API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                        if (isset($UserVideos->isProviderError)) {
                            $UserVideos = '';
                        }
                    }

                    if (in_array($UserProfileData->Provider, array('facebook'))) {
                        try {
                            $UserLikes = $loginradius->loginradius_get_likes($lraccesstoken);
                        } catch (LoginRadiusException $e) {
                            echo ' Likes API :- ';
                            echo $e->getMessage() . '<br>';
                        }
                    }
                    if (in_array($UserProfileData->Provider, array('facebook', 'twitter', 'linkedin'))) {
                        $post_status = true;
                    }
                    if (in_array($UserProfileData->Provider, array('twitter', 'linkedin'))) {
                        $sendmessage = true;
                    }
                    ?>
                    <div style=" margin: 0 auto; padding: 40px">
                        <ul class="tabs" data-persist="true">
                            <li><a href="#view1">Profile</a></li>
                            <?php if (!empty($UserPhotoalbums)) {
                                ?>
                                <li><a href="#view2">Albums</a></li>
                            <?php } ?>
                            <?php if (!empty($UserPhotos)) {
                                ?>
                                <li><a href="#view3">Photos</a></li>
                            <?php } ?>
                            <?php if (!empty($UserCheckins)) {
                                ?>
                                <li><a href="#view4">Checkins</a></li>
                            <?php } ?>
                            <?php if (!empty($UserAudio)) {
                                ?>
                                <li><a href="#view5">Audio</a></li>
                            <?php } ?>
                            <?php if (!empty($UserSendMessage)) {
                                ?>
                                <li><a href="#view6">Send Message</a></li>
                            <?php } ?>
                            <?php if (!empty($UserContacts)) {
                                ?>
                                <li><a href="#view7">Contacts</a></li>
                            <?php } ?>
                            <?php if (!empty($UserMentions)) {
                                ?>
                                <li><a href="#view8">Mentions</a></li>
                            <?php } ?>
                            <?php if (!empty($UserFollowing)) {
                                ?>
                                <li><a href="#view9">Following</a></li>
                            <?php } ?>
                            <?php if (!empty($UserEvents)) {
                                ?>
                                <li><a href="#view10">Events</a></li>
                            <?php } ?>
                            <?php if (!empty($UserGetPost)) {
                                ?>
                                <li><a href="#view11">Get Posts</a></li>
                            <?php } ?>
                            <?php if (!empty($UserFollowedCompanies)) {
                                ?>
                                <li><a href="#view12">Companies</a></li>
                            <?php } ?>
                            <?php if (!empty($UserGroups)) {
                                ?>
                                <li><a href="#view13">Groups</a></li>
                            <?php } ?>
                            <?php if (!empty($UserGetStatus)) {
                                ?>
                                <li><a href="#view14">Get Status</a></li>
                            <?php } ?>
                            <?php if (!empty($UserVideos)) {
                                ?>
                                <li><a href="#view15">Videos</a></li>
                            <?php } ?>
                            <?php if (!empty($UserLikes)) {
                                ?>
                                <li><a href="#view16">Likes</a></li>
                            <?php } ?>
                            <?php if (!empty($post_status)) {
                                ?>
                                <li><a href="#view17">Post Status</a></li>
                            <?php } ?>
                            <?php if (!empty($sendmessage)) {
                                ?>
                                <li><a href="#view18">Send Message</a></li>
                            <?php } ?>
                        </ul>

                        <div class="tabcontents">
                            <div id="view1">
                                <h2>User Profile</h2>
                                <?php
                                //user Profile data
                                LoginRadius_userdata_format($UserProfileData);
                                ?>
                            </div>
                            <?php
//user Photo albams
                            if (!empty($UserPhotoalbums)) {
                                ?>
                                <div id="view2">
                                    <div id="ajaxDiv"></div>
                                    <h2>Album</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'OwnerId'; ?></th>
                                                <th><?php echo 'OwnerName'; ?></th>
                                                <th><?php echo 'Title'; ?></th>
                                                <th><?php echo 'Description'; ?></th>
                                                <th><?php echo 'Location'; ?></th>
                                                <th><?php echo 'Type'; ?></th>
                                                <th><?php echo 'CreatedDate'; ?></th>
                                                <th><?php echo 'UpdatedDate'; ?></th>
                                                <th><?php echo 'CoverImageUrl'; ?></th>
                                                <th><?php echo 'ImageCount'; ?></th>
                                                <th><?php echo 'DirectoryUrl'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserPhotoalbums, $lraccesstoken, YOUR_DOMAIN); ?>
                                        </tfoot>
                                    </table>
                                    <b>Note :- Click on Image under CoverImageUrl to see all images in album</b>
                                </div>
                                <?php
                            }
//user Photo albams
                            if (!empty($UserPhotos)) {
                                ?>
                                <div id="view3">
                                    <h2>Photos</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'AlbumId'; ?></th>
                                                <th><?php echo 'OwnerId'; ?></th>
                                                <th><?php echo 'OwnerName'; ?></th>
                                                <th><?php echo 'Name'; ?></th>
                                                <th><?php echo 'DirectUrl'; ?></th>
                                                <th><?php echo 'ImageUrl'; ?></th>
                                                <th><?php echo 'Location'; ?></th>
                                                <th><?php echo 'Link'; ?></th>
                                                <th><?php echo 'Description'; ?></th>
                                                <th><?php echo 'Height'; ?></th>
                                                <th><?php echo 'Width'; ?></th>
                                                <th><?php echo 'CreatedDate'; ?></th>
                                                <th><?php echo 'UpdatedDate'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_Internel_UserProfile($UserPhotos); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }
//user Checkins
                            if (!empty($UserCheckins)) {
                                ?>
                                <div id="view4">
                                    <h2>User Chechins</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'CreatedDate'; ?></th>
                                                <th><?php echo 'OwnerId'; ?></th>
                                                <th><?php echo 'OwnerName'; ?></th>
                                                <th><?php echo 'Latitude'; ?></th>
                                                <th><?php echo 'Longitude'; ?></th>
                                                <th><?php echo 'Message'; ?></th>
                                                <th><?php echo 'PlaceTitle'; ?></th>
                                                <th><?php echo 'Address'; ?></th>
                                                <th><?php echo 'Distance'; ?></th>
                                                <th><?php echo 'Type'; ?></th>
                                                <th><?php echo 'ImageUrl'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserCheckins); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }
//user Audio
                            if (!empty($UserAudio)) {
                                ?>
                                <div id="view5">
                                    <h2>Audio</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'OwnerId'; ?></th>
                                                <th><?php echo 'OwnerName'; ?></th>
                                                <th><?php echo 'Artist'; ?></th>
                                                <th><?php echo 'Title'; ?></th>
                                                <th><?php echo 'Duration'; ?></th>
                                                <th><?php echo 'Url'; ?></th>
                                                <th><?php echo 'CreatedDate'; ?></th>
                                                <th><?php echo 'UpdatedDate'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserAudio); ?>
                                        </tfoot>
                                    </table>
                                </div><?php
                            }

//user Get Contacts
                            if (!empty($UserContacts)) {
                                ?>
                                <div id="view7">
                                    <h2>Contacts</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'Name'; ?></th>
                                                <th><?php echo 'EmailID'; ?></th>
                                                <th><?php echo 'PhoneNumber'; ?></th>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'ProfileUrl'; ?></th>
                                                <th><?php echo 'ImageUrl'; ?></th>
                                                <th><?php echo 'Status'; ?></th>
                                                <th><?php echo 'Industry'; ?></th>
                                                <th><?php echo 'Country'; ?></th>
                                                <th><?php echo 'Location'; ?></th>
                                                <th><?php echo 'Gender'; ?></th>
                                                <th><?php echo 'DateOfBirth'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php
                                            foreach ($UserContacts as $key => $value) {
                                                LoginRadius_UserAlbam($value);
                                            }
                                            ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }

//User Mentions
                            if (!empty($UserMentions)) {
                                ?>
                                <div id="view8">
                                    <h2>Mentions</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'Id'; ?></th>
                                                <th><?php echo 'Text'; ?></th>
                                                <th><?php echo 'DateTime'; ?></th>
                                                <th><?php echo 'Likes'; ?></th>
                                                <th><?php echo 'Place'; ?></th>
                                                <th><?php echo 'Source'; ?></th>
                                                <th><?php echo 'ImageUrl'; ?></th>
                                                <th><?php echo 'LinkUrl'; ?></th>
                                                <th><?php echo 'Name'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserMentions); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }

//User Following
                            if (!empty($UserFollowing)) {
                                ?>
                                <div id="view9">
                                    <h2>Follows</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'Name'; ?></th>
                                                <th><?php echo 'EmailID'; ?></th>
                                                <th><?php echo 'PhoneNumber'; ?></th>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'ProfileUrl'; ?></th>
                                                <th><?php echo 'ImageUrl'; ?></th>
                                                <th><?php echo 'Status'; ?></th>
                                                <th><?php echo 'Industry'; ?></th>
                                                <th><?php echo 'Country'; ?></th>
                                                <th><?php echo 'Location'; ?></th>
                                                <th><?php echo 'Gender'; ?></th>
                                                <th><?php echo 'DateOfBirth'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserFollowing); ?>
                                        </tfoot>
                                    </table>
                                </div><?php
                            }

//User Events
                            if (!empty($UserEvents)) {
                                ?>
                                <div id="view10">
                                    <h2>Events</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'OwnerId'; ?></th>
                                                <th><?php echo 'OwnerName'; ?></th>
                                                <th><?php echo 'Name'; ?></th>
                                                <th><?php echo 'Description'; ?></th>
                                                <th><?php echo 'RsvpStatus'; ?></th>
                                                <th><?php echo 'Location'; ?></th>
                                                <th><?php echo 'StartTime'; ?></th>
                                                <th><?php echo 'UpdatedDate'; ?></th>
                                                <th><?php echo 'EndTime'; ?></th>
                                                <th><?php echo 'Privacy'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserEvents); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }

//User Get Posts
                            if (!empty($UserGetPost)) {
                                ?>
                                <div id="view11">
                                    <h2>Get Posts</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'Name'; ?></th>
                                                <th><?php echo 'Title'; ?></th>
                                                <th><?php echo 'StartTime'; ?></th>
                                                <th><?php echo 'UpdateTime'; ?></th>
                                                <th><?php echo 'Message'; ?></th>
                                                <th><?php echo 'Place'; ?></th>
                                                <th><?php echo 'Picture'; ?></th>
                                                <th><?php echo 'Likes'; ?></th>
                                                <th><?php echo 'Share'; ?></th>
                                                <th><?php echo 'Type'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserGetPost); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }

//User Followed Companies
                            if (!empty($UserFollowedCompanies)) {
                                ?>
                                <div id="view12">
                                    <h2>Companies</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'Name'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserFollowedCompanies); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }

//User Get Groups
                            if (!empty($UserGroups)) {
                                ?>
                                <div id="view13">
                                    <h2>Groups</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'Name'; ?></th>
                                                <th><?php echo 'Email'; ?></th>
                                                <th><?php echo 'Description'; ?></th>
                                                <th><?php echo 'Type'; ?></th>
                                                <th><?php echo 'Country'; ?></th>
                                                <th><?php echo 'PostalCode'; ?></th>
                                                <th><?php echo 'Logo'; ?></th>
                                                <th><?php echo 'Image'; ?></th>
                                                <th><?php echo 'MemberCount'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserGroups); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }

//User Get Status
                            if (!empty($UserGetStatus)) {
                                ?>
                                <div id="view14">
                                    <h2>Get Status</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'Text'; ?></th>
                                                <th><?php echo 'DateTime'; ?></th>
                                                <th><?php echo 'Likes'; ?></th>
                                                <th><?php echo 'Place'; ?></th>
                                                <th><?php echo 'Source'; ?></th>
                                                <th><?php echo 'ImageUrl'; ?></th>
                                                <th><?php echo 'LinkUrl'; ?></th>
                                                <th><?php echo 'Name'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserGetStatus); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }

//User Get Videos
                            if (!empty($UserVideos)) {
                                ?>
                                <div id="view15">
                                    <h2>Videos</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'Description'; ?></th>
                                                <th><?php echo 'Name'; ?></th>
                                                <th><?php echo 'Image'; ?></th>
                                                <th><?php echo 'Source'; ?></th>
                                                <th><?php echo 'CreatedDate'; ?></th>
                                                <th><?php echo 'OwnerId'; ?></th>
                                                <th><?php echo 'OwnerName'; ?></th>
                                                <th><?php echo 'EmbedHtml'; ?></th>
                                                <th><?php echo 'UpdatedDate'; ?></th>
                                                <th><?php echo 'Duration'; ?></th>
                                                <th><?php echo 'DirectLink'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserVideos); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }

//User Get Likes
                            if (!empty($UserLikes)) {
                                ?>
                                <div id="view16">
                                    <h2>Likes</h2>
                                    <table class="gridtable" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th><?php echo 'ID'; ?></th>
                                                <th><?php echo 'Name'; ?></th>
                                                <th><?php echo 'Category'; ?></th>
                                                <th><?php echo 'CreatedDate'; ?></th>
                                                <th><?php echo 'Website'; ?></th>
                                                <th><?php echo 'Description'; ?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <?php LoginRadius_UserAlbam($UserLikes); ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <?php
                            }
//User Post Status
                            if (isset($post_status) && $post_status == true) {
                                ?>
                                <div id="view17" style=" margin: 0 auto;width: 350px;">
                                    <h2>Post Status</h2>

                                    <div id="poststratus"></div>
                                    <br>
                                    <?php $callback = str_replace('callback.php', '', YOUR_DOMAIN); ?>
                                    <input type="hidden" value="<?php echo $callback; ?>" id="connection_url">
                                    <input type="hidden" value="<?php echo $UserProfileData->Provider; ?>" id="provider">
                                    <input type="hidden" value="<?php echo $lraccesstoken; ?>" id="lraccesstoken">
                                    <label for="title" class="faclable">Title :</label><input type="text" id="title" value=""
                                                                                              class="factextbox"><br/>
                                                                                              <?php if (!in_array($UserProfileData->Provider, array('twitter'))) {
                                                                                                  ?>
                                        <label for="url" class="faclable">URL :</label><input type="text" id="url" value="" class="factextbox"><br/>
                                        <label for="imageurl" class="faclable">Image URL :</label><input type="text" id="imageurl" value=""
                                                                                                         class="factextbox"><br/>
                                                                                                     <?php } ?>
                                    <label for="status" class="faclable">Message :</label><textarea id="status"
                                                                                                    class="facetextarea"></textarea><br/>
                                                                                                    <?php if (!in_array($UserProfileData->Provider, array('twitter'))) {
                                                                                                        ?>
                                        <label for="description" class="faclable">Description :</label><textarea id="description"
                                                                                                                 class="facetextarea"></textarea>
                                        <br/>
                                    <?php } ?>
                                    <button onClick="lrpoststratus();" class="facesend">Send</button>
                                </div>
                                <?php
                            }

//User Send Message
                            if (isset($sendmessage) && $sendmessage == true) {
                                ?>
                                <div id="view18" style=" margin: 0 auto;width: 350px;">
                                    <h2>Send Message</h2>

                                    <div id="sendmessage"></div>
                                    <br>
                                    <?php $callback = str_replace('callback.php', '', YOUR_DOMAIN); ?>
                                    <input type="hidden" value="<?php echo $callback; ?>" id="sendconnection_url">
                                    <input type="hidden" value="<?php echo $lraccesstoken; ?>" id="sendlraccesstoken">
                                    <label for="sendto" class="faclable">To :</label><select class="twilist" name="sendto" id="sendto">
                                        <?php
                                        foreach ($UserContacts as $contact) {
                                            foreach ($contact as $key => $usercontactvalue) {
                                                ?>
                                                <option value="<?php echo $usercontactvalue->ID; ?>"><?php echo $usercontactvalue->Name; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <br/>
                                    <?php ?>
                                    <label for="sendsub" class="faclable">Subject :</label><input type="text" id="sendsub" value=""
                                                                                                  class="factextbox"><br/>
                                    <label for="sendstatus" class="faclable">Message :</label><textarea id="sendstatus"
                                                                                                        class="facetextarea"></textarea><br/>
                                    <button onClick="lrsendmessage();" class="facesend">Send</button>
                                </div>
                            <?php } ?>
                        </div>

                        <?php
                    } else {
                        LoginRadius_Redirect('index');
                    }
                } else {
                    LoginRadius_Redirect('index');
                }
            } else {
                LoginRadius_Redirect('index');
            }
            ?>
    </body>
</html>