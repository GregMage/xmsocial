
<{if $error_message|default:'' != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$error_message}>
    </div>
<{/if}>
<{if $filter|default:false}>
	<div align="right">
		<form id="form_rating_tri" name="form_rating_tri" method="post" action="rating.php">
			<{$smarty.const._MA_XMSOCIAL_RATING_UID}>
			<select name="rating_uname" id="rating_uname" onchange="location='rating.php?module=<{$module}>&item=<{$item}>&uname='+this.options[this.selectedIndex].value">
				<{$uname_options}>
			<select>
			<{$smarty.const._MA_XMSOCIAL_RATING_MODULENAME}>
			<select name="rating_module" id="rating_module" onchange="location='rating.php?uname=<{$uname}>&item=<{$item}>&module='+this.options[this.selectedIndex].value">
				<{$module_options}>
			<select>
			<{if $view_item|default:false}>
			<{$smarty.const._MA_XMSOCIAL_RATING_TITLE}>
			<select name="rating_item" id="rating_item" onchange="location='rating.php?uname=<{$uname}>&module=<{$module}>&item='+this.options[this.selectedIndex].value">
				<{$item_options}>
			<select>
			<{/if}>
			<input type='button' name='reset'  id='reset' value='<{$smarty.const._RESET}>' onclick="location='rating.php'" />
		</form>
	</div>
<{/if}>
<{if $rating_count|default:0 != 0}>
    <table id="xo-xmdoc-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
			<th class="txtcenter width5"><input name='allbox' id='allbox' onclick='xoopsCheckAll("ratinglist", "allbox");' type='checkbox' value='Check All'/></th>
            <th class="txtleft width10"><{$smarty.const._MA_XMSOCIAL_RATING_DATE}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMSOCIAL_RATING_VALUE}></th>
            <th class="txtcenter width15"><{$smarty.const._MA_XMSOCIAL_RATING_UID}></th>         
            <th class="txtcenter width15"><{$smarty.const._MA_XMSOCIAL_RATING_HOSTNAME}></th>
            <th class="txtcenter width15"><{$smarty.const._MA_XMSOCIAL_RATING_MODULENAME}></th>
			<{if $view_item|default:false}>
				<th class="txtleft"><{$smarty.const._MA_XMSOCIAL_RATING_TITLE}></th>
			<{/if}>
            <th class="txtcenter width10"><{$smarty.const._MA_XMSOCIAL_ACTION}></th>
        </tr>
        </thead>
		<form name='ratinglist' id='commentslist' action='rating.php?op=purge' method="post">
			<tbody>
			<{foreach item=itemrating from=$rating}>
				<tr class="<{cycle values='even,odd'}> alignmiddle">
					<td class="txtcenter"><input type='checkbox' name='ratinglist_id[]' id='ratinglist_id[]' value='<{$itemrating.id}>'/></td>
					<td class="txtleft"><{$itemrating.date}></td>
					<td class="txtcenter"><{$itemrating.value}></td>
					<td class="txtcenter"><{$itemrating.uid}></td>
					<td class="txtcenter"><{$itemrating.hostname}></td>
					<td class="txtcenter">
						<{$itemrating.modulename}>
						<{if $itemrating.isactive == 0}>
							<span style="color:red; font-weight:bold;"><{$smarty.const._MA_XMSOCIAL_RATING_MODULENOACTIVE}></span>
						<{/if}>
						
					</td>
					<{if $view_item|default:false}>
						<td class="txtleft"><{$itemrating.title}></td>
					<{/if}>
					<td class="xo-actions txtcenter">
						<{if $itemrating.item != ''}>
						<a class="tooltip" href="<{$itemrating.item}>" title="<{$smarty.const._MA_XMSOCIAL_RATING_VIEW}>" target="_blank">
							<img src="<{xoAdminIcons 'view.png'}>" alt="<{$smarty.const._MA_XMSOCIAL_RATING_VIEW}>"></a>
						<{/if}>
						<a class="tooltip" href="rating.php?op=del&amp;rating_id=<{$itemrating.id}>" title="<{$smarty.const._MA_XMSOCIAL_DEL}>">
							<img src="<{xoAdminIcons 'delete.png'}>" alt="<{$smarty.const._MA_XMSOCIAL_DEL}>"></a>
					</td>
				</tr>
			<{/foreach}>
            <tr>
                <td class="txtcenter"><input type='submit' name='<{$smarty.const._DELETE}>' value='<{$smarty.const._DELETE}>'/></td>
            </tr>
			</tbody>			
		</form>
    </table>
    <div class="clear spacer"></div>
    <{if $nav_menu|default:false}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>