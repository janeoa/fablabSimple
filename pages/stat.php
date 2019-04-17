
<?php		?>

<div class="w3-container w3-teal">
	<h1>Статистика</h1>
</div>
<div class="">
	<table class="w3-table-all">
		<tr><td>Количество валидаций</td><td><?php echo overall($conn)["count"]; ?></td></tr>
		<tr><td>Количество посещений</td><td><?php echo inside($conn); ?></td></tr>
		<tr><td>Количество пользователей</td><td><?php echo userCount($conn); ?></td></tr>
	</table>
</div>


<script>
	setTimeout(function(){ location.reload(); }, 2000);
</script>