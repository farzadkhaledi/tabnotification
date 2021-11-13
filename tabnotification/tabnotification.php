<?php
if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

use Illuminate\Database\Capsule\Manager as Capsule;

function tabnotification_config()
{
    $configarray = array(
        "name" => "Browser Tab Notification",
        "description" => "Browser Tab Notification for WHMCS",
        "version" => "1.0.0",
        "author" => "<a href='https://khaledi.website'>Farzad Khaledi</a>",
        "language" => "english",
        "fields" => array(
        )
    );
    return $configarray;
}

function tabnotification_activate()
{
    global $CONFIG;
    \WHMCS\Config\Setting::setValue('FKICONSTATUS', '');
    $img = rtrim($CONFIG['SystemURL'], '/') . '/modules/addons/tabnotification/assets/whmcs.ico';
    \WHMCS\Config\Setting::setValue('FKICONURL', $img);
    \WHMCS\Config\Setting::setValue('FKICONBGCOLOR', '#FF1F1F');
    \WHMCS\Config\Setting::setValue('FKICONTEXTCOLOR', '#ffffff');
    return array("status" => "success", "description" => "Browser Tab Notification has been activated.");
}

function tabnotification_deactivate()
{
    return array("status" => "success", "description" => "Browser Tab Notification has been deactivated.");
}

function tabnotification_output($vars)
{
    if (isset($_POST['save'])) {
        check_token("WHMCS.admin.default");
        \WHMCS\Config\Setting::setValue('FKICONSTATUS', (isset($_REQUEST['status']) ? 'ON' : ''));
        \WHMCS\Config\Setting::setValue('FKICONURL', ((isset($_REQUEST['faviconurl']) && $_REQUEST['faviconurl'] != '') ? $_REQUEST['faviconurl'] : ''));
        \WHMCS\Config\Setting::setValue('FKICONBGCOLOR', ((isset($_REQUEST['bgcolor']) && $_REQUEST['bgcolor'] != '') ? $_REQUEST['bgcolor'] : ''));
        \WHMCS\Config\Setting::setValue('FKICONTEXTCOLOR', ((isset($_REQUEST['textcolor']) && $_REQUEST['textcolor'] != '') ? $_REQUEST['textcolor'] : ''));
        redir('module=tabnotification&saved=1');
    }
    if (isset($_REQUEST['saved'])) {
        echo '<div class="alert alert-success">Changes saved successfully.</div>';
    }

    global $CONFIG;
    echo '<form action="" method="post">
        <input type="hidden" name="save" value="1">
        <table class="form" width="100%" cellspacing="2" cellpadding="3" border="0">
        <tbody><tr>
            <td class="fieldlabel" style="min-width:200px;">Use Custom Favicon</td>
            <td class="fieldarea">
                <label class="checkbox-inline">
                    <input ' . ((\WHMCS\Config\Setting::getValue('FKICONSTATUS')) ? 'checked="checked"' : '') . ' type="checkbox" name="status">
                    Tick this box if you template don\'t have any favicon to add new custom one</label>
            </td>
        </tr>
        <tr>
            <td class="fieldlabel">Favicon Path URL</td>
            <td class="fieldarea">
                <input type="text" ' . ((\WHMCS\Config\Setting::getValue('FKICONURL')) ? 'value="' . \WHMCS\Config\Setting::getValue('FKICONURL') . '"' : '') . ' name="faviconurl" class="form-control input-inline ">
                Enter your favicon path URL</td>
        </tr>
        <tr>
            <td class="fieldlabel">Background Color:</td>
            <td class="fieldarea">
                <input ' . ((\WHMCS\Config\Setting::getValue('FKICONBGCOLOR')) ? 'value="' . \WHMCS\Config\Setting::getValue('FKICONBGCOLOR') . '"' : '') . ' type="text" name="bgcolor" value="" class="colorpicker">
                Enter your favicon tab notification background color</td>
        </tr>
        <tr>
            <td class="fieldlabel">Text Color:</td>
            <td class="fieldarea">
                <input ' . ((\WHMCS\Config\Setting::getValue('FKICONTEXTCOLOR')) ? 'value="' . \WHMCS\Config\Setting::getValue('FKICONTEXTCOLOR') . '"' : '') . ' type="text" name="textcolor" value="" class="colorpicker">
                Enter your favicon tab notification text color</td>
        </tr>

    </tbody></table>
    <div class="btn-container">
    <input id="saveChanges" type="submit" value="Save Changes" class="btn btn-primary">
</div></form>';

    echo '<script type="text/javascript" src="' . $CONFIG['SystemURL'] . '/assets/js/jquery.miniColors.js"></script>
        <link rel="stylesheet" type="text/css" href="' . $CONFIG['SystemURL'] . '/assets/css/jquery.miniColors.css" /><script>$(document).ready(function(){
$(".colorpicker").miniColors();
            });</script>';
}
