<?php
function TablePrint($result)
{
	echo "<table border=1 cellspacing=1>";
	echo "<tr>";
	foreach($result[0] as $key => $item)
	{
		echo "<th>$key</th>";
	}
	echo "</tr>";
	foreach($result as $result)
	{
		echo "<tr>";
		foreach($result as $key =>$item)
		{
			echo "<td>$item</td>";
		}
		echo "</tr>";
	}
	echo"</table>";
}
?>
