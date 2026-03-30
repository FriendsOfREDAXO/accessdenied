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

$field = $form->addTextAreaField('offline_labels', null, ['class' => 'form-control accessdenied-offline-labels', 'rows' => 5, 'placeholder' => 'de_de|Versteckt' . "\n" . 'en_gb|Hidden']);
$field->setLabel($this->i18n('accessdenied_offline_labels_label'));
$field->setNotice($this->i18n('accessdenied_offline_labels_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('accessdenied_settings'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');

// Panel: Locale-Vorschläge für offline_labels
$locales = [
    'de_de' => 'Versteckt',
    'en_gb' => 'Hidden',
    'es_es' => 'Oculto',
    'it_it' => 'Nascosto',
    'pt_br' => 'Oculto',
    'ru_ru' => 'Скрыто',
    'sv_se' => 'Dold',
    'nl_nl' => 'Verborgen',
];
$localeButtons = '<p class="help-block">' . $this->i18n('accessdenied_offline_labels_presets_notice') . '</p><div class="btn-group" style="flex-wrap:wrap;gap:4px;display:flex">';
foreach ($locales as $loc => $default) {
    $entry = rex_escape($loc . '|' . $default);
    $localeButtons .= '<button type="button" class="btn btn-default btn-sm accessdenied-add-locale-btn" data-locale="' . $entry . '">' . rex_escape($loc) . '</button>';
}
$localeButtons .= '</div>';

$fragment = new rex_fragment();
$fragment->setVar('title', $this->i18n('accessdenied_offline_labels_presets_title'), false);
$fragment->setVar('body', $localeButtons, false);
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

