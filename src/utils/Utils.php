<?php

class Utils {
    public static function printLogs($logs = array()) {
        $map = array('danger' => 'error');

        foreach($logs as $log) {
            $logType = array_key_exists($log['type'], $map) ? $map[$log['type']] : $log['type'];

            echo '<div class="has-text-' . $log['type'] . '">' .
                '[' . ucfirst(strtolower($logType)) . '] > ' . $log['msg'] .
            '</div>';
        }
    }
}

?>