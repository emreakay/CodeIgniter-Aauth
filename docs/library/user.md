# User Functions

## Examples

## References

{% PHPclassDisplayer "Aauth" %}
    User Authorization Library for CodeIgniter 2.x and 3.x
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create_user($email, $pass [, $name = FALSE ])" %}
    Update amount of time a user is remembered for
    {% param "$email", type="string" %}
    User's email address
    {% param "$pass", type="string" %}
    User's password
    {% param "$name", type="string" %}
    User's name
    {% return %}
    Either `User_ID` of created user, or `FALSE` on failure.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update_user($user_id [, $email = FALSE, $pass = FALSE, $name = FALSE ])" %}
    Update amount of time a user is remembered for
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$email", type="bool|string" %}
    User's email address
    {% param "$pass", type="bool|string" %}
    User's password
    {% param "$name", type="bool|string" %}
    User's name
    {% return %}
    Either `TRUE`, or `FALSE` on failure.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "list_users([ $group_par = FALSE, $limit = FALSE, $offset = FALSE, $include_banneds = FALSE ])" %}
    Return users as an object array
    {% param "$group_par", type="int|string" %}
    Specify group, to list all users in specific group
    {% param "$limit", type="int" %}
    Limit of users to be returned
    {% param "$offset", type="int" %}
    Offset for limited number of users
    {% param "$include_banneds", type="bool" %}
    Includes banned users
    {% return %}
    Array of objects.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "get_user([ $user_id = FALSE ])" %}
    Get user information
    {% param "$user_id", type="bool|int" %}
    User's ID or `FALSE` for current user
    {% return %}
    Either object, or `FALSE` on failure.
{% endPHPmethodDisplayer %}
