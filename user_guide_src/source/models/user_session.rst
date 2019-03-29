#############
User Sessions
#############


***************
Class Reference
***************

.. php:class:: UserSessionModel

  .. php:method:: findAll()

      Find all active user sessions

      :returns: Array with all active user session
      :rtype: array

  .. php:method:: delete(string $id)

      Delete user session by id

      :param  string  $id: Session id
      :returns: TRUE on success, FALSE on failure
      :rtype: boolean

  .. php:method:: asArray()

      Sets the return type of the results to be as an associative array.

      :returns: UserSessionModel
      :rtype: object

  .. php:method:: asObject([string $class = 'object'])

      Sets the return type to be of the specified type of object.
      Defaults to a simple object, but can be any class that has
      class vars with the same name as the table columns, or at least
      allows them to be created.

      :param  string  $class: Class name
      :returns: UserSessionModel
      :rtype: object

  .. php:method:: first()

      Returns the first row of the result set. Will take any previous
      Query Builder calls into account when determing the result set.

      :returns: The resulting row found during the search, or NULL if none found.
      :rtype: array|object|null
