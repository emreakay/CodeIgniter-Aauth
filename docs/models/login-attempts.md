# Login Attempts Model

## Examples

## References

{% PHPclassDisplayer "Login_Attempts_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "get()" %}
    Retrieves a login attempt from database, based on IP-Address and timestamp.
    {% return %}
    Value of login attempts
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update()" %}
    Updates/Created a login attempt in database, based on IP-Address and timestamp.
    {% return %}
    Either `TRUE` if login attempt below `max_attempts`, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete()" %}
    Removes a login attempt from database, based on IP-Address and timestamp.
    {% return %}
    Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
