# User Variables Model

## Examples

## References

{% PHPclassDisplayer "User_Variables_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "update($user_id, $key, $value)" %}
    Updates/Creates a user uariable for a user in database.
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$key", type="string" %}
    User Variable Key
    {% param "$value", type="string" %}
    User Variable Value
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get($user_id, $key)" %}
    Retrieves a user variable from a user in database.
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$key", type="string" %}
    User Variable Key
    {% return %}
    Either the value of the user variable, or `FALSE`. 
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_by_user_id($user_id)" %}
    Retrieves all user variables from a user in database.
    {% param "$user_id", type="int" %}
    User's ID
    {% return %}
    Either a array of all user variables, or `FALSE`. 
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($user_id [, $key = NULL])" %}
    Removes all user variables or only one user variable from a user in database.
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$key", type="string" %}
    User Variable Key
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
