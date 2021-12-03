<?php

namespace App\Traits;

trait APIResponder {

    /**
     * Send a standard successful response
     * 
     * @param Object data
     * @param int status
     * @return string JSON encoded message
     */
    protected function success(Object $data, int $status = 200): string
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
        ], $status);
    }

    /**
     * Send a RFC7807 error response
     * 
     * @param array data: string title, string detail[, string type = 'generic\error'][, string instance]
     * @param int status
     * @return string JSON encoded message
     */
    protected function error(Array $data, int $status = 400): string
    {
        $dataout = [
            'detail' => $data['detail'],
            'title' => $data['title'],
            'status' => $status,
        ];
        $dataout['type'] = isset($data['type']) ? $data['type'] : 'generic\error';
        if(isset($data['instance'])) { $dataout['instance'] = $data['instance']; }

        return response()->json($dataout, $status);
    }
}
