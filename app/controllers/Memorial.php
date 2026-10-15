<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/** Shared presentation setup; no authentication or persistence is implied. */
class Memorial extends Controller
{
    protected function render($area, $page, $detail = null)
    {
        $map = require APP_DIR . 'config/memorial.php';
        $this->call->helper('url');
        $this->call->model('Demo_model');
        $plans = $this->Demo_model->plans();

        $validDetail = $detail === null
            || ($area === 'public' && isset($plans[$detail]))
            || in_array($detail, $map['children'][$area][$page] ?? [], true);
        if (!isset($map[$area][$page]) || !$validDetail) {
            show_404('', '', 'memorial_404');
            return;
        }

        $schedule = $this->Demo_model->schedule();
        $dates = array_column(array_slice($schedule, 1), 0);
        $methods = ['GCash', 'Bank Transfer', 'Credit / Debit Card'];
        $selectedDate = $_GET['installment'] ?? '';
        $selectedMethod = $_GET['preview_method'] ?? '';

        $this->call->view('memorial/layout', [
            'area' => $area,
            'page' => $page,
            'detail' => $detail,
            'map' => $map,
            'title' => $detail && $area === 'public' ? $plans[$detail]['name'] : $map[$area][$page],
            'plans' => $plans,
            'schedule' => $schedule,
            'table' => $this->Demo_model->table($page === 'dashboard' ? 'payments' : $page),
            'checkoutDate' => is_string($selectedDate) && in_array($selectedDate, $dates, true)
                ? $selectedDate : $dates[0],
            'checkoutMethod' => is_string($selectedMethod) && in_array($selectedMethod, $methods, true)
                ? $selectedMethod : $methods[0],
        ]);
    }
}
