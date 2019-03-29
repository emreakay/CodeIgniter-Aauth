####
User
####

This Model is based on `CodeIgniter's Model <https://codeigniter4.github.io/CodeIgniter4/models/model.html>`_
and comes with much built in functions, like ``find()``, ``findAll()``, ``first()``, ``set()``, ``insert()``,
``update()``, ``save()``, ``delete()``.

For more informations see `this documentation <https://codeigniter4.github.io/CodeIgniter4/models/model.html>`_.

***************
Class Reference
***************

.. php:class:: UserModel

  .. php:method:: updateLastLogin(int $userId)

    Update last login by User ID

    :param  integer  $userId: User id
    :returns: TRUE on success, FALSE on failure
    :rtype: boolean

  .. php:method:: updateLastActivity(int $userId)

    Update Last Activity by User ID

    :param  string  $name: Group name
    :returns: TRUE on success, FALSE on failure
    :rtype: boolean

  .. php:method:: updateBanned(int $userId[, bool $banned = false])

    Update Banned by User ID

    :param  integer  $userId: User id
    :param  boolean  $banned: Whether TRUE to ban, FALSE to unban
    :returns: TRUE on success, FALSE on failure
    :rtype: boolean

  .. php:method:: isBanned(int $userId)

    Checks if user is banned

    :param  string  $name: Group name
    :returns: TRUE if is banned, FALSE if is not banned
    :rtype: boolean

  .. php:method:: existsById(int $userId)

    Checks if user exist by user id

    :param  string  $userId: User Id
    :returns: TRUE if exists, FALSE if not exists
    :rtype: boolean

  .. php:method:: existsByEmail(string $email)

    Checks if user exist by email

    :param  string  $email: Email
    :returns: TRUE if exists, FALSE if not exists
    :rtype: boolean

  .. php:method:: existsByUsername(string $username)

    Checks if user exist by username

    :param  string  $username: Username
    :returns: TRUE if exists, FALSE if not exists
    :rtype: boolean
