<?php
/** @var rex_addon $this */
$clientIp = rex_server('REMOTE_ADDR', 'string', '');

$form = rex_config_form::factory('accessdenied');
$field = $form->addSelectField('default_status');
$field->setLabel($this->i18n('accessdenied_settings_default_status_label'));
$select = $field->getSelect();
$select->setSize(1);
$select->addOption($this->i18n('accessdenied_settings_default_status_offline'), '0');
$select->addOption($this->i18n('accessdenied_settings_default_status_online'), '1');
$select->addOption($this->i18n('accessdenied_settings_default_status_blocked'), '2');
$field->setNotice($this->i18n('accessdenied_settings_default_status_notice'));

$field = $form->addSelectField('inherit');
$field->setLabel($this->i18n('accessdenied_settings_inherit_label'));
$select = $field->getSelect();
$select->setSize(1);
$select->addOption($this->i18n('accessdenied_settings_inherit_off'), false);
$select->addOption($this->i18n('accessdenied_settings_inherit_on'), true);

$field = $form->addInputField('text', 'linkparameter', null, ['class' => 'form-control']);
$field->setLabel($this->i18n('linkparameter'));
$field->getValidator()->add('notEmpty', $this->i18n('linkparameter_empty'));
$field->getValidator()->add('match', $this->i18n('linkparameter_wrong'), '/^[a-zA-Z0-9_.-]+$/');

$field = $form->addTextAreaField('ip_whitelist', null, ['class' => 'form-control accessdenied-ip-whitelist', 'rows' => 6]);
$field->setLabel($this->i18n('accessdenied_ip_whitelist_label'));
$field->setNotice($this->i18n('accessdenied_ip_whitelist_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('accessdenied_settings'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');

// Panel: aktuelle IP anzeigen + per Klick zur Liste hinzufügen
if ($clientIp !== '') {
    $ipPanel = '<p>' . $this->i18n('accessdenied_your_ip') . ' <strong>' . rex_escape($clientIp) . '</strong></p>'
        . '<button type="button" class="btn btn-default accessdenied-add-ip-btn" data-ip="' . rex_escape($clientIp) . '">'
        . $this->i18n('accessdenied_add_my_ip')
        . '</button>';

    $fragment = new rex_fragment();
    $fragment->setVar('title', $this->i18n('accessdenied_ip_whitelist_current_ip_section'), false);
    $fragment->setVar('body', $ipPanel, false);
    echo $fragment->parse('core/page/section.php');
}

