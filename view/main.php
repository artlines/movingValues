<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
	<title>Главная</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<hr />
			</div>
			<form>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<label for="date_range">Выберите отчетный месяц</label>
					<input type="text" class="form-control" name="date_range" required>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<label for="type">Выберите тип клиента</label>
					<select class="form-control" name="client_type">
						<option value="">---</option>
						<?foreach($data['types'] as $type):?>
							<option value="<?=$type['type']?>"><?=$type['type']==1?'Физическое лицо':'Юридическое лицо'?></option>
						<?endforeach;?>
					</select>
				</div>
				<div class="col-xs-12">
					<hr />
					<input type="submit" class="btn btn-primary" value="Смотреть">
				</div>
				<input type="hidden" name="date_start" value="" />
				<input type="hidden" name="date_end"  value="" />
			</form>
		</div>
		<div class="out" style="margin-top: 20px;"></div>
	</div>
	<script src="../assets/js/jquery.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<script src="../assets/js/main.js"></script>
</body>
</html>