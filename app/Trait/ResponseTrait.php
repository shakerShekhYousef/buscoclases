<?php

namespace App\Trait;

trait ResponseTrait
{
    /**
     * send success response
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    public function success($data = null)
    {
        return response()->json([
            'status' => 1,
            'message' => 'success',
            'data' => $data,
        ]);
    }

    /**
     * send error response
     *
     * @param  string  $message
     * @return \Illuminate\Http\Response
     */
    public function error($message = null)
    {
        $error = 'server error';
        if ($message != null) {
            $error = $message;
        }

        return response()->json(['status' => 0, 'message' => $error], 500);
    }

    /**
     * send not found response
     *
     * @param  string  $message
     * @return \Illuminate\Http\Response
     */
    public function not_found($message)
    {
        return response()->json(['status' => 0, 'message' => $message], 404);
    }

    /**
     * send forbidden response
     *
     * @param  string  $message
     * @return \Illuminate\Http\Response
     */
    public function forbidden($message)
    {
        return response()->json(['status' => 0, 'message' => $message], 403);
    }

    /**
     * send unauthorized response
     *
     * @return \Illuminate\Http\Response
     */
    public function unauthorized($message = null)
    {
        return response()->json(['status' => 0, 'message' => $message ?? 'Unauthorized']);
    }
}
