#################
Library Reference
#################

***************
Class Reference
***************


.. php:class:: Aauth

    .. php:method:: login(string $identifier, string $password[, bool $remember = null[, string $totpCode = null]])

        Check provided details against the database. Add items to error array on fail

        :param  string  $identifier: Identifier
        :param  string  $password: Password
        :param  boolean  $remember: Whether to remember login
        :param  string  $totpCode: TOTP Code
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: logout()

        Deletes session and cookie

        :rtype: void

    .. php:method:: isLoggedIn()

        Checks if user logged in, also checks remember.

        :returns: TRUE if user is logged in, FALSE if user is not logged in
        :rtype: boolean

    .. php:method:: isMember($groupPar[, int $userId = null])

        Checks if user is member of a group

        :param  string|integer  $groupPar: Group name or id
        :param  integer  $userId: User id
        :returns: TRUE if user is a member, FALSE if user is not a member
        :rtype: boolean

    .. php:method:: isAdmin([int $userId = null])

        Checks if user is a admin

        :param  integer  $userId: User id
        :returns: TRUE if user is a admin, FALSE if user is not a admin
        :rtype: boolean

    .. php:method:: isAllowed($permPar[, int $userId = null])

        Check if user allowed to do specified action, admin always allowed
        first checks user permissions then check group permissions

        :param  string|integer  $permPar: Perm name or id
        :param  integer  $userId: User id
        :returns: TRUE if allowed, FALSE if denied
        :rtype: boolean

    .. php:method:: isGroupAllowed($permPar[, $groupPar = null])

        Check if group is allowed to do specified action, admin always allowed

        :param  string|integer  $permPar: Perm name or id
        :param  string|integer  $groupPar: Group name or id
        :returns: TRUE if allowed, FALSE if denied
        :rtype: boolean

    .. php:method:: control([string $permPar = null])

        Controls if a logged or public user has permission

        :param  string|integer  $permPar: Perm name or id
        :returns: TRUE if allowed/logged in, FALSE if not allowed/logged in
        :rtype: boolean|redirect|error

    .. php:method:: createUser(string $email, string $password, string $username = null)

        Creates a new user

        :param  string  $email: Email address
        :param  string  $password: Password
        :param  string  $username: Username
        :returns: User Id if success, FALSE if failed
        :rtype: boolean|integer

        .. note::
            Adds errors if failed

    .. php:method:: updateUser(int $userId[, $email = null[, string $password = null[, string $username = null]]])

        Updates a new user

        :param  integer  $userId: User id
        :param  string  $email: Email address
        :param  string  $password: Password
        :param  string  $username: Username
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

        .. note::
            Adds infos if success, errors if failed

    .. php:method:: deleteUser(int $userId)

        Deletes a user

        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: listUsers([$groupPar = null[, int $limit = 0[, int $offset = 0[, bool $includeBanneds = null[, string $orderBy = null]]]]])

        List all users

        :param  string|integer  $groupPar: Group name or id
        :param  integer  $limit: Limit
        :param  integer  $offset: Offset
        :param  boolean  $includeBanneds: Whether to include banned users
        :param  string  $orderBy: Order By
        :returns: Array of users
        :rtype: array

    .. php:method:: listUsersPaginated([$groupPar = null[, int $limit = 10[, bool $includeBanneds = null[, string $orderBy = null]]]])

        List all users with CI4's Pager Class for Pagination

        :param  string|integer  $groupPar: Group name or id
        :param  integer  $limit: Limit
        :param  boolean  $includeBanneds: Whether to include banned users
        :param  string  $orderBy: Order By
        :returns: Array of users
        :rtype: array

    .. php:method:: verifyUser(string $verificationCode)

        Activates user account based on verification code

        :param  string  $verificationCode: Verification code
        :rtype: void

        .. note::
            Adds infos if success, errors if failed

    .. php:method:: getUser([int $userId = null[, bool $includeVariables = false[, bool $systemVariables = false]]])

        Get User and optional user variables by user id

        :param  boolean  $systemVariables: Whether to include System Variables, if $includeVariables is TRUE
        :param  boolean  $includeVariables: Whether to include Variables
        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: getUserId([string $email = null])

        Get User Id by email address

        :param  string  $email: Email address
        :returns: User Id if success or FALSE if user not found
        :rtype: boolean|integer

    .. php:method:: getActiveUsersCount()

        Get Active Users Count

        :returns: Active users count
        :rtype: integer

    .. php:method:: listActiveUsers()

        List Active Users

        :returns: Array of active users
        :rtype: array

    .. php:method:: isBanned([int $userId = null])

        Checks if user is banned

        :param  integer  $userId: User id
        :returns: TRUE if user is banned, FALSE if user is not banned
        :rtype: boolean

    .. php:method:: banUser([int $userId = null])

        Bans User

        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: unbanUser([int $userId = null])

        Unbans User

        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: remindPassword(string $email)

        Emails user with link to reset password

        :param  string  $email: Email address
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: resetPassword(string $resetCode)

        Generate new password and email it to the user

        :param  string  $resetCode: Reset code
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: setUserVar(string $key, string $value[, int $userId = null])

        Set User Variable

        :param  string  $value: Variable value
        :param  string  $key: Variable key
        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: unsetUserVar(string $key[, int $userId = null])

        Unset User Variable

        :param  string  $key: Variable key
        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: getUserVar(string $key[, int $userId = null])

        Get User Variable

        :param  string  $key: Variable key
        :param  integer  $userId: User id
        :returns: Variable value if success, FALSE if failed
        :rtype: boolean|string

    .. php:method:: getUserVars([int $userId = null])

        Get all user keys & variables

        :param  integer  $userId: User id
        :returns: Array of User variables if success, FALSE if failed
        :rtype: boolean|array

    .. php:method:: listUserVarKeys([int $userId = null])

        Get all User Variable Keys by UserId

        :param  integer  $userId: User id
        :returns; Array of User variable keys if success, FALSE if failed
        :rtype: boolean|array

    .. php:method:: createGroup(string $name[, string $definition = ''])

        Creates a new group

        :param  string  $name: Group name
        :param  string  $definition: Group definition
        :returns: Group Id if success, FALSE if failed
        :rtype: boolean|integer

        .. note::
            Adds errors if failed

    .. php:method:: updateGroup($groupPar[, string $name = null[, string $definition = null]])

        Updates a group

        :param  string|integer  $groupPar: Group name or id
        :param  string  $name: Group name
        :param  string  $definition: Group definition
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: deleteGroup($groupPar)

        Deletes a group

        :param  string|integer  $groupPar: Group name or id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: addMember($groupPar, int $userId)

        Add member to group

        :param  string|integer  $groupPar: Group name or id
        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: removeMember($groupPar, int $userId)

        Remove member from group

        :param  string|integer  $groupPar: Group name or id
        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: getUserGroups($userId)

        Get User Groups

        :param  integer  $userId: User id
        :returns: Array of Group Ids, FALSE if failed
        :rtype: boolean|array

    .. php:method:: getUserPerms($userId[, int $state = null])

        Get User Perms

        :param  integer  $userId: User id
        :param  integer  $state: Perm State
        :returns: Array of Perm Ids, FALSE if failed
        :rtype: boolean

    .. php:method:: addSubgroup($groupPar, $subgroupPar)

        Add Subgroup to Group

        :param  string|integer  $groupPar: Group name or id
        :param  string|integer  $subgroupPar: Subgroup name or id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: removeSubgroup($groupPar, $subgroupPar)

        Remove Subgroup to Group

        :param  string|integer  $groupPar: Group name or id
        :param  string|integer  $subgroupPar: Subgroup name or id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: getSubgroups($groupPar)

        Get Subgroups

        :param  string|integer  $groupPar: Group name or id
        :returns: Array of Subgroup Ids, FALSE if failed
        :rtype: boolean

    .. php:method:: getGroupPerms($groupPar, int $state = null)

        Get Group Perms

        :param  string|integer  $groupPar: Group name or id
        :param  integer  $state: Perm State
        :returns: Array of Perm Ids, FALSE if failed
        :rtype: boolean

    .. php:method:: removeMemberFromAll(int $userId)

        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: listGroups()

        List all Groups

        :returns: Array of all groups
        :rtype: array

    .. php:method:: listGroupsPaginated([int $limit = 10[, string $orderBy = null]])

        List all Groups with CI4's Pager Class for Pagination

        :param  integer  $limit: Limit
        :param  string  $orderBy: Order By
        :returns: Array of all groups
        :rtype: array

    .. php:method:: getGroupName($groupPar)

        :param  string|integer $groupPar: Group name or id
        Get Group name

        :returns: Group name or FALSE if group not found
        :rtype: boolean|string

    .. php:method:: getGroupId($groupPar)

        Get Group id

        :param  string|integer  $groupPar: Group name or id
        :returns: Group id if success or FALSE if group not found
        :rtype: boolean|integer

    .. php:method:: getGroup($groupPar)

        Get Group

        :param  string|integer  $groupPar: Group name or id
        :returns: Array with group informations
        :rtype: boolean|array

    .. php:method:: listUserGroups([int $userId = null])

        List all User Groups

        :param  integer  $userId: User id
        :returns: Array of all user groups
        :rtype: array

    .. php:method:: listUserGroupsPaginated([int $userId = null[, int $limit = 10[, string $orderBy = null]]])

        List all User Groups with CI4's Pager Class for Pagination

        :param  integer  $userId: User id
        :param  integer  $limit: Limit
        :param  string  $orderBy: Order By
        :returns: Array of all user groups
        :rtype: array

    .. php:method:: setGroupVar(string $key, string $value, int $groupPar)

        Set Group Variable as key value

        :param  string  $key: Variable key
        :param  string  $value: Variable value
        :param  string|integer $groupPar: Group name or id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: unsetGroupVar(string $key, int $groupPar)

        Unset Group Variable

        :param  string  $key: Variable key
        :param  string|integer $groupPar: Group name or id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: getGroupVar(string $key, int $groupPar)

        Get Group Variable

        :param  string|integer $groupPar: Group name or id
        :param  string  $key: Variable key
        :returns: Variable value if success, FALSE if failed
        :rtype: boolean|string

    .. php:method:: getGroupVars([int $groupPar = null])

        Get all Group Variables

        :param  string|integer $groupPar: Group name or id
        :returns: Array of Group variables if success, FALSE if failed
        :rtype: boolean|array

    .. php:method:: listGroupVarKeys([int $groupPar = null])

        List Group Variable Keys

        :param  string|integer $groupPar: Group name or id
        :returns; Array of Group variable keys if success, FALSE if failed
        :rtype: boolean|array

    .. php:method:: createPerm(string $name[, string $definition = ''])

        Creates a new perm

        :param  string  $name: Name
        :param  string  $definition: Definition
        :returns: Perm Id if success, FALSE if failed
        :rtype: boolean|integer

        .. note::
            Adds errors if failed

    .. php:method:: updatePerm($permPar[, string $name = null[, string $definition = null]])

        Updates a Perm

        :param  string  $definition: Definition
        :param  string  $name: Name
        :param  string|integer  $permPar: Perm name or id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

        .. note::
            Adds errors if failed

    .. php:method:: deletePerm($permPar)

        Deletes a perm

        :param  string|integer  $permPar: Perm name or id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: allowUser($permPar, int $userId)

        Allow Perm of User

        :param  string|integer  $permPar: Perm name or id
        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: denyUser($permPar, int $userId)

        Deny Perm of User

        :param  string|integer  $permPar: Perm name or id
        :param  integer  $userId: User id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: allowGroup($permPar, $groupPar)

        Allow Perm of Group

        :param  string|integer  $permPar: Perm name or id
        :param  string|integer  $groupPar: Group name or id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: denyGroup($permPar, $groupPar)

        Deny Perm of Group

        :param  string|integer  $permPar: Perm name or id
        :param  string|integer  $groupPar: Group name or id
        :returns: TRUE if success, FALSE if failed
        :rtype: boolean

    .. php:method:: listPerms()

        List all Perms

        :returns: Array of all perms
        :rtype: array

    .. php:method:: listPermsPaginated([int $limit = 10[, string $orderBy = null]])

        List all Perms with CI4's Pager Class for Pagination

        :param  integer  $limit: Limit
        :param  string  $orderBy: Order By
        :returns: Array of all perms
        :rtype: array

    .. php:method:: getPermId($permPar)

        Get Perm Id

        :param  string|integer  $permPar: Perm name or id
        :returns: Perm Id if success or FALSE if group not found
        :rtype: boolean|integer

    .. php:method:: getPerm($permPar)

        Get Perm

        :param  string|integer  $permPar: Perm name or id
        :returns: Array with group informations if success, FALSE if failed
        :rtype: boolean|array

    .. php:method:: listGroupPerms($groupPar)

        List all Group Perms

        :param  string|integer  $groupPar: Group name or id
        :returns: Array of all group perms if success, FALSE if failed
        :rtype: boolean|array

    .. php:method:: listGroupPermsPaginated(int $groupPar[, int $limit = 10[, string $orderBy = null]])

        List all Group Perms with CI4's Pager Class for Pagination

        :param  string|integer $groupPar: Group name or id
        :param  integer  $limit: Limit
        :param  string  $orderBy: Order By
        :returns: Array of all group perms if success, FALSE if failed
        :rtype: boolean|array

    .. php:method:: listUserPerms([int $userId = null])

        :param  integer  $userId: User id
        :returns: Array of all user perms if success, FALSE if failed
        :rtype: boolean|array

    .. php:method:: listUserPermsPaginated([int $userId = null[, int $limit = 10[, string $orderBy = null]]])

        List all User Perms with CI4's Pager Class for Pagination

        :param  string  $orderBy: Order By
        :param  integer  $limit: Limit
        :param  integer  $userId: User id
        :returns: Array of all user perms if success, FALSE if failed
        :rtype: boolean|array

    .. php:method:: error($message[, bool $flashdata = null])

        Adds a error

        :param  boolean|array|string  $message: Error Message
        :param  boolean  $flashdata: Whether to set error as session flashData
        :rtype: boolean

    .. php:method:: keepErrors([bool $includeNonFlash = null])

        Keeps Sessions flashData Errors to display after a page reload

        :param  boolean  $includeNonFlash: Whether to add non-flashData errors to session flashData
        :rtype: void

    .. php:method:: getErrorsArray()

        Get Errors Array

        :returns: Array of errors
        :rtype: array

    .. php:method:: printErrors([string $divider = '<br />'[, bool $return = null]])

        Print all Errors with a customizable divider

        :param  string  $divider: Divider
        :param  boolean  $return: Whether to return instead of echoing
        :rtype: void

    .. php:method:: clearErrors()

        Removes all Errors

        :rtype: void

    .. php:method:: info($message[, bool $flashdata = null])

        Adds a info

        :param  boolean|array|string  $message: Info Message
        :param  boolean  $flashdata: Whether to set error as session flashData
        :rtype: void

    .. php:method:: keepInfos([bool $includeNonFlash = null])

        Keeps Sessions flashData Infos to display after a page reload

        :param  boolean  $includeNonFlash: Whether to add non-flashData errors to session flashData
        :rtype: void

    .. php:method:: getInfosArray()

        Get Infos Array

        :returns: Array of infos
        :rtype: array

    .. php:method:: printInfos([string $divider = '<br />'[, bool $return = null]])

        Print all Infos with a customizable divider

        :param  string  $divider: Divider
        :param  boolean  $return: Whether to return instead of echoing
        :rtype: void

    .. php:method:: clearInfos()

        Removes all Infos

        :rtype: void

    .. php:method:: getModel(string $model)

        Get Model by Model name

        :param  string  $model: Model name
        :returns: Model if exists, FALSE if not exists
        :rtype: boolean|object
