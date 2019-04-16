<div class="w3-container w3-teal">
	<h1>Зарегистрированы</h1>
</div>
<div class="">
	<table class="w3-table-all">
		<tr><th>Имя</th><th>email</th><th>NU ID</th><th>UID</th></tr>
	<?php foreach (userlist($conn, true) as $item):?>
		<tr class="<?php if(empty($item["name"])) echo 'w3-hide' ?>" >
			<td><?php echo $item["name"]; ?></td>
			<td><?php echo $item["email"]; ?></td>
            <td><?php echo $item["student_id"]; ?></td>
            <td><?php echo $item["uid"]; ?></td>
		</tr>
	<?php endforeach;?>
	</ul>
</div>