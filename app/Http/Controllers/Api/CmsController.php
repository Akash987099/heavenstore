<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMS;

class CmsController extends Controller
{
    protected $cms;

    public function __construct()
    {
        $this->cms = new CMS();
    }

    public function cms()
    {
        try {
            $cms = $this->cms
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->get(['name', 'url', 'description']);

            return response()->json([
                'status' => true,
                'data'   => $cms
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data'   => []
            ], 500);
        }
    }
}
