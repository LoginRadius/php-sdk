<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;

final class AuthenticationTest extends TestCase {
  private static $accountApi;
  private static $userApi;

  private $testerUid;
  private $testerEmail;
  private $testerUsername;
  private $testerPhoneId;
  private $testerAccessToken;

  public static function setUpBeforeClass() {
    self::$accountApi = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    self::$userApi = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
  }

  public function setUp() {
    $data = '{
      "Email": [
        {
          "Type": "Primary",
          "Value": "phpunittester96@mailinator.com"
        },
        {
          "Type": "Secondary",
          "Value": "phpunittester96secondary2@mailinator.com"
        }
      ],
      "UserName": "put96",
      "PhoneId": "12016768877",
      "Password": "password",
      "EmailVerified": true
    }';
    $resultCreate = self::$accountApi->create($data);
    $this->testerUid = $resultCreate->Uid;
    $this->testerEmail = $resultCreate->Email[0]->Value;
    $this->testerUsername = $resultCreate->UserName;
    $this->testerPhoneId = $resultCreate->PhoneId;

    $loginData = '{
      "email": "phpunittester96@mailinator.com",
      "password": "password"
    }';
    $resultLogin = self::$userApi->authLoginByEmail($loginData);
    $this->testerAccessToken = $resultLogin->access_token;
  }

  public function tearDown() {
    self::$accountApi->delete($this->testerUid);
  }

  public function testAuthAddEmail() {
    $result = self::$userApi->addEmail($this->testerAccessToken, "phpunittester96secondary@mailinator.com", "Secondary");
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthForgotPassword() {
    $result = self::$userApi->forgotPassword($this->testerEmail, "www.example.com");
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthUserRegistrationByEmail() {
    $registrationData = '{
      "Email": [
        {
          "Type": "Primary",
          "Value": "phpunittester95@mailinator.com"
        }
      ],
      "Password": "password"
    }';
    $result = self::$userApi->registerByEmail($registrationData);
    $this->assertObjectHasAttribute("IsPosted", $result);

    $uid = self::$accountApi->getProfileByEmail("phpunittester95@mailinator.com")->Uid;
    self::$accountApi->delete($uid);
  }

  public function testAuthLoginByEmail() {
    $this->assertNotNull($this->testerAccessToken);
  }

  public function testAuthLoginByUsername() {
    $data = '{
      "UserName": "' . $this->testerUsername . '",
      "Password": "password"
    }';
    $result = self::$userApi->authLoginByUsername($data);
    $this->assertObjectHasAttribute("access_token", $result);
  }

  public function testAuthCheckEmailAvailability() {
    $result = self::$userApi->checkAvailablityOfEmail("phpunittester96@mailinator.com");
    $this->assertObjectHasAttribute("IsExist", $result);
  }

  public function testAuthCheckUsernameAvailability() {
    $result = self::$userApi->checkUsername("put96");
    $this->assertObjectHasAttribute("IsExist", $result);
  }

  public function testAuthReadProfileByToken() {
    $result = self::$userApi->getProfile($this->testerAccessToken);
    $this->assertObjectHasAttribute("Uid", $result);
  }

  public function testAuthPrivacyPolicyAccept() {
    try {
      $result = self::$userApi->privacyPolicyAccept($this->testerAccessToken);
      $this->assertObjectHasAttribute("Uid", $result);
    } catch (Exception $e) {
      $this->assertEquals($e->getMessage(), "Privacy policy is not available");
    }
  }

  public function testAuthSendWelcomeEmail() {
    $result = self::$userApi->sendWelcomeEmail($this->testerAccessToken);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthSocialIdentity() {
    $result = self::$userApi->getSocialProfile($this->testerAccessToken);
    $this->assertObjectHasAttribute("Uid", $result);
  }

  public function testAuthValidateAccessToken() {
    $result = self::$userApi->checkTokenValidity($this->testerAccessToken);
    $this->assertObjectHasAttribute("access_token", $result);
  }

  public function testAuthVerifyEmail() {
    $updateData = '{
      "EmailVerified": false
    }';
    self::$accountApi->update($this->testerUid, $updateData);
    $vtoken = self::$accountApi->getEmailVerificationToken($this->testerEmail)->VerificationToken;
    $result = self::$userApi->verifyEmail($vtoken);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthVerifyEmailByOtp() {
    $data = '{
      "otp": "99999",
      "email": "' . $this->testerEmail . '"
    }';
    try {
      $result = self::$userApi->verifyEmailByOtp($data);
      $this->assertObjectHasAttribute("IsPosted", $result);
    } catch (Exception $e) {
      $this->assertEquals($e->getMessage(), "Invalid email verification OTP");
    }
  }

  public function testAuthDeleteAccount() {
    try {
      $result = self::$userApi->deleteAccount("99999999999");
      $this->assertObjectHasAttribute("IsPosted", $result);
    } catch (Exception $e) {
      $this->assertEquals($e->getMessage(), "The LoginRadius DeleteToken is invalid");
    }
  }

  public function testAuthAccessTokenInvalidate() {
    $result = self::$userApi->invalidateTokenByAccessToken($this->testerAccessToken);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthSecurityQuestionsByAccessToken() {
    if (SECURITY_QUESTION_ID !== "") {
      $sq_data = '{
        "securityquestionanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        }
      }';
      self::$userApi->updateSecurityQuestionByAccessToken($this->testerAccessToken, $sq_data);
      $result = self::$userApi->getSecurityQuestionsByAccessToken($this->testerAccessToken);
      $this->assertObjectHasAttribute("QuestionId", $result[0]);
    } else {
      $this->markTestSkipped("Security Question ID in config.php needs to be defined.");
    }
  }

  public function testAuthSecurityQuestionsByEmail() {
    if (SECURITY_QUESTION_ID !== "") {
      $sq_data = '{
        "securityquestionanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        }
      }';
      self::$userApi->updateSecurityQuestionByAccessToken($this->testerAccessToken, $sq_data);
      $result = self::$userApi->getSecurityQuestionsByEmail($this->testerEmail);
      $this->assertObjectHasAttribute("QuestionId", $result[0]);
    } else {
      $this->markTestSkipped("Security Question ID in config.php needs to be defined.");
    }
  }

  public function testAuthSecurityQuestionsByUsername() {
    if (SECURITY_QUESTION_ID !== "") {
      $sq_data = '{
        "securityquestionanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        }
      }';
      self::$userApi->updateSecurityQuestionByAccessToken($this->testerAccessToken, $sq_data);
      $result = self::$userApi->getSecurityQuestionsByUserName($this->testerUsername);
      $this->assertObjectHasAttribute("QuestionId", $result[0]);
    } else {
      $this->markTestSkipped("Security Question ID in config.php needs to be defined.");
    }
  }

  public function testAuthSecurityQuestionsByPhone() {
    if (SECURITY_QUESTION_ID !== "") {
      $sq_data = '{
        "securityquestionanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        }
      }';
      self::$userApi->updateSecurityQuestionByAccessToken($this->testerAccessToken, $sq_data);
      $result = self::$userApi->getSecurityQuestionsByPhone($this->testerPhoneId);
      $this->assertObjectHasAttribute("QuestionId", $result[0]);
    } else {
      $this->markTestSkipped("Security Question ID in config.php needs to be defined.");
    }
  }

  public function testAuthChangePassword() {
    $result = self::$userApi->changeAccountPassword($this->testerAccessToken, "password", "passwords");
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthResendEmailVerification() {
    $updateData = '{
      "EmailVerified": false
    }';
    self::$accountApi->update($this->testerUid, $updateData);
    $result = self::$userApi->resendEmailVerification($this->testerEmail);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthResetPasswordByResetToken() {
    $resetToken = self::$accountApi->getForgotPasswordToken($this->testerEmail)->ForgotToken;
    $result = self::$userApi->resetPassword($resetToken, "password1");
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthResetPasswordByOtp() {
    try {
      $result = self::$userApi->resetPasswordByOtp("password1", "99999", $this->testerEmail);
      $this->assertObjectHasAttribute("IsPosted", $result);
    } catch (Exception $e) {
      $this->assertEquals("Verification OTP is invalid", $e->getMessage());
    }
  }

  public function testAuthResetPasswordBySecurityAnswerAndEmail() {
    if (SECURITY_QUESTION_ID === "") {
      $this->markTestSkipped("Security Question ID in config.php needs to be defined.");
    } else {
      $sq_data = '{
        "securityquestionanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        }
      }';
      self::$userApi->updateSecurityQuestionByAccessToken($this->testerAccessToken, $sq_data);

      $data = '{
        "securityanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        },
        "email": "' . $this->testerEmail . '",
        "password": "password1"
      }';
      $result = self::$userApi->authResetPasswordBySecurityAnswerAndEmail($data);
      $this->assertObjectHasAttribute("IsPosted", $result);
    }
  }

  public function testAuthResetPasswordBySecurityAnswerAndPhone() {
    if (SECURITY_QUESTION_ID === "") {
      $this->markTestSkipped("Security Question ID in config.php needs to be defined.");
    } else {
      $sq_data = '{
        "securityquestionanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        }
      }';
      self::$userApi->updateSecurityQuestionByAccessToken($this->testerAccessToken, $sq_data);

      $data = '{
        "securityanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        },
        "phone": "' . $this->testerPhoneId . '",
        "password": "password1"
      }';
      $result = self::$userApi->authResetPasswordBySecurityAnswerAndPhone($data);
      $this->assertObjectHasAttribute("IsPosted", $result);
    }
  }

  public function testAuthResetPasswordBySecurityAnswerAndUserName() {
    if (SECURITY_QUESTION_ID === "") {
      $this->markTestSkipped("Security Question ID in config.php needs to be defined.");
    } else {
      $sq_data = '{
        "securityquestionanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        }
      }';
      self::$userApi->updateSecurityQuestionByAccessToken($this->testerAccessToken, $sq_data);

      $data = '{
        "securityanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        },
        "username": "' . $this->testerUsername . '",
        "password": "password1"
      }';
      $result = self::$userApi->authResetPasswordBySecurityAnswerAndUserName($data);
      $this->assertObjectHasAttribute("IsPosted", $result);
    }
  }

  public function testAuthSetOrChangeUserName() {
    $result = self::$userApi->changeUsername($this->testerAccessToken, "putester96");
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthUpdateProfileByToken() {
    $data = '{
      "Gender": "M"
    }';
    $result = self::$userApi->updateProfile($this->testerAccessToken, $data);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAuthUpdateSecurityQuestionByAccessToken() {
    if (SECURITY_QUESTION_ID === "") {
      $this->markTestSkipped("Security Question ID in config.php needs to be defined.");
    } else {
      $sq_data = '{
        "securityquestionanswer": {
          "' . SECURITY_QUESTION_ID . '": "answer"
        }
      }';
      $result = self::$userApi->updateSecurityQuestionByAccessToken($this->testerAccessToken, $sq_data);
      $this->assertObjectHasAttribute("IsPosted", $result);
    }
  }

  public function testAuthDeleteAccountWithEmailConfirmation() {
    $result = self::$userApi->deleteAccountByEmailConfirmation($this->testerAccessToken);
    $this->assertObjectHasAttribute("IsDeleteRequestAccepted", $result);
  }

  public function testAuthRemoveEmail() {
    $result = self::$userApi->removeEmail($this->testerAccessToken, $this->testerEmail);
    $this->assertObjectHasAttribute("IsDeleted", $result);
  }

  public function testAuthLinkUnlinkSocialIdentities() {
    if (SOCIAL_LOGIN_REQUEST_TOKEN === "") {
      $this->markTestSkipped("Social Login Request Token in config.php needs to be defined.");
    } else {
      $linkResult = self::$userApi->accountLink($this->testerAccessToken, SOCIAL_LOGIN_REQUEST_TOKEN);
      $this->assertObjectHasAttribute("IsPosted", $linkResult);

      $testerProfile = self::$accountApi->getProfileByEmail($this->testerEmail);
      $accountProvider = $testerProfile->Identities[0]->Provider;
      $accountProviderId = $testerProfile->Identities[0]->ID;

      $unlinkResult = self::$userApi->accountUnlink($this->testerAccessToken, $accountProviderId, $accountProvider);
      $this->assertObjectHasAttribute("IsDeleted", $unlinkResult);
    }
  }
}
