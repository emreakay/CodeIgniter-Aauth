# Group to Subgroup Model

## Examples

## References

{% PHPclassDisplayer "Group_to_subgroup_model" %}
{% endPHPclassDisplayer %}

{% PHPmethodDisplayer "create($group_id, $subgroup_id)" %}
	Assigns a group to a subgroup.
	{% param "$group_id", type="int" %}
	Group's ID
	{% param "$subgroup_id", type="int" %}
	Sub-Groub's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete($group_id, $subgroup_id)" %}
	Removes a assigned group from a subgroup.
	{% param "$group_id", type="int" %}
	Group's ID
	{% param "$subgroup_id", type="int" %}
	Sub-Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_subgroup($subgroup_id)" %}
	Removes all assigned groups from a subgroup.
	{% param "$subgroup_id", type="int" %}
	Sub-Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "delete_by_group($group_id)" %}
	Removes all assigned subgroups from a group.
	{% param "$group_id", type="int" %}
	Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}

{% PHPmethodDisplayer "exist($group_id, $subgroup_id)" %}
	Checks if a group is already assigned to a subgroup.
	{% param "$group_id", type="int" %}
	Group's ID
	{% param "$subgroup_id", type="int" %}
	Sub-Group's ID
	{% return %}
	Either `TRUE` on success, or `FALSE`.
{% endPHPmethodDisplayer %}
