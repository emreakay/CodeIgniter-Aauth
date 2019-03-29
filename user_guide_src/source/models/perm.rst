####
Perm
####

This Model is based on `CodeIgniter's Model <https://codeigniter4.github.io/CodeIgniter4/models/model.html>`_
and comes with much built in functions, like ``find()``, ``findAll()``, ``first()``, ``set()``, ``insert()``,
``update()``, ``save()``, ``delete()``.

For more informations see `this documentation <https://codeigniter4.github.io/CodeIgniter4/models/model.html>`_.

***************
Class Reference
***************

.. php:class:: PermModel

  .. php:method:: existsById(int $permId)

    Checks if perm exist by perm id

    :param  integer  $permId: Perm id
    :returns: TRUE if exists, or FALSE.
    :rtype: boolean

  .. php:method:: getByName(string $name)

    Get perm by perm name

    :param  string  $name: Perm name
    :returns: The resulting row, or FALSE if Perm not exists.
    :rtype: string|boolean
