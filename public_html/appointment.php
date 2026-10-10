<?php
require dirname(__DIR__) . '/app/config/env.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require dirname(__DIR__) . '/app/src/Domains/Appointments/LeadAppointmentController.php';
(new \App\Domains\Appointments\LeadAppointmentController())->handle();
