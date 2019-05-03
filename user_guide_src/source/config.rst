######
Config
######

All changes inside the Aauth Config

.. contents::
    :local:

Link Variables
==============
``$linkNoPermission``

If user don't have permission to see the page he will be redirected
the page specified.

Available Options:
    - false (control() returns booleans)
    - 'error' (control() throws an error)
    - any uri/url string (control() redirect to set value)

.. note:: Default value: false


``$linkResetPassword``

Link for reset_password without site_url or base_url
.. note:: Default value: '/account/reset_password/index'


``$linkVerification``

Link for verification without site_url or base_url
.. note:: Default value: '/account/verification/index'


User Variables
==============
``$userActiveTime``

User Active Time, time range for session time checkup
.. note:: Default value: '5 minutes'

``$userVerification``

User Verification, if TRUE sends a verification email on account creation
.. note:: Default value: false

``$userRegexPattern``

Regex pattern for valid chars for username
.. note:: Default value: '^[a-zA-Z0-9]{3,}$'



Password Variables
==================
``$passwordMin``

Password min char length
.. note:: Default value: 8

``$passwordMax``

Password max char length
.. note:: Default value: 32

``$passwordHashAlgo``

password_hash algorithm (PASSWORD_DEFAULT, PASSWORD_BCRYPT)
for details see http://php.net/manual/de/password.constants.php
.. note:: Default value: PASSWORD_DEFAULT

``$passwordHashOptions``

password_hash options array
for details see http://php.net/manual/en/function.password-hash.php
.. note:: Default value: []


Login Variables
===============
``$loginRemember``

Remember time (in relative format) elapsed after connecting and automatic
logout for usage with cookies.
Relative format (e.g. '+ 1 week', '+ 1 month') for details see
http://php.net/manual/de/datetime.formats.relative.php
.. note:: Default value: '+14 days'

``$loginRememberCookie``

Remember cookie name.
.. note:: Default value: 'remember'

``$loginSingleMode``

Login Single Mode, if true only one session per user can be active.
.. note:: Default value: false

``$loginUseUsername``

Login Identificator, if TRUE username needed to login else email address
.. note:: Default value: false

``$loginAccurateErrors``

Enables unified error message (loginFailedAll vs loginFailedEmail/loginFailedUsername)
.. note:: Default value: false

``$loginProtection``

Enables the DDoS Protection, user will be banned temporary when he exceed the login 'try'
.. note:: Default value: true

``$loginAttemptCookie``

Login attempts count & block trough Cookie instead of Login Attempt DB & IP
You can set a string to set the cookie name, default cookie name is logins.
.. note:: Default value: false

``$loginAttemptLimit``

Login attempts limit
.. note:: Default value: 10

``$loginAttemptLimitTimePeriod``

Period of time for max login attempts
.. note:: Default value: '5 minutes'

``$loginAttemptRemoveSuccessful``

Enables removing login attempt after successful login
.. note:: Default value: true


Email Variables
===============
``$emailFrom``

Sender email address, used for remind_password, send_verification and
reset_password
.. note:: Default value: 'admin@example.com'

``$emailFromName``

Sender name, used for remind_password, send_verification and
reset_password
.. note:: Default value: 'Aauth v3'

``$emailConfig``

Array of Config for CI's Email Library
.. note:: Default value: []


Time-based One-time Password Algorithm Variables
================================================
``$totpEnabled``

Enables the Time-based One-time Password Algorithm
.. note:: Default value: false

``$totpOnIpChange``

TOTP only on IP Change
.. note:: Default value: false

``$totpResetPassword``

Reset TOTP secret on reset_password()
.. note:: Default value: false

``$totpLogin``

TOTP required if uses has TOTP secret on login()
.. note:: Default value: false

``$totpLink``

Redirect path to TOTP Verification page
.. note:: Default value: '/account/twofactor_verification/index'


CAPTCHA Variables
=================
``$captchaEnabled``

Enables CAPTCHA
.. note:: Default value: false

``$captchaType``

CAPTCHA Types

Available Options:
- 'recaptcha' (for details see https://www.google.com/captcha/admin)
- 'hcaptcha' (for details see https://hcaptcha.com/docs)
.. note:: Default value: 'recaptcha'

``$captchaLoginAttempts``

Login Attempts to display CAPTCHA
.. note:: Default value: 6

``$captchaSiteKey``

The CAPTCHA siteKey
.. note:: Default value: ''

``$captchaSecret``

The CAPTCHA secretKey
.. note:: Default value: ''


Group Variables
===============
``$groupAdmin``

Name of admin group
.. note:: Default value: 'admin'

``$groupDefault``

Name of default group, the new user is added in it
.. note:: Default value: 'default'

``$groupPublic``

Name of Public group , people who not logged in
.. note:: Default value: 'public'


Modules Variables
=================
``$modules``

Array of active modules
.. note:: Default value: []


Database Variables
==================
``$dbProfile``

The configuration database profile (defined in Config/Database.php)
.. note:: Default value: 'default'

``$dbReturnType``

The format that the results should be returned as, for any get* &
list* function. (e.g. getUser, listUsers, ...).
Available types:
- array
- object
.. note:: Default value: 'array'

``$dbTableUsers``

The table which contains users
.. note:: Default value: 'aauth_users'

``$dbTableUserSessions``

The table which contains user sessions
.. note:: Default value: 'aauth_user_sessions'

``$dbTableUserVariables``

The table which contains users variables
.. note:: Default value: 'aauth_user_variables'

``$dbTableLoginAttempts``

The table which contains login attempts
.. note:: Default value: 'aauth_login_attempts'

``$dbTableLoginTokens``

The table which contains login tokens
.. note:: Default value: 'aauth_login_tokens'

``$dbTableGroups``

The table which contains groups
.. note:: Default value: 'aauth_groups'

``$dbTableGroupToUser``

The table which contains join of users and groups
.. note:: Default value: 'aauth_group_to_user'

``$dbTableGroupToGroup``

The table which contains join of subgroups and groups
.. note:: Default value: 'aauth_group_to_group'

``$dbTableGroupVariables``

The table which contains group variables
.. note:: Default value: 'aauth_group_variables'

``$dbTablePerms``

The table which contains permissions
.. note:: Default value: 'aauth_perms'

``$dbTablePermToUser``

The table which contains permissions for users
.. note:: Default value: 'aauth_perm_to_user'

``$dbTablePermToGroup``

The table which contains permissions for groups
.. note:: Default value: 'aauth_perm_to_group'

``$dbSoftDeleteUsers``

Enables soft delete for Users
If this is enabled, it simply set a flag when rows are deleted.
.. note:: Default value: false

``$dbSoftDeleteGroups``

Enables soft delete for Groups
If this is enabled, it simply set a flag when rows are deleted.
.. note:: Default value: false

``$dbSoftDeletePerms``

Enables soft delete for Perms
If this is enabled, it simply set a flag when rows are deleted.
.. note:: Default value: false
