<?php
//会員の情報を取得して、属性を付与するプログラム
require_once '../database/database.php';

// ユーザー情報を取得
function set_keys_for_query($_POST)
{
    $ary['user_id']     = $_POST['user_id'];
    $ary['user_name']   = $_POST['user_name'];
    $ary['create_date'] = $_POST['create_date'];
    return $ary;
}

// 顧客のランクを判定
function judge_customer_rank($user_info)
{
    // 除外条件先に書く
    if($user_info['sum_per_month'] < 5000) return false;
    if($user_info['has_card'] === false) return false;

    $user_rank = judge_detail($user_info);
    return $user_rank;
}

// ランク詳細判定
function judge_detail($user_info)
{
    $rank = 0;
    $diff = 1;
    $sum_month = 10000;
    $times_month = 10;
    $price_in_once = 5000;
    // 女性の場合、消費が多いことにする
    if($user_info['gender'] === 2) $diff = 1.2;

    if($user_info['sum_per_month']       < $sum_month * $diff) $rank += 1;
    if($user_info['buy_times_per_month'] < $times_month * $diff) $rank += 2;
    if($user_info['buy_price_in_once']   < $price_in_once * $diff) $rank += 3;

    return $rank;
}

$sql    = $this->database->load_base_sql(); 
$sql   .= set_keys_for_query($_POST);
// QUERYの返値
$user_info = $this->database->issue_query($sql);
$user_rank = judge_customer_rank($user_info);

return $user_rank;
