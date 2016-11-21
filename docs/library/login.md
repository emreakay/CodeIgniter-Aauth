# Login Functions

## Examples

## References

{% PHPclassDisplayer "Aauth" %}
    User Authorization Library for CodeIgniter 2.x and 3.x
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "login($identifier, $pass [, $remember = FALSE, $totp_code = NULL ])" %}
    Login User
    {% param "$identifier", type="string" %}
    User's Identifier (email or name definied by Config-Var `login_with_name`)
    {% param "$pass", type="string" %}
    User's Password
    {% param "$remember", type="bool" %}
    Remember
    {% param "$totp_code", type="string" %}
    TOTP Code
    {% return %}
    Either `TRUE`, or `FALSE` on failure.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "is_loggedin()" %}
    Checks if user is logged in
    {% return %}
    Either `TRUE`, or `FALSE` if not logged in.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "is_loggedin()" %}
    Log a user out / Kills user session
    {% return %}
    Either `TRUE`, or `FALSE` on failure.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "login_fast($user_id)" %}
    Login User only with user_id
    {% param "$user_id", type="int" %}
    User's ID
    {% return %}
    Either `TRUE`, or `FALSE` on failure.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "reset_login_attempts()" %}
    Removes login attempts based on IP-Address & Timestamp 
    {% return %}
    Either `TRUE`, or `FALSE` on failure.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "remind_password($email)" %}
    Sends a user a link to reset password
    {% param "$email", type="string" %}
    User's email address
    {% return %}
    Either `TRUE`, or `FALSE` on failure.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "reset_password($ver_code)" %}
    Generate new password and email it to the user
    {% param "$ver_code", type="string" %}
    Verification code
    {% return %}
    Either `TRUE`, or `FALSE` on failure.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update_last_login([ $user_id = FALSE ])" %}
    Updates last login timestamp
    {% param "$user_id", type="int" %}
    User's ID
    {% return %}
    Either `TRUE`, or `FALSE` on failure.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update_login_attempts()" %}
    Update login attempt
    {% param "$user_id", type="int" %}
    User's ID
    {% return %}
    Either `TRUE`, or `FALSE` if login attempt exceeded.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "update_remember($user_id [, $expression = NULL, $expire = NULL ])" %}
    Update amount of time a user is remembered for
    {% param "$user_id", type="int" %}
    User's ID
    {% param "$expression", type="string" %}
    Expression
    {% param "$expire", type="string" %}
    Expire Date
    {% return %}
    Either `TRUE`, or `FALSE` if login attempt exceeded.
{% endPHPmethodDisplayer %}
