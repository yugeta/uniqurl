# UniqueURL
    wrote  @ yugeta.koji
    ver0.1 @ 2015. 3.15


# 概要
    URLリダイレクト

# 構成
    [framework]
    access.php
    access.dat
    log/yyyymmdd.log

# 仕様
    [access.dat]
    ID,protocol,domain,uri,entry(YYYYMMDDHHIISS)

    ID @
    protocol @  ["":http s:https other:@port-number]
    domain @ [---.---.com...]
    uri @ ドメインより下の文字列

# フロー
    1.

# 使い方
    【管理画面】
    http://tools/uniqurl/index.php

    【urlアクセス】
    http://tools/uniqurl/%id%

    

# その他
