<?php
return [
    'adminEmail' => '18611348367@163.com',
    'supportEmail' => '18611348367@163.com',
    'user.passwordResetTokenExpire' => 3600,
    'site-keywords'=>'e油网',
    'site-desc'=>'e油网管理后台',
    'appkey'=>'23437908',//淘宝APPKEY
    'secretKey'=>'02c128a923720e3adea4af39b3e9a44c',//淘宝secretkey
    'photoUrl'=>'http://images.mass.mi2you.com/photo/',
    'uploadUrl'=>'http://images.mass.mi2you.com/',
    'baiduMapAK'=>'UbIBo7mo9wDuDz20VoEiAe8G',//百度地图ak
    'wxpayNotifyUrl'=>'http://api.mass.mi2you.com/site/wxpay-notify',//微信支付异步通知
    'alipayNotifyUrl'=>'http://api.mass.mi2you.com/site/alipay-notify',//微信支付异步通知
    'alipayConfig'=>[
        //应用ID,您的APPID。
        'app_id' => "2017040306539395",//正式账号
        'pid'=>'2088421965382161',
//         'app_id' => '2016072900115783',//沙箱账号
        
        //商户私钥，您的原始格式RSA私钥
        'merchant_private_key' => "MIIEogIBAAKCAQEAmQf9IyEWLJQXDH2Sv0Xuqg2ldx64NbWfuYfNoPALyRgVElurXU1nyQAyrlmniE4SD86Zzfcqdlcm58NZ6tK3aRdj1H13c3vEz+sOqjqnxjR82/8+zerRQ5f3HQRwU4uKkDX84gKM0dpwobH28ERubGUR35/V3amsDpkwNWaZzfsv0boCcnWmt1yrZfPvY0OzVpisOSClymnGULttaIzAeafE/eDVawmMirdBKcgahj5K8qmimFtwyNK0xDe8nYBgwdhjl77gHy3G+ZFt6waV/7C7IuZ9L9LPt7MFJK6ADCg+BKo8qTR4RhBBpDlx2A/tRdYoUbu1GJUf5TJByeUF5QIDAQABAoIBABRLzvL9zGcVLQlnDjN4HvNG5A8sb9oPwKNms4sIy0dcfk71AYFaZs1tzUr6cRHO6O5XxGZgxaz0WiCa9C4EzHaPt5nTGiii3bOFxWgmZ2IOTBERhU7iOebxHMEoeY1bEIGX53ZCSFL82btYUxwCt3KA5SH3nPHNMxiskIxEk1mSJoAS49WqLcmHpc/HU8wz/sXPnt2XcPowTYSvvOcnJlc41t40mkKaxOYiC0ce7agpUmN9mTS7cE4VmTGQO7JzSnJH2jCW5sf+RhquYhzYZKOro5KxlFUSrvJxErq5GKwIz9AMJ1/QS4CVgtcUSydrq7LivPCobsbBVm2f7+ASbQECgYEAyAnt9537SFaQ1FOxZNQ+vHh0ye60io3rWBaH6I0PHdUbHoaXNEN0qHByzFR0MFoUoO+0pro+184/2F+H//0uZERvqMYRwdHdeYeeF6gkUJnkQOBtl1uQVIxDYb/V3dv8hNU9BnYfia+LF5IxvNcCMwxlBhNwDclbqhw7oGeakNECgYEAw9eK5XfSCPmNic4h66XDQb3KNgR+Sow2k07mEkLtCgJ3vIZD19dw2x9dRcsDbY6QUaFpPcW0xuEwRpB4NiBosnWQ45FwHJFCOK650pKvVWr5YqEKEVcszbiSPWB+Dk3QqUFz03nlHxl+lX7LNHt+BpuBZYfEqRm8T8NbUDaECNUCgYBOo7itc6npkj51ekFuxhGzvhcLm4/WOFyg0Jq1TV7392Ml6PtgTHR8E1jOAxV6PK+HZTS7ptQ1uptW0JeCh2HJgS30R4mLjJlowWvhGPTNyvH0n0X2DsT6t/l1YBkPkv/+qGXJOH7FfgFMTujGuC/hKao9bT7L7LDgeyDlulUFQQKBgCocUtV8qkEbx/91v314K0Abmzt6Q92rwKB0Oqx6j5WzaiOziysCPFYhrGCxgo8wNIAZARQzSufozASgU/jvhxO4i+si/sRlx6OAjpxkxibL1cwLbKrF3/BsW6Wu9ewFd3StikZS052YUcu7c95ZH4Q0M+KtCvCBhChyjVP2JPXxAoGAaBIS9tLfF33opfYIAnES+3C+SB6HxG8j1hgItg6gu0kN4O1W0OlC1mr3RpWSIb+x7ENjSWdI95DrPC7clHOXEpXuzhveg7YuTRHwO6+xjRKD7+cmbiPUDooQve1JwRQB+lxfFVAr/EGnbGWlWZGv1EnHDQcz7QS82MQoaPYkkfU=",
        //异步通知地址
        'notify_url' => "http://api.mass.mi2you.com/site/alipay-notify",
//         'notify_url' => "http://api.eoil.mi2you.com/site/alipay-notify",
        //同步跳转
        'return_url' => "http://api.mass.mi2you.com/site/alipay-return",
        'base_path'=>"http://api.mass.mi2you.com",
        //编码格式
        'charset' => "UTF-8",
        
        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",//正式地址
//         'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",//沙箱地址
        
        //支付宝公钥
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAi3Ros5+W5GM0PCX2W7yjggLveI8YEVVu/TTi3zF5VHmV14Xhi4voTgY/rDS1vq7iDMqrjnH8f725Jp6FAe34xe/Tp5j+ma1nhe0RyG4gmwEju3MiZapbBWj60jasPEozegSeweNZ5DW3kYx+fbf7b4vbyFEtlOKib0NqGMic1Y43FfEoS5UCl+Z5IOgnG/jpTafawBjXorOtb096rNgafwuLIx1ymD/9/OIn/P7oC3NXeUPChWI4CSHOOJ37JnT6LCwTw7Dbd933Z1tRRE+WEM/99rVp9G/ekeZrnEVEglMe1FDBAu3JaUF8z7S4T2mgGmGsqyGJ8GQ1OncckqThoQIDAQAB",
        
    ]
];
