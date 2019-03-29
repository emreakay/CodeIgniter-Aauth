###########
Login Token
###########


***************
Class Reference
***************

.. php:class:: LoginTokenModel

  .. php:method:: findAllByUserId(int $userId)

      Find all Login Tokens by User ID

      :param  integer  $userId: User id
      :returns: Array with all login tokens
      :rtype: array

  .. php:method:: insert(array $data)

      Updates Login Token

      :param  array  $data: Array with data
      :returns: TRUE on success, FALSE on failure
      :rtype: boolean

  .. php:method:: update(int $tokenId)

      Update Login Token by tokenId

      :param  integer  $tokenId: Login Token id
      :returns: TRUE on success, FALSE on failure
      :rtype: boolean

  .. php:method:: deleteExpired(int $userId)

      Deletes expired Login Tokens by userId.

      :param  integer  $userId: User id
      :returns: TRUE on success, FALSE on failure
      :rtype: boolean

  .. php:method:: deleteAll(int $userId)

      Deletes all Login Tokens by userId.

      :param  integer  $userId: User id
      :returns: TRUE on success, FALSE on failure
      :rtype: boolean
