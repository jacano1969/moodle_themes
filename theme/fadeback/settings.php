<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

// logo image setting
	$name = 'theme_fadeback/logo';
	$title = get_string('logo','theme_fadeback');
	$description = get_string('logodesc', 'theme_fadeback');
	$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
	$settings->add($setting);


	// link color setting
	$name = 'theme_fadeback/linkcolor';
	$title = get_string('linkcolor','theme_fadeback');
	$description = get_string('linkcolordesc', 'theme_fadeback');
	$default = '#185f61';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);

	// link hover color setting
	$name = 'theme_fadeback/linkhover';
	$title = get_string('linkhover','theme_fadeback');
	$description = get_string('linkhoverdesc', 'theme_fadeback');
	$default = '#666666';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);
}