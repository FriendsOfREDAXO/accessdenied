<?php

echo rex_view::title($this->i18n('accessdenied_title'));

$form = rex_config_form::factory('accessdenied');

$field = $form->addSelectField('default_status');
$field->setLabel($this->i18n('accessdeined_settings_default_status_label'));
$select = $field->getSelect();
$select->setSize(1);
$select->addOption($this->i18n('accessdeined_settings_default_status_offline'), '0');
$select->addOption($this->i18n('accessdeined_settings_default_status_online'), '1');
$select->addOption($this->i18n('accessdeined_settings_default_status_blocked'), '2');
$field->setNotice($this->i18n('accessdeined_settings_default_status_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('accessdeined_settings'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
