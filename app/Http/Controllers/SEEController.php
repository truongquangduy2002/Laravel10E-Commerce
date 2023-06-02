<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SEEController extends Controller
{
    public function sendSSEData()
    {
        $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        $data = [];

        foreach ($tables as $table) {
            $data[$table] = $this->getTableData($table);
        }

        $this->sendSSE($data);
    }

    public function getTableData($table)
    {
        // Thực hiện truy vấn để lấy dữ liệu từ $table
        // Ví dụ: $data = DB::table($table)->get();
        $data = []; // Thay thế dòng này bằng truy vấn thực tế

        return $data;
    }

    public function sendSSE($data)
    {
        $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($data) {
            echo "data: " . json_encode($data) . "\n\n";
            flush();
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }
}
