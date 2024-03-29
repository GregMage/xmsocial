<script type="text/javascript">
    IMG_ON = "<{xoAdminIcons 'success.png'}>";
    IMG_OFF = "<{xoAdminIcons 'cancel.png'}>";
</script>
<div>
    <{$renderbutton|default:''}>
</div>
<{if $error_message|default:'' != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$error_message}>
    </div>
<{/if}>
<{if $form|default:false}>
    <div>
        <{$form}>
    </div>
<{/if}>
<{if $social_count|default:0 != 0}>
	<div class="xm-warning-msg" style="text-align: center;">
		<{$smarty.const._MA_XMSOCIAL_WARNING_TRACKER}>
	</div>
    <table id="xo-xmdoc-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtcenter width10"><{$smarty.const._MA_XMSOCIAL_SOCIAL_RENDER}></th>
            <th class="txtleft width15"><{$smarty.const._MA_XMSOCIAL_SOCIAL_TYPE}></th>
            <th class="txtleft width15"><{$smarty.const._MA_XMSOCIAL_SOCIAL_NAME}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMSOCIAL_SOCIAL_WEIGHT}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMSOCIAL_STATUS}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMSOCIAL_ACTION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=itemsocial from=$social}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtcenter"><{$itemsocial.render}></td>
                <td class="txtleft"><{$itemsocial.type}></td>
                <td class="txtleft"><{$itemsocial.name}></td>
                <td class="txtcenter"><{$itemsocial.weight}></td>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$itemsocial.id}>" src="../assets/images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"/><img class="cursorpointer tooltip" id="sml<{$itemsocial.id}>"
                    onclick="system_setStatus( { op: 'social_update_status', social_id: <{$itemsocial.id}> }, 'sml<{$itemsocial.id}>', 'social.php' )"
                    src="<{if $itemsocial.status}><{xoAdminIcons 'success.png'}><{else}><{xoAdminIcons 'cancel.png'}><{/if}>"
                    alt="<{if $itemsocial.status}><{$smarty.const._MA_XMSOCIAL_STATUS_NA}><{else}><{$smarty.const._MA_XMSOCIAL_STATUS_A}><{/if}>"
                    title="<{if $itemsocial.status}><{$smarty.const._MA_XMSOCIAL_STATUS_NA}><{else}><{$smarty.const._MA_XMSOCIAL_STATUS_A}><{/if}>"/>
                </td>
                <td class="xo-actions txtcenter">
                    <a class="tooltip" href="social.php?op=edit&amp;social_id=<{$itemsocial.id}>" title="<{$smarty.const._MA_XMSOCIAL_EDIT}>">
                        <img src="<{xoAdminIcons 'edit.png'}>" alt="<{$smarty.const._MA_XMSOCIAL_EDIT}>"/></a>
                    <a class="tooltip" href="social.php?op=del&amp;social_id=<{$itemsocial.id}>" title="<{$smarty.const._MA_XMSOCIAL_DEL}>">
                        <img src="<{xoAdminIcons 'delete.png'}>" alt="<{$smarty.const._MA_XMSOCIAL_DEL}>"/></a>
                </td>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <div class="clear spacer"></div>
    <{if $nav_menu|default:false}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>