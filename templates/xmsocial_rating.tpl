<small>
	<div class="xmsocial_ratingblock">
		<div id="unit_long<{$xmsocial_itemid}>">
			<div id="unit_ul<{$xmsocial_itemid}>" class="xmsocial_unit-rating">
				<div class="xmsocial_current-rating" style="width:<{$xmsocial_size}>;"></div>
				<{foreach item=itemstars from=$xmsocial_stars}>
				<div>
					<a class="xmsocial_r<{$itemstars}>-unit rater" href="<{$xoops_url}>/modules/xmsocial/rate.php?moduleid=<{$xmsocial_moduleid}>&amp;itemid=<{$xmsocial_itemid}>&amp;rating=<{$itemstars}>" title="<{$itemstars}>" rel="nofollow"><{$itemstars}></a>
				</div>
				<{/foreach}>
			</div>
			<div>
				<{$smarty.const._MA_XMSOCIAL_RATING_RATING}>: <{$xmsocial_rating}> / <{$xmsocial_total}> (<{$xmsocial_votes}>)
			</div>
		</div>
	</div>
</small>