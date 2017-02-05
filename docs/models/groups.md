# Groups Model

## Examples

## References

{% PHPclassDisplayer "Groups_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create($name [, $definition = ''])" %}
    Adds a group to database.
    {% param "$name", type="string" %}
    Group's name
    {% param "$definition", type="string" %}
    Group's definition
    {% return %}
    Either `Group_ID` of created group, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update($group_id [, $name = NULL, $definition = NULL])" %}
    Updates a group in database.
    {% param "$group_id", type="int" %}
    Group's ID
    {% param "$name", type="string" %}
    Group's name
    {% param "$definition", type="string" %}
    Group's definition
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($group_id)" %}
    Removes a group from database.
    {% param "$group_id", type="int" %}
    Group's ID
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get($group_id)" %}
    Retrieves a group from database.
    {% param "$group_id", type="int" %}
    Group's ID
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_id($name)" %}
    Retrieves a group id from database.
    {% param "$name", type="int" %}
    Group's name
    {% return %}
    Either `Group_ID`, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_all()" %}
    Retrieves all groups from database.
    {% return %}
    Array of all groups as object.
{% endPHPmethodDisplayer %}
