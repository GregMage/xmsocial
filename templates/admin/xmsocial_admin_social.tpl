<script type="text/javascript">
    IMG_ON = '<{xoAdminIcons success.png}>';
    IMG_OFF = '<{xoAdminIcons cancel.png}>';
</script>
<div>
    <{$renderbutton}>
</div>
<{if $error_message != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$error_message}>
    </div>
<{/if}>
<{if $form}>
    <div>
        <{$form}>
    </div>
<{/if}>
<{if $social_count != 0}>
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
        <{foreach item=social from=$social}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtcenter"><{$social.render}></td>
                <td class="txtleft"><{$social.type}></td>
                <td class="txtleft"><{$social.name}></td>
                <td class="txtcenter"><{$social.weight}></td>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$social.id}>" src="../assets/images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"/><img class="cursorpointer tooltip" id="sml<{$social.id}>"
                    onclick="system_setStatus( { op: 'social_update_status', social_id: <{$social.id}> }, 'sml<{$social.id}>', 'social.php' )"
                    src="<{if $social.status}><{xoAdminIcons success.png}><{else}><{xoAdminIcons cancel.png}><{/if}>"
                    alt="<{if $social.status}><{$smarty.const._MA_XMSOCIAL_STATUS_NA}><{else}><{$smarty.const._MA_XMSOCIAL_STATUS_A}><{/if}>"
                    title="<{if $social.status}><{$smarty.const._MA_XMSOCIAL_STATUS_NA}><{else}><{$smarty.const._MA_XMSOCIAL_STATUS_A}><{/if}>"/>
                </td>
                <td class="xo-actions txtcenter">
                    <a class="tooltip" href="social.php?op=edit&amp;social_id=<{$social.id}>" title="<{$smarty.const._MA_XMSOCIAL_EDIT}>">
                        <img src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._MA_XMSOCIAL_EDIT}>"/></a>
                    <a class="tooltip" href="social.php?op=del&amp;social_id=<{$social.id}>" title="<{$smarty.const._MA_XMSOCIAL_DEL}>">
                        <img src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._MA_XMSOCIAL_DEL}>"/></a>
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