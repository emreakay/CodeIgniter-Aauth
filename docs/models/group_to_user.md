# Group to User Model

## Examples

## References

{% PHPclassDisplayer "Group_to_user_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create($user_id, $group_id)" %}
	Add a User to a Group
	{% param "$user_id", type="int" %}
	User's ID
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($user_id, $group_id)" %}
	Remove a User to a Group
	{% param "$user_id", type="int" %}
	User's ID
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_user($user_id)" %}
	Remove a User from all Groups
	{% param "$user_id", type="int" %}
	User's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_group($group_id)" %}
	Remove all Users from a Group
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "exist($user_id, $group_id)" %}
	Check if a User is member of a Group
	{% param "$user_id", type="int" %}
	User's ID
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
