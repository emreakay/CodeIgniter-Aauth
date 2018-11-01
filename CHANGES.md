# CHANGES

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
