<?php

if (!function_exists('alert_message')) {

    function alert_message($message, $status = '') {
        $str = "";

        switch ($status) {
            case 'success' :
                $str .= '<div class="alert alert-success alert-dismissable">';
                break;
            case 'error' :
                $str .= '<div class="alert alert-danger alert-dismissable">';
                break;
            case 'info' :
                $str .= '<div class="alert alert-info alert-dismissable">';
                break;
            case 'warning' :
                $str .= '<div class="alert alert-warning alert-dismissable">';
                break;
            default :
                $str .= '<div class="alert alert-info alert-dismissable">';
                break;
        }
        $str .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        $str .= $message;
        $str .= '</div>';

        return $str;
    }

}