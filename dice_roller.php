<?php
/*
Plugin Name: Dice Roller
Plugin URI: https://darrylch.com
Description: Dice Rolling API
Author: Darryl
Version: 1.0
*/

defined('ABSPATH') or die;

add_action('rest_api_init', function () {
	register_rest_route( 'dch-json/v1', '/dice_roller', array(
		'methods'  => 'GET',
		'callback' => 'dch_dice_roller'
	));
});

function dch_dice_roller(WP_REST_Request $request){
    $amount = isset($request['amount']) ? (int)sanitize_text_field($request['amount']) : 1; // of dice
    $sides = isset($request['sides']) ? (int)sanitize_text_field($request['sides']) : 6; // of die
    $rolls = isset($request['rolls']) ? (int)sanitize_text_field($request['rolls']) : 1; // number of rolls to return
    $sort_min = isset($request['sort_min']) ? (int)sanitize_text_field($request['sort_min']) : 4; // min number to sort

    if(!is_numeric($amount)){ return 'amount must be a number'; }
    if($amount<1) $amount=1;
    if(!is_numeric($sides)){ return 'sides must be a number'; }
    if($sides<1) $sides=1;
    if(!is_numeric($rolls)){ return 'sides must be a number'; }
    if($rolls<1) $rolls=1;

    $rolls_array = [];
    
    //rolls
    for($j=0;$j<$rolls;$j++){
        $roll_set = [];
        $roll_meta = [];
        $roll_sort = [
            'gt'=>0,
            'lt'=>0
        ];

        //roll the dice
        for($i=0;$i<$amount;$i++){
            $roll_value = mt_rand(1, $sides);

            $roll_set[] = $roll_value;

            if(!isset($roll_meta[$roll_value])){
                $roll_meta[$roll_value] =1;
            } else {
                $roll_meta[$roll_value] = $roll_meta[$roll_value]+1;
            }

            if($roll_value>=$sort_min){
                $roll_sort['gt'] = $roll_sort['gt']+1;
            } else {
                $roll_sort['lt'] = $roll_sort['lt']+1;
            }
        }
        $rolls_array[] = [
            'roll'=> $roll_set,
            'roll_meta'=> [
                'roll_groups'=>$roll_meta,
                'sorting_value'=>$sort_min,
                'sorting' =>$roll_sort
            ]
        ];
    }
    
    //build json
    $return_array = [
        'rolls' => $rolls_array,
        'request' => [
            'amount_of_dice' => $amount,
            'sides' => $sides,
            'number_of_rolls' => $rolls
        ]
    ];
    // return json_encode($return_array);
    return $return_array;
}