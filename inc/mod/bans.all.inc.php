<?php

if (!defined("IN_MOD"))

{

	die("Nah, I won't serve that file to you.");

}

$mitsuba->admin->reqPermission("bans.view");

$delete = $mitsuba->admin->checkPermission("bans.delete");

$logs = $mitsuba->admin->checkPermission("logs.view");

?>

<?php $mitsuba->admin->ui->startSection(''); ?>

<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $lang['mod/all_bans']?></h3>

              <div class="box-tools">
	              <a href="?/bans"><?php printf($lang['mod/showing_bans'], 15); ?></a>
	              | <?php echo $lang['mod/show_all']; ?>
	              | <a href="?/bans/recent&c=100"><?php printf($lang['mod/show_recent'], 100); ?></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th><?php echo $lang['mod/ip']; ?></th>
                  <th><?php echo $lang['mod/reason']; ?></th>
                  <th><?php echo $lang['mod/staff_note']; ?></th>
                  <th><?php echo $lang['mod/created']; ?></th>
                  <th><?php echo $lang['mod/expires']; ?></th>
                  <th><?php echo $lang['mod/boards']; ?></th>
                  <th><?php echo $lang['mod/seen']; ?></th>
                  <th><?php echo $lang['mod/delete']; ?></th>
                  <?php
	                  if ($logs) { echo "<th>".$lang['mod/staff_member']."</th>"; }
	              ?>
                </tr>
                <?php
	                $_data = $conn->query("SELECT short FROM boards");
	                $_boards = array();
	                while ($row = $_data->fetch_assoc()) $_boards[] = $row['short'];
	                if ($logs) {
		                $result = $conn->query("SELECT bans.*, users.username FROM bans LEFT JOIN users ON bans.mod_id=users.id ORDER BY created DESC;");
		            } else {
			            $result = $conn->query("SELECT * FROM bans ORDER BY created;");
			        }
			        while ($row = $result->fetch_assoc()){
				        echo "<tr>";
				        echo "<td>".$row['ip']."</td>";
				        echo "<td>".$row['reason']."</td>";
				        echo "<td>".$row['note']."</td>";
				        echo "<td>".date("d/m/Y @ H:i", $row['created'])."</td>";
				        if ($row['expires'] != 0){
					        echo "<td>".date("d/m/Y @ H:i", $row['expires'])."</td>";
					    } else {
						    echo "<td class='text-center'><b>never</b></td>";
						}
						if ($row['boards']=="%"){
							echo "<td class='text-center'>All boards</td>";
						} else {
							$banBoards = explode(',', $row['boards']);
							if (0.6 * sizeof($_boards) < sizeof($banBoards)){
								echo "<td class='text-center'>All boards <b>excluding</b>: ".implode(', ', array_diff($_boards, $banBoards))."</td>";
							} else {
								echo "<td class='text-center'>".implode(', ', $banBoards)."</td>";
							}
						}
						if ($row['seen']==1){
							echo "<td class='text-center'>YES</td>";
						} else {
							echo "<td class='text-center'><b>NO</b></td>";
						}
						if ($delete){
							echo "<td class='text-center'><a href='?/bans&del=1&b=".$row['id']."'>".$lang['mod/delete']."</a></td>";
						} else {
							echo "<td></td>";
						}
						if ($logs){
							echo "<td>".$row['username']."</td>";
						}
						echo "</tr>";
					}
?>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
	<?php $mitsuba->admin->ui->endSection(); ?>