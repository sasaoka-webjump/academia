<?php

namespace App\Controllers;

class HealthController
{

    /**
     * Just to check the API stability
     */
    public function hello()
    {
        return response()->json([
            'message' => 'Ok!'
        ]);
    }
}
