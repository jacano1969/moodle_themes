<?php

/**
 * Settings for the educator theme
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    // font size reference
    $name = 'theme_educator/fontsizereference';
    $title = get_string('fontsizereference','theme_educator');
    $description = get_string('fontsizereferencedesc', 'theme_educator');
    $default = '13';
    $choices = array(11=>'11px', 12=>'12px', 13=>'13px', 14=>'14px', 15=>'15px', 16=>'16px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // moodle 1.* like setting
    $name = 'theme_educator/noframe';
    $title = get_string('noframe','theme_educator');
    $description = get_string('noframedesc', 'theme_educator');
    $default = '0';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // Frame margin
    $name = 'theme_educator/framemargin';
    $title = get_string('framemargin','theme_educator');
    $description = get_string('framemargindesc', 'theme_educator', get_string('noframe','theme_educator'));
    $default = '15';
    $choices = array(0=>'0px', 5=>'5px', 10=>'10px', 15=>'15px', 20=>'20px', 25=>'25px', 30=>'30px', 35=>'35px', 40=>'40px', 45=>'45px', 50=>'50px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Display logo or heading
    $name = 'theme_educator/headercontent';
    $title = get_string('headercontent','theme_educator');
    $description = get_string('headercontentdesc', 'theme_educator');
    $default = '1';
    $choices = array(1=>get_string('displaylogo', 'theme_educator'), 0=>get_string('displayheading', 'theme_educator'));
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Custom site logo setting
    $name = 'theme_educator/customlogourl';
    $title = get_string('customlogourl','theme_educator');
    $description = get_string('customlogourldesc', 'theme_educator');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_RAW); // we want it accepting ../ at the beginning. Security is not at its top but Moodle trusts admins.
    $settings->add($setting);

    // Custom front page site logo setting
    $name = 'theme_educator/frontpagelogourl';
    $title = get_string('frontpagelogourl','theme_educator');
    $description = get_string('frontpagelogourldesc', 'theme_educator');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_RAW); // we want it accepting ../ at the beginning. Security is not at its top but Moodle trusts admins.
    $settings->add($setting);

    // page header background colour setting
    $name = 'theme_educator/headerbgc';
    $title = get_string('headerbgc','theme_educator');
    $description = get_string('headerbgcdesc', 'theme_educator');
    $default = '#E3DFD4';
    $previewconfig = array('selector'=>'#page-header', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // creditstomoodleorg: ctmo
    $name = 'theme_educator/creditstomoodleorg';
    $title = get_string('creditstomoodleorg','theme_educator');
    $description = get_string('creditstomoodleorgdesc', 'theme_educator');
    $default = '2';
    $choices = array(2 => get_string('ctmo_ineverypage', 'theme_educator'), 1 => get_string('ctmo_onfrontpageonly', 'theme_educator'), 0 => get_string('ctmo_no', 'theme_educator'));
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Block region width
    $name = 'theme_educator/blockcolumnwidth';
    $title = get_string('blockcolumnwidth','theme_educator');
    $description = get_string('blockcolumnwidthdesc', 'theme_educator');
    $default = '200';
    $choices = array(150=>'150px', 170=>'170px', 200=>'200px', 240=>'240px', 290=>'290px', 350=>'350px', 420=>'420px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Block padding
    $name = 'theme_educator/blockpadding';
    $title = get_string('blockpadding','theme_educator');
    $description = get_string('blockpaddingdesc', 'theme_educator');
    $default = '8';
    $choices = array(1=>'1px', 2=>'2px', 4=>'4px', 8=>'8px', 12=>'12px', 16=>'16px');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Block content background colour setting
    $name = 'theme_educator/blockcontentbgc';
    $title = get_string('blockcontentbgc','theme_educator');
    $description = get_string('blockcontentbgcdesc', 'theme_educator');
    $default = '#F6F6F6';
    $previewconfig = array('selector'=>'.block .content', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // Left column colour setting
    $name = 'theme_educator/lblockcolumnbgc';
    $title = get_string('lblockcolumnbgc','theme_educator');
    $description = get_string('lblockcolumnbgcdesc', 'theme_educator');
    $default = '#E3DFD4';
    $previewconfig = array('selector'=>'#page-content, #page-content #region-pre, #page-content #region-post-box', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // Right column colour setting
    $name = 'theme_educator/rblockcolumnbgc';
    $title = get_string('rblockcolumnbgc','theme_educator');
    $description = get_string('rblockcolumnbgcdesc', 'theme_educator');
    $default = '';
    $previewconfig = array('selector'=>'#page-content #region-post-box, #page-content #region-post', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // Foot note setting
    $name = 'theme_educator/footnote';
    $title = get_string('footnote','theme_educator');
    $description = get_string('footnotedesc', 'theme_educator');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $settings->add($setting);

    // Custom CSS file
    $name = 'theme_educator/customcss';
    $title = get_string('customcss','theme_educator');
    $description = get_string('customcssdesc', 'theme_educator');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $settings->add($setting);
}
