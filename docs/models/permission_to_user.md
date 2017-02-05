# Permission to User Model

## Examples

## References

{% PHPclassDisplayer "Permission_to_user_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create($permission_id, $user_id)" %}
	Assigns a permission to a user.
	{% param "$permission_id", type="int" %}
	Permission's ID
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($permission_id, $user_id)" %}
	Removes a specific assigned permission from a specific user.
	{% param "$permission_id", type="int" %}
	Permission's ID
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_user($user_id)" %}
	Removes all assigned permissions from a specific user.
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_permission($permission_id)" %}
	Remove a specific permission from any user.
	{% param "$permission_id", type="int" %}
	Permission's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "exist($permission_id, $user_id)" %}
	Checks if a specific permission is already assigned to a specific user.
	{% param "$permission_id", type="int" %}
	Permission's ID
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
