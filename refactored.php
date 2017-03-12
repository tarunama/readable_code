<?php
//会員の情報を取得して、属性を付与するプログラム
require_once '../database/database.php';

// ユーザー情報を設定
function set_keys_for_query($post_data)
{
    $ary['user_id']     = $post_data['user_id'];
    $ary['user_name']   = $post_data['user_name'];
    $ary['create_date'] = $post_data['create_date'];
    return $ary;
}

// 顧客のランクを判定
function check_user_rank($user_info)
{
    // 除外条件を先に書く
    if ($user_info['sum_per_month'] < 5000 or $user_info['has_card'] === false) {
        return false;
    }

    $user_rank = get_user_rank($user_info);
    return $user_rank;
}

// ランク詳細判定
function get_user_rank($user_info)
{
    $rank = 0;
    $diff = 1;
    $sum_month = 10000;
    $times_month = 10;
    $price_in_once = 5000;

    // 女性の場合、消費が多いことにする
    if($user_info['gender'] === 2) {
        $diff = 1.2;
    }

    // ランク加算部分
    if($user_info['sum_per_month']       < $sum_month * $diff) {
        $rank += 1;
    }
    if($user_info['buy_times_per_month'] < $times_month * $diff) {
        $rank += 2;
    }
    if($user_info['buy_price_in_once']   < $price_in_once * $diff) {
        $rank += 3;
    }

    return $rank;
}

function main() {
    $sql    = $this->database->load_base_sql(); 
    $sql   .= set_keys_for_query($_POST);
    
    // QUERYの返値
    $user_info = $this->database->issue_query($sql);
    $user_rank = get_user_rank($user_info);

    return $user_rank;
}

