<div class="row" id="result" style="margin-top: 50px;">
	<div class="col-md-12">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Услуга</th>
					<th>Баланс на начало периода</th>
					<th>Приход</th>
					<th>Расход</th>
					<th>Перерасчет</th>
					<th>Итого</th>
				</tr>
			</thead>
			<tbody>
				<?foreach($data as $result):?>
					<tr>
						<td><?=$result['name'];?></td>
						<td><?=$result['balance_begin'];?></td>
						<td><?=$result['pay_come'];?></td>
						<td><?=$result['pay_out'];?></td>
						<td><?=$result['recalculation'] ?? 0;?></td>
						<td><?=$result['balance_end'];?></td>
					</tr>
				<?endforeach;?>
			</tbody>
		</table>
	</div>
</div>