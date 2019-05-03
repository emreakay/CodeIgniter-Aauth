###############
Library Changes
###############

All changes inside the Aauth Library

.. contents::
    :local:
    :depth: 2

What's Added?
=============
  - $session
  - $modules
  - $configApp
  - getActiveUsersCount()
  - listActiveUsers()
  - listUsersPaginated()
  - listGroupsPaginated()
  - listUserGroupsPaginated()
  - listPermsPaginated()
  - listGroupPermsPaginated()
  - listUserPerms()
  - listUserPermsPaginated()
  - setGroupVar()
  - unsetGroupVar()
  - getGroupVar()
  - listGroupVars()
  - getGroupVarKeys()
  - getModel()
  - __call()

What's Renamed?
===============

  - $config_vars => $config
  - $flash_errors => $flashErrors
  - $flash_infos => $flashInfos
  - $cache_perm_id => $cachePermIds
  - $cache_group_id => $cacheGroupIds

  - precache_perms => precachePerms
  - precache_groups => precacheGroups

  - login_fast() => loginFast()

  - is_loggedin() => isLoggedIn()
  - is_member() => isMember()
  - is_admin() => isAdmin()
  - is_allowed() => isAllowed()
  - is_group_allowed() => isGroupAllowed()

  - create_user() => createUser()
  - update_user() => updateUser()
  - delete_user() => deleteUser()
  - list_users() => listUsers()

  - get_user() => getUser()
  - get_user_id() => getUserId()
  - remind_password() => remindPassword()
  - reset_password() => resetPassword()
  - verify_user() => verifyUser()
  - send_verification() => sendVerification()

  - ban_user() => banUser()
  - unban_user() => unbanUser()
  - is_banned() => isBanned()

  - set_user_var() => setUserVar()
  - unset_user_var() => unsetUserVar()
  - get_user_var() => getUserVar()
  - get_user_vars() => listUserVars()
  - list_user_var_keys() => getUserVarKeys()

  - create_group() => createGroup()
  - update_group() => updateGroup()
  - delete_group() => deleteGroup()
  - add_member() => addMember()
  - remove_member() => removeMember()
  - get_user_groups() => getUserGroups()
  - get_user_perms() => getUserPerms()
  - add_subgroup() => addSubgroup()
  - remove_subgroup() => removeSubgroup()

  - get_subgroups() => getSubgroups()
  - remove_member_from_all() => removeMemberFromAll()
  - list_groups() => listGroups()
  - get_group_name() => getGroupName()
  - get_group_id() => getGroupId()
  - get_group() => getGroup()
  - get_group_perms() => getGroupPerms()
  - list_user_groups() => listUserGroups()

  - create_perm() => createPerm()
  - update_perm() => updatePerm()
  - delete_perm() => deletePerm()
  - allow_user() => allowUser()
  - deny_user() => denyUser()
  - allow_group() => allowGroup()
  - deny_group() => denyGroup()
  - list_perms() => listPerms()
  - get_perm_id() => getPermId()
  - get_perm() => getPerm()
  - list_group_perms() => listGroupPerms()

  - generate_recaptcha_field() => generateCaptchaHtml()

  - update_user_totp_secret() updateUserTotpSecret()
  - generate_unique_totp_secret() => generateUniqueTotpSecret()
  - generate_totp_qrcode() => generateTotpQrCode()
  - verify_user_totp_code() => verifyUserTotpCode()
  - is_totp_required() => isTotpRequired()

  - keep_errors() => keepErrors()
  - get_errors_array() => getErrorsArray()
  - print_errors() => printErrors()
  - clear_errors() => clearErrors()

  - keep_infos() => keepInfos()
  - get_infos_array() => getInfosArray()
  - print_infos() => printInfos()
  - clear_infos() => clearInfos()

What's Removed?
===============
  - $CI
  - $aauth_db (moved into Models)
  - get_login_attempts() (replaced with LoginAttemptModel)
  - update_login_attempts() (replaced with LoginAttemptModel)
  - reset_login_attempts() (replaced with LoginAttemptModel)
  - update_last_login() (replaced with UserModel)
  - update_activity() (replaced with UserModel)
  - hash_password() (moved into UserModel)
  - verify_password() (removed)
  - get_login_attempts() (replaced with LoginAttemptModel)
  - update_login_attempts() (replaced with LoginAttemptModel)
  - update_remember() (replaced with LoginTokenModel)
  - user_exist_by_username() (replaced with UserModel)
  - user_exist_by_name() (removed)
  - user_exist_by_email() (replaced with UserModel)
  - user_exist_by_id() (replaced with UserModel)
