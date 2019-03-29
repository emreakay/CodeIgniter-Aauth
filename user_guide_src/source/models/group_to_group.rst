##############
Group to Group
##############

***************
Class Reference
***************

.. php:class:: GroupToGroupModel

    .. php:method:: findAllBySubgroupId(int $subgroupId)

        Get all Group Ids by Subgroup Id

        :param  integer  $subgroupId: Subgroup Id
        :returns: Array of Groups Ids
        :rtype: array

    .. php:method:: findAllByGroupId(int $groupId)

        Get all Subgroup Ids by Group Id

        :param  integer  $groupId: Group Id
        :returns: Array of Subgroup Ids
        :rtype: array

    .. php:method:: exists(int $groupId, int $subgroupId)

        Check if exists by Group Id and Subgroup Id

        :param  integer $groupId: Group Id
        :param  integer $subgroupId: Subgroup Id
        :returns: TRUE if exists by Group Id and Subgroup Id, FALSE if not exists
        :rtype: boolean

    .. php:method:: insert(int $groupId, int $subgroupId)

        Insert by Group Id and Subgroup Id

        :param  integer $groupId: Group Id
        :param  integer $subgroupId: Subgroup Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: delete(int $groupId, int $subgroupId)

        Delete by Group Id and Subgroup Id

        :param  integer $groupId: Group Id
        :param  integer $subgroupId: Subgroup Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: deleteAllByGroupId(int $groupId)

        Delete all by Group Id

        :param  integer $groupId: Group Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean

    .. php:method:: deleteAllBySubgroupId(int $subgroupId)

        Delete all by Subgroup Id

        :param  integer $subgroupId: Subgroup Id
        :returns: TRUE on success, FALSE on failure
        :rtype: boolean
