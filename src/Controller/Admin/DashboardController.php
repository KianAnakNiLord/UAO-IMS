<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        $borrowingsTable = $this->fetchTable('Borrowings');
        $pending = $this->fetchTable('Borrowings')->find()->where(['status' => 'pending'])->all();
        $this->set(compact('pending'));
        
    }
}
