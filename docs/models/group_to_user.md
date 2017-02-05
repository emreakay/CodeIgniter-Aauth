# Group to User Model

## Examples

## References

{% PHPclassDisplayer "Group_to_user_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create($group_id, $user_id)" %}
	Assigns a group to a user.
	{% param "$group_id", type="int" %}
	Group's ID
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($group_id, $user_id)" %}
	Removes a assigned group from a user.
	{% param "$group_id", type="int" %}
	Group's ID
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_user($user_id)" %}
	Removes all assigned groups from a user.
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_group($group_id)" %}
	Removes a groups from any user.
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "exist($group_id, $user_id)" %}
	Checks if a group is already assigned to a user.
	{% param "$group_id", type="int" %}
	Group's ID
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
