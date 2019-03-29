################
Database Changes
################

All changes inside the Aauth Database Tables

.. contents::
    :local:
    :depth: 2

Users Table
===========
  - renamed ``pass`` to ``password``
  - renamed ``ip_address`` to ``last_ip_address``
  - renamed ``date_created`` to  ``created_at``
  - added ``updated_at`` 'DATETIME'
  - added ``deleted`` 'TINYINT(1)'
  - removed ``forgot_exp`` (unused)
  - removed ``remember_time`` (moved to Login Token)
  - removed ``remember_exp`` (moved to Login Token)
  - removed ``verification_code`` (moved to User System Variable)
  - removed ``totp_secret`` (moved to User System Variable)

User Sessions Table
===================
  - added ``id`` 'VARCHAR(128)' PKey A_I
  - added ``ip_address`` 'VARCHAR(45)'
  - added ``timestamp`` 'INT(10)'
  - added ``data`` 'TEXT'

User Variables Table
====================
  - renamed ``value`` to ``data_value``
  - added ``created_at`` 'DATETIME'
  - added ``updated_at`` 'DATETIME'
  - added ``system`` 'TINYINT(1)'

Login Attempts Table
====================
  - added ``id`` 'INT(11)' PKey A_I
  - added ``ip_address`` 'VARCHAR(39)'
  - added ``count`` 'TINYINT(2)'
  - added ``created_at`` 'DATETIME'
  - added ``updated_at`` 'DATETIME'

Login Token Table
=================
  - added ``id`` 'INT(11)' PKey A_I
  - added ``user_id`` 'INT(11)'
  - added ``random_hash`` 'VARCHAR(255)'
  - added ``selector_hash`` 'VARCHAR(255)'
  - added ``created_at`` 'DATETIME'
  - added ``updated_at`` 'DATETIME'
  - added ``expires_at`` 'DATETIME'

Groups Table
============
  - added ``created_at`` 'DATETIME'
  - added ``updated_at`` 'DATETIME'

Group Variables Table
=====================
  - added ``id`` 'INT(11)' PKey A_I
  - added ``group_id`` 'INT(11)'
  - added ``data_key`` 'VARCHAR(100)'
  - added ``data_value`` 'TEXT'
  - added ``created_at`` 'DATETIME'
  - added ``updated_at`` 'DATETIME'
  - added ``system`` 'TINYINT(1)'

Perms Table
===========
  - added ``created_at`` 'DATETIME'
  - added ``updated_at`` 'DATETIME'

PMs Table
=========
  - completly removed
