#############
Perm to Group
#############

***************
Class Reference
***************

.. php:class:: PermToGroupModel

    .. php:method:: findAllByGroupId(int $groupId[, int $state = null]))

        Get all Perm Ids by Group Id and optional State

        :param  integer  $groupId: Group Id
        :param  integer|null  $state: Optional State (0 = denied, 1 = allowed)
        :returns: Array of Perm Ids
        :rtype: array

    .. php:method:: findAllByPermId(int $permId)

        Get all Group Ids by Perm Id

        :param  string  $permId: Perm Id
        :returns: Array of Group Ids
        :rtype: array

    .. php:method:: allowed(int $permId, int $groupId)

        Check if Perm Id is allowed by Group Id

        :param  integer $permId: Perm Id
        :param  integer $groupId: Group Id
        :returns: TRUE if is allowed, FALSE if is denied
        :rtype: boolean

    .. php:method:: denied(int $permId, int $groupId)

        Check if Perm Id is denied by Group Id

        :param  integer $permId: Perm Id
        :param  integer $groupId: Group Id
        :returns: TRUE if is denied, FALSE if is allowed
        :rtype: boolean

    .. php:method:: save(int $permId, int $groupId[, int $state = 1])

        Inserts or Updates Perm to Group

        :param  integer $permId: Perm Id
        :param  integer $groupId: Group Id
        :param  integer $state:  State Int (0 deny, 1 allow)
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: delete(int $permId, int $groupId)

        Delete by Perm Id and Group Id

        :param  integer $permId: Perm Id
        :param  integer $groupId: Group Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: deleteAllByPermId(int $permId)

        Delete all by Perm Id

        :param  integer $permId: Perm Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: deleteAllByGroupId(int $groupId)

        Delete all by Group Id

        :param  integer $groupId: Group Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean
