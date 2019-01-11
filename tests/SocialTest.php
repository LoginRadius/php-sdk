<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Social\AdvanceSocialLoginAPI;
use LoginRadiusSDK\CustomerRegistration\Social\SocialLoginAPI;

final class SocialTest extends TestCase {
  private static $advancedSocialApi;
  private static $socialApi;

  public static function setUpBeforeClass() {
    self::$advancedSocialApi = new AdvanceSocialLoginAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    self::$socialApi = new SocialLoginAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
  }

  public function testPostMessage() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$socialApi->sendMessage($accessTokenFromTwitter, "991413461560131585", "Test Message", "This is a test message.");
      $this->assertObjectHasAttribute("isPosted", $result);
    }
  }

  public function testStatusPostingPost() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$socialApi->postStatus($accessTokenFromTwitter, "Test Post", "www.test.com", "www.test.com", "This is a test post. -" . rand(), "A post.", "A post.");
      $this->assertObjectHasAttribute("isPosted", $result);
    }
  }

  public function testAccessTokenTranslate() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$socialApi->exchangeAccessToken($accessTokenFromTwitter);
      $this->assertObjectHasAttribute("access_token", $result);
    }
  }

  public function testAccessTokenValidate() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$socialApi->tokenValidate($accessTokenFromTwitter);
      $this->assertObjectHasAttribute("access_token", $result);
    }
  }

  public function testAccessTokenInvalidate() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$socialApi->tokenInvalidate($accessTokenFromTwitter);
      $this->assertObjectHasAttribute("isPosted", $result);
    }
  }

  public function testGetAlbum() {
    // Using Facebook
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $fbAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $accessTokenFromFacebook = $fbAccessTokenResult->access_token;
      $result = self::$socialApi->getPhotoAlbums($accessTokenFromFacebook);
      $this->assertNotNull($result);
    }
  }

  public function testGetAudio() {
    // Using Vkontakte
    if (VKONTAKTE_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Vkontakte Access Token in config.php needs to be defined.");
    } else {
      $this->markTestIncomplete();
    }
  }

  public function testGetCheckIns() {
    // Using Facebook
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $fbAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $accessTokenFromFacebook = $fbAccessTokenResult->access_token;
      $result = self::$socialApi->getCheckins($accessTokenFromFacebook);
      $this->assertNotNull($result);
    }
  }

  public function testGetCompanies() {
    // Using Facebook
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $fbAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $accessTokenFromFacebook = $fbAccessTokenResult->access_token;
      $result = self::$socialApi->getFollowedCompanies($accessTokenFromFacebook);
      $this->assertNotNull($result);
    }
  }

  public function testGetContacts() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$socialApi->getContacts($accessTokenFromTwitter);
      $this->assertNotNull($result);
    }
  }

  public function testGetEvents() {
    // Using Facebook
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $fbAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $accessTokenFromFacebook = $fbAccessTokenResult->access_token;
      $result = self::$socialApi->getEvents($accessTokenFromFacebook);
      $this->assertNotNull($result);
    }
  }

  public function testGetFollowing() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$socialApi->getFollowing($accessTokenFromTwitter);
      $this->assertNotNull($result);
    }
  }

  public function testGetGroups() {
    // Using Facebook
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $fbAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $accessTokenFromFacebook = $fbAccessTokenResult->access_token;
      $result = self::$socialApi->getGroups($accessTokenFromFacebook);
      $this->assertNotNull($result);
    }
  }

  public function testGetLikes() {
    // Using Facebook
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $fbAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $accessTokenFromFacebook = $fbAccessTokenResult->access_token;
      $result = self::$socialApi->getLikes($accessTokenFromFacebook);
      $this->assertNotNull($result);
    }
  }

  public function testGetMentions() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$socialApi->getMentions($accessTokenFromTwitter);
      $this->assertNotNull($result);
    }
  }

  public function testGetMessage() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$advancedSocialApi->postMessage($accessTokenFromTwitter, "991413461560131585", "Test Message", "This is a test message.");
      $this->assertObjectHasAttribute("isPosted", $result);
    }
  }

  public function testGetPages() {
    // Using Facebook
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $fbAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $accessTokenFromFacebook = $fbAccessTokenResult->access_token;
      $result = self::$socialApi->getPages($accessTokenFromFacebook, "loginradius");
      $this->assertNotNull($result);
    }
  }

  public function testGetPhotos() {
    // Using Vkontakte
    if (VKONTAKTE_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Vkontakte Access Token in config.php needs to be defined.");
    } else {
      $this->markTestIncomplete();
    }
  }

  public function testGetPosts() {
    // Using Facebook
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $fbAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $accessTokenFromFacebook = $fbAccessTokenResult->access_token;
      $result = self::$socialApi->getPosts($accessTokenFromFacebook);
      $this->assertNotNull($result);
    }
  }

  public function testStatusFetching() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$socialApi->getStatus($accessTokenFromTwitter);
      $this->assertNotNull($result);
    }
  }

  public function testStatusPostingGet() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$advancedSocialApi->postStatus($accessTokenFromTwitter, "This is a test post. -" . rand(), "Test Post", "www.test.com", "www.test.com", "A post.", "A post.");
      $this->assertObjectHasAttribute("isPosted", $result);
    }
  }

  public function testGetUserProfile() {
    // Using Twitter
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $twitterAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $accessTokenFromTwitter = $twitterAccessTokenResult->access_token;
      $result = self::$advancedSocialApi->refreshUserProfile($accessTokenFromTwitter);
      $this->assertObjectHasAttribute("Uid", $result);
    }
  }

  public function testGetVideos() {
    // Using Facebook
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $fbAccessTokenResult = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $accessTokenFromFacebook = $fbAccessTokenResult->access_token;
      $result = self::$socialApi->getVideos($accessTokenFromFacebook);
      $this->assertNotNull($result);
    }
  }
}
