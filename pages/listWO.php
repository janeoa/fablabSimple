<?php
	
	$value = get_value_of_var($conn, "last_to_reg");
	$time = get_time_of_var($conn, "last_to_reg");
	
	if(strtotime($time)<time()-180) set_value_of_var($conn, "last_to_reg", NULL);
	
	if(isset($_POST["id"])){
		set_value_of_var($conn, "last_to_reg", $_POST["id"]);
	}
	
?>

<div class="w3-container w3-teal">
	<h1>Добавить карту</h1>
</div>
<div class="w3-container <?php if($value==NULL || strtotime($time)<time()-180) echo "w3-hide"; ?>">
	<p>На очереди <span class="w3-text-red w3-tiny">(<span id="timer"><?php echo 180 - (time() - strtotime($time)); ?></span> секунд)</span></p>
	<table class="w3-table-all" id="queue">
		<?php $user = get_user_by_id($conn, $value); ?>
		<tr><th>Имя</th><th>email</th><th>NU ID</th></tr>
		<tr>
			<td><?php echo $user["name"];?></td>
			<td><?php echo $user["email"];?></td>
			<td><?php echo $user["student_id"];?></td>
		</tr>
	</table>
</div>
<div class="w3-container">
	<p>Выбрать</p>
	<table class="w3-table-all">
		<tr><th>Имя</th><th>email</th><th>NU ID</th><th></th></tr>
	<?php foreach (withoutCard($conn, true) as $item):?>
		<tr class="<?php if(empty($item["name"])) echo 'w3-hide' ?>" >
			<td><?php echo $item["name"]; ?></td>
			<td><?php echo $item["email"]; ?></td>
			<td><?php echo $item["student_id"]; ?></td>
			<td><form method="post"><input name="id" value="<?php echo $item["id"]; ?>" hidden /><button>выбрать</button></form></td>
		</tr>
	<?php endforeach;?>
	</ul>
</div>

<script>

<?php if($value!=NULL) echo	'var myVar = setInterval(decrement ,1000);'; ?>
function decrement(){
	var time = document.getElementById("timer").innerHTML;
	if(time==0) location.reload();
	time --;
	document.getElementById("timer").innerHTML = time;
}
</script>