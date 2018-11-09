# CHANGES

## LIBRARY

### ADDED
- $session


### RENAMED
- $config_vars => $config
- flash_errors => $flashErrors
- flash_infos => $flashInfos
- create_user => createUser
- update_user => updateUser
- delete_user => deleteUser
- list_users => listUsers
- keep_errors => keepErrors
- get_errors_array => getErrorsArray
- print_errors => printErrors
- clear_errors => clearErrors
- keep_infos => keepInfos
- get_infos_array => getInfosArray
- print_infos => printInfos
- clear_infos => clearInfos

### REMOVED
- $CI
- $aauth_db
- get_login_attempts (replaced with LoginAttemptModel)
- update_login_attempts (replaced with LoginAttemptModel)


## CONFIG

### RENAMED
- no_permission => linkNoPermission
- reset_password_link => linkResetPassword
- verification_link => linkVerification
- totp_two_step_login_redirect => linkTotp
- verification => userVerification
- additional_valid_chars => userAdditionalChars
- min => passwordMin
- max => passwordMax
- password_hash_algo => passwordHashAlgo
- password_hash_options => passwordHashOptions
- login_with_name => loginUseUsername
- remember => loginRemember
- ddos_protection => loginProtection
- max_login_attempt => loginAttemptLimit
- max_login_attempt_time_period => loginAttemptLimitTimePeriod
- remove_successful_attempts => loginAttemptRemoveSuccessful
- totp_active => totpEnabled
- totp_only_on_ip_change => totpOnIpChange
- totp_reset_over_reset_password => totpResetPassword
- totp_two_step_login => totpLoginDisabled
- recaptcha_active => recaptchaEnabled
- recaptcha_login_attempts => recaptchaLoginAttempts
- recaptcha_siteKey => recaptchaSiteKey
- recaptcha_secret => recaptchaSecret
- email => emailFrom
- name => emailFromName
- email_config => emailConfig
- admin_group => adminGroup
- default_group => defaultGroup
- public_group => publicGroup
- db_profile => dbProfile
- users => dbTableUsers
- user_variables => dbTableUserVariables
- login_attempts => dbTableLoginAttempts
- groups => dbTableGroups
- user_to_group => dbTableGroupToUser
- group_to_group => dbTableGroupToGroup
- perms => dbTablePerms
- perm_to_user => dbTablePermToUser
- perm_to_group => dbTablePermToGroup

### REMOVED
- hash
- use_password_hash
- pm_encryption
- pm_cleanup_max_age


## LANGUAGE

### ADDED
- invalidUserBanned

### CHANGED
- aauth_email_verification_subject => subjectVerification
- aauth_email_reset_subject => subjectReset
- aauth_email_reset_success_subject => subjectResetSuccess
- aauth_email_verification_text => textVerification
- aauth_email_reset_text => textReset
- aauth_email_reset_success_new_password => textResetSuccess
- aauth_error_no_access => notVerified
- aauth_error_account_not_verified => notVerified
- aauth_error_login_failed_email => loginFailedEmail
- aauth_error_login_failed_name => loginFailedName
- aauth_error_login_failed_all => loginFailedAll
- aauth_error_login_attempts_exceeded => loginAttemptsExceeded
- aauth_error_email_invalid => invalidEmail
- aauth_error_password_invalid => invalidPassword
- aauth_error_username_invalid => invalidUsername
- aauth_error_totp_code_invalid => invalidTOTPCode
- aauth_error_recaptcha_not_correct => invalidRecaptcha
- aauth_error_vercode_invalid => invalidVercode
- aauth_error_update_email_exists => existsAlreadyEmail
- aauth_error_update_username_exists => existsAlreadyUsername
- aauth_info_group_exists => existsAlreadyGroup
- aauth_info_perm_exists => existsAlreadyPerm
- aauth_error_username_required => requiredUsername
- aauth_error_totp_code_required => requiredTOTPCode
- aauth_error_no_user => notFoundUser
- aauth_error_no_group => notFoundGroup
- aauth_error_no_subgroup => notFoundSubgroup
- aauth_info_already_member => alreadyMemberGroup
- aauth_info_already_subgroup => alreadyMemberSubgroup

### REMOVED
- aauth_error_self_pm
- aauth_error_no_pm
- aauth_email_verification_code (merged with textVerification)
- aauth_error_email_exists
- aauth_error_username_exists
