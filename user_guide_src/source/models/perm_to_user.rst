############
Perm to User
############

***************
Class Reference
***************

.. php:class:: PermToUserModel

    .. php:method:: findAllByUserId(int $userId[, int $state = null]))

        Get all Perm Ids by User Id and optional State

        :param  integer  $userId: User Id
        :param  integer|null  $state: Optional State (0 = denied, 1 = allowed)
        :returns: Array of Perm Ids
        :rtype: array

    .. php:method:: findAllByPermId(int $permId)

        Get all User Ids by Perm Id

        :param  string  $permId: Perm Id
        :returns: Array of User Ids
        :rtype: array

    .. php:method:: allowed(int $permId, int $userId)

        Check if Perm Id is allowed by User Id

        :param  integer $permId: Perm Id
        :param  integer $userId: User Id
        :returns: TRUE if is allowed, FALSE if is denied
        :rtype: boolean

    .. php:method:: denied(int $permId, int $userId)

        Check if Perm Id is denied by User Id

        :param  integer $permId: Perm Id
        :param  integer $userId: User Id
        :returns: TRUE if is denied, FALSE if is allowed
        :rtype: boolean

    .. php:method:: save(int $permId, int $userId[, int $state = 1])

        Inserts or Updates Perm to User

        :param  integer $permId: Perm Id
        :param  integer $userId: User Id
        :param  integer $state:  State Int (0 deny, 1 allow)
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: delete(int $permId, int $userId)

        Delete by Perm Id and User Id

        :param  integer $permId: Perm Id
        :param  integer $userId: User Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: deleteAllByPermId(int $permId)

        Delete all by Perm Id

        :param  integer $permId: Perm Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: deleteAllByUserId(int $userId)

        Delete all by User Id

        :param  integer $userId: User Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean
