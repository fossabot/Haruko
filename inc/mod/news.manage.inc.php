<?php

if (!defined("IN_MOD"))

{

	die("Nah, I won't serve that file to you.");

}

$mitsuba->admin->reqPermission("news.manage");

		?>

<?php $mitsuba->admin->ui->startSection($lang['mod/all_news_entries']); ?>



<table>

<thead>

<tr>

<td><?php echo $lang['mod/title']; ?></td>

<td><?php echo $lang['mod/date']; ?></td>

<td><?php echo $lang['mod/edit']; ?></td>

<td><?php echo $lang['mod/delete']; ?></td>

</tr>

</thead>

<tbody>

<?php

$result = $conn->query("SELECT * FROM news ORDER BY date DESC;");

while ($row = $result->fetch_assoc())

{

echo "<tr>";

echo "<td class='text-center'>".$row['title']."</td>";

echo "<td class='text-center text-nowrap'>".date("d/m/Y @ H:i", $row['date'])."</td>";

echo "<td class='text-center'><a href='?/news/edit&b=".$row['id']."'>".$lang['mod/edit']."</a></td>";

echo "<td class='text-center'><a href='?/news/delete&b=".$row['id']."'>".$lang['mod/delete']."</a></td>";

echo "</tr>";

}

?>

</tbody>

</table>

<?php $mitsuba->admin->ui->endSection(); ?>