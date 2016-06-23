<?php

use Carbon\Carbon;

function datetime_tz(Carbon $datetime)
{
    return $datetime->copy()->setTimezone('Asia/Tokyo')->format("Y-m-d H:i");
}