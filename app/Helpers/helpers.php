<?php

if(!function_exists('getRecord')) {
    function getRecord($model, $id)
    {
       return  \App\Models\Artist::find($id);
    }
}
