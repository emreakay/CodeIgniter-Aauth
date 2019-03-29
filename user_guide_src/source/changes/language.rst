################
Language Changes
################

All changes inside the Aauth Language

.. contents::
    :local:
    :depth: 2

What's Added?
=============
  - invalidUserBanned
  - requiredGroupName
  - requiredPermName
  - infoCreateSuccess
  - infoCreateVerification
  - infoUpdateSuccess
  - infoRemindSuccess
  - infoResetSuccess
  - infoVerification

What's Renamed?
===============
  - aauth_email_verification_subject => subjectVerification
  - aauth_email_reset_subject => subjectReset
  - aauth_email_reset_success_subject => subjectResetSuccess
  - aauth_email_verification_text => textVerification
  - aauth_email_reset_text => textReset
  - aauth_email_reset_success_new_password => textResetSuccess
  - aauth_error_no_access => noAccess
  - aauth_error_account_not_verified => notVerified
  - aauth_error_login_failed_email => loginFailedEmail
  - aauth_error_login_failed_name => loginFailedUsername
  - aauth_error_login_failed_all => loginFailedAll
  - aauth_error_login_attempts_exceeded => loginAttemptsExceeded
  - aauth_error_email_invalid => invalidEmail
  - aauth_error_password_invalid => invalidPassword
  - aauth_error_username_invalid => invalidUsername
  - aauth_error_recaptcha_not_correct => invalidCaptcha
  - aauth_error_vercode_invalid => invalidVerficationCode
  - aauth_error_totp_code_required => requiredTOTPCode
  - aauth_error_totp_code_invalid => invalidTOTPCode
  - aauth_error_update_email_exists => existsAlreadyEmail
  - aauth_error_update_username_exists => existsAlreadyUsername
  - aauth_info_group_exists => existsAlreadyGroup
  - aauth_info_perm_exists => existsAlreadyPerm
  - aauth_error_username_required => requiredUsername
  - aauth_error_no_user => notFoundUser
  - aauth_error_no_group => notFoundGroup
  - aauth_error_no_subgroup => notFoundSubgroup
  - aauth_info_already_member => alreadyMemberGroup
  - aauth_info_already_subgroup => alreadyMemberSubgroup

What's Removed?
===============
  - aauth_error_self_pm
  - aauth_error_no_pm
  - aauth_email_verification_code (merged with textVerification)
  - aauth_error_email_exists
  - aauth_error_username_exists
