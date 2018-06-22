<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1" >
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="reader">
		<link rel="stylesheet" href="<?=ROOT?>css/style.css">
		<title><?=$title?></title>
	</head>
	<body>
		<div id="menu">
			<div class="wrap">
				<?=$menu?>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
		<div id="contain">
			<div class="wrap">
				<main>
					<?=$content?>
				</main>
			</div>
		</div>
		<footer>
			<div class="wrap">
				<div id="footer">
					&copy xlk min 2018
				</div>
			</div>
		</footer>
	</body>	
</html>