<div class="w3-container w3-teal">
	<h1>История входа</h1>
</div>
<div class="">
	<table class="w3-table-all">
		<tr><th>Имя</th><th>id студента</th><th>время</th><th>статус</th></tr>
	<?php foreach (history($conn, true) as $item):?>
		<tr class="<?php if(empty($item["uid"])) echo 'w3-hide' ?>" >
			<td><?php echo $item["uid"]; ?></td>
<!-- 			<td><?php echo $item["email"]; ?></td> -->
            <td><?php echo $item["student_id"]; ?></td>
            <td><?php echo $item["time"]; ?></td>
            <td><?php echo $item["inside"]; ?></td>
<!--             <td><?php echo $item["uid"]; ?></td> -->
		</tr>
	<?php endforeach;?>
	</ul>
</div>