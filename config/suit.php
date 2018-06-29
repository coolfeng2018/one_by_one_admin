<?php

return [
    //拼接图片服务器
    'ImgRemoteServer'=>"http://resource.suit.wang/upload",
    'ImgRemoteUrl'=>"http://resource.suit.wang/",
    'zipFile' => "http://resource.suit.wang/upload",
    //任务
    'TaskScenes'=>['房间类型无限制','金币房','私人房'],
    'TaskLevel'=>['场次等级无限制','初级场','中级场','高级场'],

    //金币服
    'CoinServerIp'=>'192.168.1.166',
    'CoinServerPort'=>'9988',
    //抽奖等级
    'lotteryLevel'=>[
        1=>'一等奖',
        2=>'二等奖',
        3=>'三等奖',
        4=>'四等奖',
        5=>'五等奖',
        6=>'六等奖',
        7=>'七等奖',
        8=>'八等奖',
        9=>'九等奖',
        10=>'十等奖',
        11=>'十一等奖',
        12=>'十二等奖',
    ],
    'lotteryType'=>['实物','钻石','金币','房卡'],
    'newYearStart'=>strtotime('20171223'),
    'newYearEnd'=>strtotime('20171226'),
    'qrUrlInfo'=>"http://psz.partner.suit.wang/share/",
];
