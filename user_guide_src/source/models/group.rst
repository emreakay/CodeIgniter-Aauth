#####
Group
#####

This Model is based on `CodeIgniter's Model <https://codeigniter4.github.io/CodeIgniter4/models/model.html>`_
and comes with much built in functions, like ``find()``, ``findAll()``, ``first()``, ``set()``, ``insert()``,
``update()``, ``save()``, ``delete()``.

For more informations see `this documentation <https://codeigniter4.github.io/CodeIgniter4/models/model.html>`_.

***************
Class Reference
***************

.. php:class:: GroupModel

  .. php:method:: existsById(int $groupId)

    Checks if group exist by group id

    :param  integer  $groupId: Group id
    :returns: TRUE if exists, or FALSE.
    :rtype: boolean

  .. php:method:: getByName(string $name)

    Get group by group name

    :param  string  $name: Group name
    :returns: The resulting row, or FALSE if group not exists.
    :rtype: string|boolean
