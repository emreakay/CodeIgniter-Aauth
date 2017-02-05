# Users Model

## Examples

## References

{% PHPclassDisplayer "Users_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create($email, $pass [, $username = '' ])" %}
    Adds a user to the database.
    {% param "$email", type="string" %}
    User's email address
    {% param "$pass", type="string" %}
    User's password
    {% param "$name", type="string" %}
    User's name
    {% return %}
    Either `User_ID` of created user, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update($user_id, $data)" %}
    Updates data of a user in database.
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$data", type="array" %}
    Array of data to update
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($user_id)" %}
    Removes a user from database.
    {% param "$user_id", type="int" %}
    User's ID
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_all([$options = array()])" %}
    Retrieves all users from database.
    {% hint %}
    Available options:
     - `filters` (_array_) - A associative array with 'column'-name as key and value
     - `include_banneds` (_bool_) - Whether to include banned user's
     - `only_banneds` (_bool_) - Whether to include only banned user's
     - `offset` (_int_) - Number of rows to limit the results to
     - `limit` (_int_) - Number of rows to skip
    {% param "$options", type="array" %}
    Array of options.
    {% return %}
    Array of all users as object.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "ban($user_id [, $ver_code = NULL])" %}
    Bans/Unverfies a user.
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$ver_code", type="string" %}
    Verification Code
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "unban($user_id [, $ver_code = NULL])" %}
    Unbans/Verfies a user.
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$ver_code", type="string" %}
    Verification Code
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update_($user_id, $type)" %}
    Updates last_activity or last_login of a user.
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$type", type="string" %}
    Update Type
    {% hint %}
    Available types:
     - `activity`
     - `last_login`
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "exist_by_($filters = array())" %}
    Checks if a user exist in database depending on filters.
    {% param "$filters", type="array" %}
    A associative array with 'column'-name as key and value
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_($filters, $result_column)" %}
    Retrieves a user depending on filters with a result column.
    {% param "$filters", type="array" %}
    A associative array with 'column'-name as key and value
    {% param "$result_column", type="string" %}
    Column name thats get returned
    {% return %}
    Either `value` of selected column on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_by_($filters [, $options = NULL])" %}
    Retrieves users from database depending on filters and options.
    {% param "$filters", type="array" %}
    A associative array with column name as key and value
    {% param "$options", type="array" %}
    Array of options.
    {% hint %}
    Available options:
     - `select` (_bool_) - Single column name or Multiple column names comma separeated
     - `offset` (_int_) - Number of rows to limit the results to
     - `limit` (_int_) - Number of rows to skip
    {% return %}
    CI's Database `get()`
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "is_($user_id, $type)" %}
    Checks if a user is banned or verified.
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$type", type="string" %}
    Is Type
    {% hint %}
    Available types:
     - `banned`
     - `verified`
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

