<?php
error_reporting(E_ALL);
include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../config.php';
include __DIR__ . '/../backend/FormHandler.php';

if (isset($_POST['form-action'])) {
    $formHandler = new \OpenHive\LP\FormHandler($_POST);
    $formHandler->handle($_POST['form-action']);
}

header('Location: /');
