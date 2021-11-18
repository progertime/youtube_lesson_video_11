<? include_once 'ajax.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Html форма с отправкой данных на аяксе</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<style>
			.bd-placeholder-img {
				font-size: 1.125rem;
				text-anchor: middle;
				-webkit-user-select: none;
				-moz-user-select: none;
				user-select: none;
			}

			@media (min-width: 768px) {
				.bd-placeholder-img-lg {
					font-size: 3.5rem;
				}
			}
		</style>
</head>
<body class="bg-light">
<div class="container">
	<main>
		<div class="row g-5">
			<div class="col-md-7 col-lg-8">
				<h4 class="mt-3 mb-3">Форма отправки данных на сервер</h4>
				<form class="form js--ajax-form">
					<div class="form__message"></div>
					<div class="row g-3">
						<?foreach($arParams['FIELDS'] as $arField){?>
							 <div class="col-12 form__field-wrap" data-field="FIELDS__<?=$arField['CODE']?>">
								 <?if($arField['TYPE'] != 'checkbox'){?>
								 <div class="form__field-message" data-field-message="FIELDS__<?=$arField['CODE']?>"></div>
									 <div class="form-label"><?=$arField['TITLE']?></div>
								 <?}?>
							<?if($arField['TYPE'] == 'checkbox'){?>
								<label class="form-check">
									<input type="checkbox" class="form-check-input form__field" name="FIELDS[<?=$arField['CODE']?>]">
									<span class="form-check-label">
												<span class="form__field-message" data-field-message="FIELDS__<?=$arField['CODE']?>"></span>
										<?=$arField['TITLE']?>
											</span>
								</label>
							 <?} else if($arField['TYPE'] == 'input'){?>
								<input type="text" class="form-control form__field" name="FIELDS[<?=$arField['CODE']?>]">
							 <?} else if($arField['TYPE'] == 'textarea'){?>
								<textarea type="text" class="form-control form__field" name="FIELDS[<?=$arField['CODE']?>]"></textarea>
							 <?} else if($arField['TYPE'] == 'select'){?>
									<select class="form-select form__field" name="FIELDS[<?=$arField['CODE']?>]">
										<option value="">выберите из списка...</option>
										<?foreach($arField['VALUES'] as $kOption=>$option){?>
											<option value="<?=$kOption?>"><?=$option?></option>
										<?}?>
								</select>
							 <?}?>
							 </div>
						<?}?>
						<div class="col-12">
							<button class="btn btn-primary btn-lg" type="submit">Отправить</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</main>
</div>
<script src="js/script.js"></script>
</body>
</html>