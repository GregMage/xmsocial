<div>
    <{$renderbutton}>
</div>
<{if $error_message != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$error_message}>
    </div>
<{/if}>
<{if $rating_count != 0}>
    <table id="xo-xmdoc-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtleft"><{$smarty.const._MA_XMSOCIAL_RATING_DATE}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMSOCIAL_RATING_VALUE}></th>
            <th class="txtcenter width15"><{$smarty.const._MA_XMSOCIAL_RATING_UID}></th>         
            <th class="txtcenter width15"><{$smarty.const._MA_XMSOCIAL_RATING_HOSTNAME}></th>
            <th class="txtcenter width15"><{$smarty.const._MA_XMSOCIAL_RATING_MODULENAME}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMSOCIAL_ACTION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=rating from=$rating}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtleft"><{$rating.date}></td>
                <td class="txtcenter"><{$rating.value}></td>
                <td class="txtcenter"><{$rating.uid}></td>
                <td class="txtcenter"><{$rating.hostname}></td>
                <td class="txtcenter"><{$rating.modulename}></td>
                <td class="xo-actions txtcenter">
					<{if $rating.item != ''}>
					<a class="tooltip" href="<{$rating.item}>" title="<{$smarty.const._MA_XMSOCIAL_RATING_VIEW}>" target="_blank">
                        <img src="<{xoAdminIcons view.png}>" alt="<{$smarty.const._MA_XMSOCIAL_RATING_VIEW}>"></a>
					<{/if}>
                    <a class="tooltip" href="rating.php?op=del&amp;rating_id=<{$rating.id}>" title="<{$smarty.const._MA_XMSOCIAL_DEL}>">
                        <img src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._MA_XMSOCIAL_DEL}>"></a>
                </td>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <div class="clear spacer"></div>
    <{if $nav_menu}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>