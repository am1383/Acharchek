<?php

namespace App\Modules\Admin\Http\Controllers\Web;

use Illuminate\View\View;

class MessageInboxController
{
    public function index(): View
    {
        $data = [
            'title' => 'مدیریت صندوق پستی',
        ];

        return view('admin.message_inbox', $data);
    }
}
