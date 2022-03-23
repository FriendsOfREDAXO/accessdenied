<?php

$form = rex_config_form::factory($this->getProperty('package'));

$field = $form->addSelectField('default_status');
$field->setLabel($this->i18n('accessdeined_settings_default_staus_label'));
$select = $field->getSelect();
$select->setSize(1);
$select->addOption($this->i18n('accessdeined_settings_default_staus_offline'), '0');
$select->addOption($this->i18n('accessdeined_settings_default_staus_online'), '1');
$select->addOption($this->i18n('accessdeined_settings_default_staus_blocked'), '2');
$field->setNotice($this->i18n('accessdeined_settings_default_staus_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('accessdeined_settings'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
