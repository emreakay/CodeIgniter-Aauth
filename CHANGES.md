# NAME CHANGES

## LIBRARY

### ADDED
  - $session

### RENAMED
  - $config_vars => $config
  - $flash_errors => $flashErrors
  - $flash_infos => $flashInfos
  - $cache_perm_id => $cachePermIds
  - $cache_group_id => $cacheGroupIds
  - create_user => createUser
  - update_user => updateUser
  - delete_user => deleteUser
  - list_users => listUsers
  - get_user => getUser
  - send_verification => sendVerification
  - login_fast => loginFast
  - is_loggedin => isLoggedIn
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
  - $aauth_db (moved into Models)
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
  - user_to_group => dbTableGroupToUser (default changed to `aauth_group_to_user`)
  - group_to_group => dbTableGroupToGroup
  - perms => dbTablePerms
  - perm_to_user => dbTablePermToUser
  - perm_to_group => dbTablePermToGroup

### REMOVED
  - hash (old hash method removed)
  - use_password_hash (old hash method removed)
  - pm_encryption (pm function removed)
  - pm_cleanup_max_age (pm function removed)


## DATABASE

### USERS
  - renamed `pass` to `password`
  - renamed `ip_address` to `last_ip_address`
  - renamed `date_created` to  `created_at`
  - added `updated_at` 'DATETIME'
  - added `deleted` 'TINYINT(1)'
  - removed `forgot_exp` (unused)
  - removed `remember_time` (moved to Login Token)
  - removed `remember_exp` (moved to Login Token)
  - removed `verification_code` (moved to User System Variable)
  - removed `totp_secret` (moved to User System Variable)

### USER VARIABLES
  - renamed `value` to `data_value`
  - added `created_at` 'DATETIME'
  - added `updated_at` 'DATETIME'
  - added `system` 'TINYINT(1)'

### LOGIN ATTEMPTS
  - added `id` 'INT(11)' PKey A_I
  - added `ip_address` 'VARCHAR(39)'
  - added `count` 'TINYINT(2)'
  - added `created_at` 'DATETIME'
  - added `updated_at` 'DATETIME'

### LOGIN TOKEN
  - added `id` 'INT(11)' PKey A_I
  - added `user_id` 'INT(11)'
  - added `random_hash` 'VARCHAR(255)'
  - added `selector_hash` 'VARCHAR(255)'
  - added `created_at` 'DATETIME'
  - added `updated_at` 'DATETIME'
  - added `expires_at` 'DATETIME'

### GROUPS
  - added `created_at` 'DATETIME'
  - added `updated_at` 'DATETIME'

### PERMS
  - added `created_at` 'DATETIME'
  - added `updated_at` 'DATETIME'

### PMS
  - completly removed


## LANGUAGE

### ADDED
  - invalidUserBanned
  - requiredGroupName
  - requiredPermName

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
  - aauth_error_login_failed_name => loginFailedUsername
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


## VIEWS

### TEMPLATES
  - Footer
    - Layout with Sidebar closing
    - Used JS Libs
      - jquery
      - jquery-easing
      - bootstrap 4.1.3
      - sb-admin
      - customer load over $jsFiles
  - FooterBlank
    - Layout without Sidebar
    - Used JS Libs
      - jquery
      - jquery-easing
      - bootstrap 4.1.3
      - sb-admin
      - customer load over $jsFiles
  - Header
    - Layout with Sidebar start
    - Used CSS Libs
      - bootstrap 4.1.3
      - fontawesome-free
      - sb-admin
      - customer load over $cssFiles
  - HeaderBlank
    - Layout without Sidebar
    - Used CSS Libs
      - bootstrap 4.1.3
      - sb-admin
      - customer load over $cssFiles


### AAUTH
  - Verification
  - ResetPassword
  - RemindPassword


### ACCOUNT
  - login
  - register
  - logout
