<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

add_hook('ClientAreaFooterOutput', 1, function($vars) {
    if (!isset($vars['cartitemcount'])) {
        $vars['cartitemcount'] = 0;
        $cartSession = \WHMCS\Session::get("cart");
        if (isset($cartSession['products']) && count($cartSession['products']) > 0) {
            $vars['cartitemcount'] += count($cartSession['products']);
        }
        if (isset($cartSession['domains']) && count($cartSession['domains']) > 0) {
            $vars['cartitemcount'] += count($cartSession['domains']);
        }
    }
    if ($vars['cartitemcount'] > 0) {
        $bgcolor = (\WHMCS\Config\Setting::getValue('FKICONBGCOLOR')) ? \WHMCS\Config\Setting::getValue('FKICONBGCOLOR') : '#FF1F1F';
        $textcolor = (\WHMCS\Config\Setting::getValue('FKICONTEXTCOLOR')) ? \WHMCS\Config\Setting::getValue('FKICONTEXTCOLOR') : '#FFFFFF';
        $script = '<script src="' . $vars['systemurl'] . '/modules/addons/tabnotification/assets/js/favico.min.js"></script>';
        return $script . "<script>$(document).ready(function() {
    var fkbadge = " . $vars['cartitemcount'] . ";
    var fkfavicon = new Favico({
        bgColor : '$bgcolor',
        textColor : '$textcolor',
    });
    fkfavicon.badge(fkbadge);
});</script>";
    }
});

add_hook('ClientAreaHeadOutput', 1, function($vars) {
    if ((\WHMCS\Config\Setting::getValue('FKICONSTATUS')) && \WHMCS\Config\Setting::getValue('FKICONURL') != '') {
        return '<link rel="shortcut icon" type="image/x-icon" href="' . \WHMCS\Config\Setting::getValue('FKICONURL') . '" />';
    }
});
