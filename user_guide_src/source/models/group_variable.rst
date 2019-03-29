##############
Group Variable
##############


***************
Class Reference
***************

.. php:class:: GroupVariableModel

  .. php:method:: find(int $groupId, string $dataKey[, bool $system = null])

      Find Group Variable by groupId, dataKey & optional system

      :param  integer  $groupId: Group id
      :param  string  $dataKey: Key of variable
      :param  boolean  $system: Whether system variable
      :returns: User variable value, or NULL if not exists
      :rtype: string|null

  .. php:method:: findAll(int $groupId[, bool $system = null])

      Find all group variables

      :param  integer  $groupId: Group id
      :param  boolean  $system: Whether system variable
      :returns: Array with all group variables
      :rtype: array

  .. php:method:: save(int $groupId, string $dataKey, string $dataValue[, bool $system = null])

      Update/Insert Group Variable

      :param  integer  $groupId: Group id
      :param  string  $dataKey: Key of variable
      :param  string  $dataValue: Value of variable
      :param  boolean  $system: Whether system variable
      :returns: TRUE on success, FALSE on failure
      :rtype: boolean

  .. php:method:: insert(int $groupId, string $dataKey, string $dataValue[, bool $system = null])

      Insert Group Variable

      :param  integer  $groupId: Group id
      :param  string  $dataKey: Key of variable
      :param  string  $dataValue: Value of variable
      :param  boolean  $system: Whether system variable
      :returns: TRUE on success, FALSE on failure
      :rtype: boolean


  .. php:method:: update(int $groupId, string $dataKey, string $dataValue[, bool $system = null])

      Update Group Variable

      :param  integer  $groupId: Group id
      :param  string  $dataKey: Key of variable
      :param  string  $dataValue: Value of variable
      :param  boolean  $system: Whether system variable
      :returns: TRUE on success, FALSE on failure
      :rtype: boolean

  .. php:method:: delete(int $groupId, string $dataKey[, bool $system = null])

      Delete Group Variable

      :param  integer  $groupId: Group id
      :param  string  $dataKey: Key of variable
      :param  boolean  $system: Whether system variable
      :returns: TRUE on success, FALSE on failure
      :rtype: boolean

  .. php:method:: deleteAllByUserId(int $groupId)

      Delete All Group Variables by User Id

      :param  integer  $groupId: Group id
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
