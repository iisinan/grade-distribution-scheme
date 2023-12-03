<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = array(
    'local/grade_encryption_aes:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
        ),
    ),
    'local/grade_encryption_aes:edit' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
        ),
    ),
);
