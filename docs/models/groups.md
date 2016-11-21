# Groups Model

## Examples

## References

{% PHPclassDisplayer "Groups_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create($group_name [, $group_definition = ''])" %}
    Creates group in Database
    {% param "$group_name", type="string" %}
    Group's name
    {% param "$group_definition", type="string" %}
    Group's definition
    {% return %}
    Either `Group_ID` of created group, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update($group_id [, $group_name = NULL, $group_definition = NULL])" %}
    Updates group in Database
    {% param "$group_id", type="int" %}
    Group's ID
    {% param "$group_name", type="string" %}
    Group's name
    {% param "$group_definition", type="string" %}
    Group's definition
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($group_id)" %}
    Removes group from Database
    {% param "$group_id", type="int" %}
    Group's ID
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get($group_id)" %}
    Retrieves group from Database
    {% param "$group_id", type="int" %}
    Group's ID
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_id($group_name)" %}
    Retrieves group id from Database
    {% param "$group_name", type="int" %}
    Group's name
    {% return %}
    Either `Group_ID`, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_all()" %}
    Retrieves all group's from Database
    {% return %}
    Array of all groups as object.
{% endPHPmethodDisplayer %}
