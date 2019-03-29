#############
Group to User
#############

***************
Class Reference
***************

.. php:class:: GroupToUserModel

    .. php:method:: findAllByUserId(int $userId)

        Get all Group Ids by User Id

        :param  integer  $userId: User Id
        :returns: Array of Groups Ids
        :rtype: array

    .. php:method:: findAllByGroupId(int $groupId)

        Get all User Ids by Group Id

        :param  integer  $groupId: Group Id
        :returns: Array of User Ids
        :rtype: array

    .. php:method:: exists(int $groupId, int $userId)

        Check if exists by Group Id and User Id

        :param  integer $groupId: Group Id
        :param  integer $userId: User Id
        :returns: TRUE if exists by Group Id and User Id, FALSE if not exists
        :rtype: boolean

    .. php:method:: insert(int $groupId, int $userId)

        Insert by Group Id and User Id

        :param  integer $groupId: Group Id
        :param  integer $userId: User Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: delete(int $groupId, int $userId)

        Delete by Group Id and User Id

        :param  integer $groupId: Group Id
        :param  integer $userId: User Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: deleteAllByGroupId(int $groupId)

        Delete all by Group Id

        :param  integer $groupId: Group Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: deleteAllByUserId(int $userId)

        Delete all by User Id

        :param  integer $userId: User Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean
