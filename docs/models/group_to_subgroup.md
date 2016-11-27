# Group to Subgroup Model

## Examples

## References

{% PHPclassDisplayer "Group_to_subgroup_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create($subgroup_id, $group_id)" %}
	Add a Sub-Groub to a Group
	{% param "$subgroup_id", type="int" %}
	Sub-Groub's ID
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($subgroup_id, $group_id)" %}
	Remove a Sub-Groub from a Group
	{% param "$subgroup_id", type="int" %}
	Sub-Group's ID
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_subgroup($subgroup_id)" %}
	Remove a Sub-Groub from all Groups
	{% param "$subgroup_id", type="int" %}
	Sub-Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_group($group_id)" %}
	Remove all Sub-Groubs from a Group
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "exist($subgroup_id, $group_id)" %}
	Check if a Sub-Groub is member of a Group
	{% param "$subgroup_id", type="int" %}
	Sub-Group's ID
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
