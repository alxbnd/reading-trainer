<ul>
	<? foreach ($index as $k=>$v) {
		 if ($v != '.' && $v != '..') { ?>
			<li>
				<a href="<?=ROOT?>text/read/<?=$v?>"><?=$v?></a>
			</li>
	<? }} ?>
</ul>