<?php

use Darksky\Darksky as Darksky;

class Darksky_data_API extends CI_Model
{
    private static $darksky_api_key = '6cdebbd845d94c2f60fbc3a97149ad6b';
    
    public static function get_darksky_data($data)
    {
        $timestamp = dateTime::createFromFormat('d/M/Y', $data['date_requested'], new dateTimeZone('GMT'))->getTimestamp();
        $response = json_decode((new Darksky(self::$darksky_api_key))->timeMachine($data['lat'], $data['lng'], $timestamp));
        $daily_data = current($response->daily->data);
        $darksky_data_entry = new Darksky_data($daily_data);
        $darksky_data_entry->set_sunrise_time(date('Y-m-d', $daily_data->sunriseTime));
        $darksky_data_entry->set_sunset_time(date('Y-m-d', $daily_data->sunsetTime));
        $darksky_data_entry->set_temp_high($daily_data->temperatureHigh);
        $darksky_data_entry->set_temp_low($daily_data->temperatureLow);
        $darksky_data_entry->set_windspeed($daily_data->windSpeed);
        $darksky_data_entry->set_dewpoint($daily_data->dewPoint);
        $darksky_data_entry->set_date_requested(date('Y-m-d', $timestamp));
        $darksky_data_entry->set_lat($data['lat']);
        $darksky_data_entry->set_lng($data['lng']);
        $darksky_data_entry->set_user_id($data['user_id']);
        $darksky_data_entry->set_time(date('Y-m-d', $daily_data->time));
        $darksky_data_entry->save();
        
        return $darksky_data_entry;
    }
}