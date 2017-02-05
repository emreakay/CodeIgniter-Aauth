# Permissions Model

## Examples

## References

{% PHPclassDisplayer "Permissions_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create($name [, $definition = ''])" %}
    Creates a permission.
    {% param "$name", type="string" %}
    Permission's name
    {% param "$definition", type="string" %}
    Permission's definition
    {% return %}
    Either `Permission_ID` of created permission, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update($permission_id [, $name = NULL, $definition = NULL])" %}
    Updates a permission.
    {% param "$permission_id", type="int" %}
    Permission's ID
    {% param "$name", type="string" %}
    Permission's name
    {% param "$definition", type="string" %}
    Permission's definition
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($id)" %}
    Removes a permission.
    {% param "$permission_id", type="int" %}
    Permission's ID
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get($permission_id)" %}
    Retrieves a permission.
    {% param "$permission_id", type="int" %}
    Permission's ID
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_id($name)" %}
    Retrieves permission_id.
    {% param "$name", type="int" %}
    Permission's name
    {% return %}
    Either `Permission_ID`, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_all()" %}
    Retrieves all permissions.
    {% return %}
    Array of all permission as object.
{% endPHPmethodDisplayer %}
