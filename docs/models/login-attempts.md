# Login Attempts Model

## Examples

## References

{% PHPclassDisplayer "Login_Attempts_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "get()" %}
    Retrieves Login Attempt from Database, based on IP Address and Timestamp
    {% return %}
    Value of Login Attempts
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update()" %}
    Updates/Created Login Attempt in Database, based on IP Address and Timestamp
    {% return %}
    Either `TRUE` if Login Attempt below `max_attempts`, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete()" %}
    Removes Login Attempt from Database, based on IP Address and Timestamp
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
