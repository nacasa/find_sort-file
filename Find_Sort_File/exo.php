<?php
/**
*   This function sorts an array of float numbers and conserves its keys.
*   Also, a $filter can be provided in order to exclude values that are lower than the $filter.
*   Finally, a $filter_exclude_lower can be set to false in order to exclude values that are higher than the $filter.
*
*   exemple of $array :
*   [
*       'email1' => mark1,
*       'email2' => mark2,
*       'email3' => mark3,
*       ...
*   ]
*
*   @param array $array
*   @param int|float $filter
*   @param bool $filter_exclude_lower
*
*   @return array
*/
function sort_array($array, $filter = false, $filter_exclude_lower = true)
{
    $keys = array_keys($array);
    $values = array_values($array);

    do {
        $sorted = true;
        for ($i = 0; $i < count($values); $i++) {
            if ($filter != NULL) {
				if (filter($values, $keys, compact('filter', 'filter_exclude_lower'), $i) == true) {
					$sorted = false;
					break;
				}
			}
			
				if (isset($values[$i + 1]) && $values[$i] > $values[$i + 1]) {
					swap_indexes($values, $i, $i + 1);
					swap_indexes($keys, $i, $i + 1);
					$sorted = false;
				}
			
        }
    } while ($sorted === false);
	
    //return $values;
    $result = array_combine($keys, $values);
    return $result;
}

/**
*   This functions swaps two values in an &$array according to their indexes
*
*   @param array &$array
*   @param int $idx1
*   @param int $idx2
*
*   @return void
*/
function swap_indexes(&$array, $idx1, $idx2)
{
    $tmp = $array[$idx2];
    $array[$idx2] = $array[$idx1];
    $array[$idx1] = $tmp;
}

/**
*   This functions removes a given $index from both &$values and &$keys arrays
*   if the $filters does not match the corresponding value
*
*   @param array &$values
*   @param array &$keys
*   @param array &$filters
*   @param int $index
*
*   @return bool (removed or not)
*/
function filter(&$values, &$keys, $filters, $index)
{
    if (
        ($filters['filter_exclude_lower'] === true && $values[$index] >= $filters['filter']) ||
        ($filters['filter_exclude_lower'] === false && $values[$index] <= $filters['filter'])
    ) {
        unset($values[$index]);
        $values = array_values($values);
        unset($keys[$index]);
        $keys = array_values($keys);
        return true;
    }
    return false;
}
