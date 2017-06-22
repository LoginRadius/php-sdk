<?php

define('API_KEY' , '');
define('API_SECRET' , '');
define('TOKEN', '');
define('ACCESS_TOKEN' , '');
define('SFAT' , '');
define('UID' , '');

/*Authentication api settings*/

define('EMAIL', '');
define('CURRENT_PASSWORD', '');
define('NEW_PASSWORD', '');
define('USERNAME', '');
define('PHONE_ID', '');
define('User_Profile_object' , '{
   "Email":[
      {
         "Type":"Primary",
         "Value":"ytehgh@mailinator.com"
      }
   ],
   "Password":"123456",
   "FirstName":"ytehgh" 

}');
define('UPDATE_PHONENO' , '{   
   "phoneNo2FA":"+918824516274" 

}');
define('Update_User_Profile_object' , '{
  "Prefix": "Hellofsda",
  "FirstName": "example123",
  "MiddleName": "test",
  "LastName": "Login",
  "Suffix": "Byee",
  "UserName":"unittest",
  "FullName": "Test Loginh"}');
define('RESET_PASSWORD_URL', 'http://example.com/resetpasswordpage');
define('V_TOKEN' , '0864599092fe46fcb03b6015dfeaad05');
define('ADD_EMAIL', 'unittest123@sthus.com');
define('ADD_EMAIL_TYPE', 'secondary');
define('VERIFICATION_EMAIL_PAGE', 'http://example.com/verifyemailpage');
define('CHANGE_USERNAME', 'unittest123');
define('CANDIDATE_TOKEN', '945e28e7-bd34-42c0-984d-b318779ed8e0');
define('PROVIDER_ID', '');
define('PROVIDER', 'Twitter');
define('UPDATE_PHONE_ID','');
define('OTP','N1889E');
define('OBJECT_NAME', '');
define('CUSTOM_OBJECT_JSON', '{
  "Prefix": "Hello",
  "FirstName": "example",
  "MiddleName": "test"}');
define('OBJECT_RECORD_ID', '57d953c626729705f0785764');
define('UPDATE_CUSTOM_OBJECT_JSON', '{
  "Prefix": "change",
  "FirstName": "lastname",
  "MiddleName": "newname"}');

/*Role api settings*/
define('CREATE_ROLE', '{
    "Roles":[
    {
    "Name":"Test123dddd",
    "Permissions": {
        "dd":true,
        "rrr":true,
        "666666":true
    }
    }]
    }');
define('ROLE_NAME', 'Test123dddd');
define('ROLE_PERMISSIONS', '{
  "Permissions":["dddd","kkkk"]
}');
define('ASSIGN_ROLES', '{
   "roles":["Test123"]
}');

/*Rest hook api settings*/
define('FROM_TABLE', 'users');
define('FROM_DATE', '10/30/1995');
define('TO_DATE', '09/06/2016');
define('FIRST_DATA_POINT', 'provider');
define('STATS_TYPE', 'Login');
define('TARGET_URL', 'http://google.com/');
define('EVENT', 'Register');

/*Other api settings*/
define('ALBUM_ID', '');
define('PAGE_NAME', 'LoginRadius');
define('TO_MESSAGE','1079112984');
define('SUBJECT_MESSAGE', 'Testing Purpose');
define('SEND_MESSAGE', 'Keep it up!!');
define('ACCOUNT_ID','54a1d548d0ea44338aaaebf93bab501f');
define('TW_ACCESS_TOKEN','1079112984-3Jv3zuh1YxV8lUaCGGwxYQ97T66XOrZ2BtMMiTh');
define('TW_TOKEN_SECRET','2GS8C8iBGNOMP2Q0NxhrquR1Z0wUMQOVGCfIxCVBNTNn5');
define('FB_ACCESS_TOKEN' , 'EAANHHulwJfMBAL564pK9osYcoYMR0z2nHji7u3snsUg5eitZCzFNCxisYehLZCWh5n8L2HRNMkfEnx06vGAadyHbYvW2v5g7YlosO1lF8m8DoXy1WFm0xnxbpZBNWVg1uZCTR9UIW564UVqlgWTZA3EkYj5ssVqUZD');
define('POST_ID' , '');
define('POST_STATUS', 'Test');