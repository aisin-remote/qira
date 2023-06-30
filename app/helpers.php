<?php

if(!function_exists('startOfDay')){
    function startOfDay($tanggal = null)
    {
        if($tanggal != null){

            //if today less than 6am then return yesterday 6am else return today 6am
            if(date('H') < 6){
                return date('Y-m-d 06:00:00', strtotime($tanggal . ' -1 day'));
            }
            return date('Y-m-d 06:00:00', strtotime($tanggal));
        }else{
            //get today, if today less than 6am then return yesterday 6am else return today 6am
            if(date('H') < 6){
                return date('Y-m-d 06:00:00', strtotime('yesterday'));
            }

            return date('Y-m-d 06:00:00', strtotime('today'));
        }
    }
}

if(!function_exists('endOfDay')){
    function endOfDay($tanggal = null)
    {


        if($tanggal != null){

            //if today less than 6am then return yesterday 6am else return today 6am
            if(date('H') < 6){
                return date('Y-m-d 06:00:00', strtotime($tanggal));
            }
            return date('Y-m-d 06:00:00', strtotime($tanggal . ' +1 day'));
        }else{
            //get today, if today less than 6am then return yesterday 6am else return today 6am
            if(date('H') < 6){
                return date('Y-m-d 06:00:00', strtotime('today'));
            }
            return date('Y-m-d 06:00:00', strtotime('tomorrow'));
        }
    }

}

if(!function_exists('startOfWeek')){
    function startOfWeek($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = date('Y-m-d'); // Use current date if not provided
        }

        $startOfWeek = date('d-m-Y 06:00:00', strtotime($tanggal . ' -' . (date('w', strtotime($tanggal)) - 1) . ' days'));
        return startOfDay($startOfWeek);
    }
}

if(!function_exists('endOfWeek')){
    function endOfWeek($tanggal = null)
    {
        if (!$tanggal) {
            $date = date('Y-m-d'); // Use current date if not provided
        }

        $endOfWeek = date('d-m-Y 06:00:00', strtotime($tanggal . ' +' . (7 - date('w', strtotime($tanggal))) . ' days'));

        return endOfDay($endOfWeek);
    }
}

if(!function_exists('startOfMonth')){
    function startOfMonth($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = date('Y-m-d'); // Use current date if not provided
        }

        $startOfMonth = date('d-m-Y 06:00:00', strtotime($tanggal . ' -' . (date('d', strtotime($tanggal)) - 1) . ' days'));
        return startOfDay($startOfMonth);
    }
}

if(!function_exists('endOfMonth')){
    function endOfMonth($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = date('Y-m-d'); // Use current date if not provided
        }

        $endOfMonth = date('d-m-Y 06:00:00', strtotime($tanggal . ' +' . (date('t', strtotime($tanggal)) - date('d', strtotime($tanggal))) . ' days'));

        return endOfDay($endOfMonth);
    }
}
