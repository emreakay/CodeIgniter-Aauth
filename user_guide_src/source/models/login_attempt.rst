##############
Login Attempts
##############


***************
Class Reference
***************

.. php:class:: LoginAttemptModel

  .. php:method:: find()

      Get login attempt based on time and ip address

      :returns: Login attempt count based
      :rtype: integer

  .. php:method:: save()

      Insert/Update login attempt based on time and ip address

      :param  array  $data: Array with data
      :returns: TRUE if Login Attempt Limit is not hit, FALSE  if Login Attempt Limit is hit
      :rtype: boolean

  .. php:method:: delete()

      Delete login attempt based on time and ip address

      :param  array  $data: Array with data
      :returns: TRUE if Login Attempt Limit is not hit, FALSE  if Login Attempt Limit is hit
      :rtype: boolean
