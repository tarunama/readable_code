<?php
//会員の情報を取得して、属性を付与するプログラム

// ユーザー情報が格納されている配列
$prm['id'] = $_POST['u_id'];
$prm['name'] = $_POST['u_name'];
$prm['cre_date'] = $_POST['create_date'];

// QUERYの返値
$ret = $this->database($sql);

// ひと月の購入金額が5000以上である場合
if($ret['sum'] >= 5000){
	// 性別が男性だった場合
	if($ret['gender'] == 1){
		if($ret['chnnl'] == '1'){
			if($ret['sum'] >= 100000){
				$txt = "VIP会員" . $prm['name'] . "様\n";
				$vip = 1;
			}else{
				$txt = $prm['name'] . "さん\n";
				$vip = 0;
			}
		}
	// 性別が女性だった場合
	}else{
		if($ret['chnnl'] == '1'){
			if($ret['sum'] >= 100000){
				$txt = "VIP会員" . $prm['name'] . "様\n";
				$vip = 1;
			}else{
				$txt = $prm['name'] . "さん\n";
				$vip = 0;
			}
		}
	}
}
?>
