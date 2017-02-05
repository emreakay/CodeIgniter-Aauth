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
	Removes a assigned permission from a user.
	{% param "$permission_id", type="int" %}
	Permission's ID
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_user($user_id)" %}
	Removes all assigned permissions from a user.
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_permission($permission_id)" %}
	Remove a permission from any user.
	{% param "$permission_id", type="int" %}
	Permission's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "exist($permission_id, $user_id)" %}
	Checks if a permission is already assigned to a user.
	{% param "$permission_id", type="int" %}
	Permission's ID
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
