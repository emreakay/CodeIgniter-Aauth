# User Variables Model

## Examples

## References

{% PHPclassDisplayer "User_Variables_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "update($user_id, $key, $value)" %}
    Updates/Creates User Variable for a user in Database
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
    Retrieves a User Variable from a user in Database
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$key", type="string" %}
    User Variable Key
    {% return %}
    Either the value of the Variable, or `FALSE`. 
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_by_user_id($user_id)" %}
    Retrieves all User Variables from a user in Database
    {% param "$user_id", type="int" %}
    User's ID
    {% return %}
    Either a array of all User Variables, or `FALSE`. 
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($user_id [, $key = NULL])" %}
    Removes all User Variables or only one User Variable from a user in Database
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$key", type="string" %}
    User Variable Key
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
