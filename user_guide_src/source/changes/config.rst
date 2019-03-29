###############
Config Changes
###############

All changes inside the Aauth Config

.. contents::
    :local:
    :depth: 2

What's Added?
=============
  - $userActiveTime
  - $loginRememberCookie
  - $loginSingleMode
  - $loginAccurateErrors
  - $captchaType
  - $modules
  - $dbReturnType
  - $dbTableUserSessions
  - $dbTableGroupVariables
  - $dbSoftDeleteUsers
  - $dbSoftDeleteGroups
  - $dbSoftDeletePerms

What's Renamed?
===============
  - $no_permission => linkNoPermission
  - $reset_password_link => linkResetPassword
  - $verification_link => linkVerification

  - $verification => userVerification
  - $additional_valid_chars => userRegexPattern

  - $min => passwordMin
  - $max => passwordMax
  - $password_hash_algo => passwordHashAlgo
  - $password_hash_options => passwordHashOptions

  - $login_with_name => loginUseUsername
  - $remember => loginRemember
  - $ddos_protection => loginProtection
  - $max_login_attempt => loginAttemptLimit
  - $max_login_attempt_time_period => loginAttemptLimitTimePeriod
  - $remove_successful_attempts => loginAttemptRemoveSuccessful

  - $totp_active => totpEnabled
  - $totp_only_on_ip_change => totpOnIpChange
  - $totp_reset_over_reset_password => totpResetPassword
  - $totp_two_step_login => totpLoginDisabled
  - $totp_two_step_login_redirect => totpLink

  - $recaptcha_active => captchaEnabled
  - $recaptcha_login_attempts => captchaLoginAttempts
  - $recaptcha_siteKey => captchaSiteKey
  - $recaptcha_secret => captchaSecret

  - $email => emailFrom
  - $name => emailFromName
  - $email_config => emailConfig

  - $admin_group => groupAdmin
  - $default_group => groupDefault
  - $public_group => groupPublic

  - $db_profile => dbProfile
  - $users => dbTableUsers
  - $user_variables => dbTableUserVariables
  - $login_attempts => dbTableLoginAttempts
  - $groups => dbTableGroups
  - $user_to_group => dbTableGroupToUser (default changed to `aauth_group_to_user`)
  - $group_to_group => dbTableGroupToGroup
  - $perms => dbTablePerms
  - $perm_to_user => dbTablePermToUser
  - $perm_to_group => dbTablePermToGroup

What's Removed?
===============
  - $hash (old hash method removed)
  - $use_password_hash (old hash method removed)
  - $pm_encryption (pm function removed)
  - $pm_cleanup_max_age (pm function removed)
