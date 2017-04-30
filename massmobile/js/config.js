var serverBaseUrl="http://api.mass.mi2you.com/";
var photoUrl="http://images.mass.mi2you.com/photo/";
var avatarUrl="http://images.mass.mi2you.com/photo/";
//var serverBaseUrl="http://api.51eu.cc/";
//var photoUrl="http://images.51eu.cc/photo/";
//var avatarUrl="http://images.51eu.cc/photo/";
var config={
	autoLoginUrl:serverBaseUrl+'site/auto-login',
	checkUpdateUrl:serverBaseUrl+"site/check-update",//检查登录url
	checkMobile:serverBaseUrl+"site/check-mobile",//检查手机号是否注册
	checkUsername:serverBaseUrl+"site/check-username",//检查用户名是否注册
	loginUrl:serverBaseUrl+"site/login",//登录Url
	registerUrl:serverBaseUrl+"site/register",//注册Url
	sendVerifyCodeUrl:serverBaseUrl+"site/send-verify-code",//注册Url
	sendVerifyCode2Url:serverBaseUrl+"site/send-verify-code2",//修改密码发送验证码
	changePasswordUrl:serverBaseUrl+"site/change-password",//修改密码
	changePayPasswordUrl:serverBaseUrl+"site/change-pay-password",//修改密码
	getLoveInfoUrl:serverBaseUrl+"site/get-loveinfo",//获取喜欢的列表
	getPhotoNewsUrl:serverBaseUrl+"site/get-photo-news",//获取图片新闻
	getGoodsListUrl:serverBaseUrl+'goods/goods-list',//商品列表
	submitOilUrl:serverBaseUrl+'goods/submit-oil',//提交加油记录
	confirmOilUrl:serverBaseUrl+'goods/confirm-oil',//确认加油
	getGoodsCateListUrl:serverBaseUrl+'goods/cate-list',//分类列表
	uploadHeadImgUrl:serverBaseUrl+'user/upload-headimg',//上传头像
	updateHomeInfoUrl:serverBaseUrl+'user/update-home-info',//修改家庭信息
	updatePostUrl:serverBaseUrl+'user/update-post',//修改学历与职业信息
	updateProfileUrl:serverBaseUrl+'user/update-profile',//修改个人信息
	checkUserAccountUrl:serverBaseUrl+'user/check-account',//更新用户帐户信息
	updateUserDataUrl:serverBaseUrl+'user/user-data',//用户数据提交
	getWalletUrl:serverBaseUrl+'user/get-wallet',
	getMessageStateUrl:serverBaseUrl+'user/get-message-state',//获取消息状态
	getNotifyUrl:serverBaseUrl+'user/get-notify',
	getMsgNumUrl:serverBaseUrl+'user/get-msgnum',
	updateAlipayUrl:serverBaseUrl+'user/update-alipay',//修改支付宝账号
	updateNameUrl:serverBaseUrl+'user/update-name',//修改姓名
	updateNickUrl:serverBaseUrl+'user/update-nick',//修改姓名
	updateSexUrl:serverBaseUrl+'user/update-sex',//修改姓名
	updateSignUrl:serverBaseUrl+'user/update-sign',//修改姓名
	updateAddressUrl:serverBaseUrl+'user/update-address',//修改姓名
	withDrawUrl:serverBaseUrl+'user/with-draw',
	getScoreListUrl:serverBaseUrl+'user/get-score',//用户积分
	userSignUrl:serverBaseUrl+'user/user-sign',//用户积分
	checkSignUrl:serverBaseUrl+'user/check-sign',//用户积分
	getShoppingCartUrl:serverBaseUrl+'user/get-shoppingcart',//获取购物车列表
	deleteCartUrl:serverBaseUrl+'user/delete-cart',
	getGoodsLoveUrl:serverBaseUrl+'user/get-goodslove',//获取购物车列表
	deleteGoodsLoveUrl:serverBaseUrl+'user/delete-goodslove',
	addCartUrl:serverBaseUrl+'user/add-cart',
	goodsLoveUrl:serverBaseUrl+'user/goods-love',
	getUserReportUrl:serverBaseUrl+'user/user-report',
	checkUserUrl:serverBaseUrl+'user/check-user',
	submitAuthUrl:serverBaseUrl+'user/submit-auth',
	getUnitSetUrl:serverBaseUrl+'site/get-unit',
	getCateUrl:serverBaseUrl+'site/get-cate',
	getBestGoodsUrl:serverBaseUrl+'site/get-best-goods',
	getNewThingsUrl:serverBaseUrl+'site/get-new-things',
	submitGoodsUrl:serverBaseUrl+'goods/submit-goods',
	getGoodsDetailUrl:serverBaseUrl+'goods/goods-detail',
	getTemplateListUrl:serverBaseUrl+'goods/template-list',
	delTemplateUrl:serverBaseUrl+'goods/del-template',
	getGoodsDataUrl:serverBaseUrl+'goods/goods-data',
	getGoodsCateUrl:serverBaseUrl+'goods/goods-cate',
	searchGoodsUrl:serverBaseUrl+'goods/goods-search',
	getUserGoodsListUrl:serverBaseUrl+'goods/user-goods',
	payDepositUrl:serverBaseUrl+'goods/pay-deposit',
	submitOrderUrl:serverBaseUrl+'goods/submit-order',
	tempalteSetUrl:serverBaseUrl+'goods/template-set',
	getTemplateDataUrl:serverBaseUrl+'goods/template-data',
	getOrderDetailUrl:serverBaseUrl+'goods/order-detail',
	getOrderDataUrl:serverBaseUrl+'goods/order-data',
	getSellerOrderUrl:serverBaseUrl+'goods/seller-order',
	getBuyerOrderUrl:serverBaseUrl+'goods/buyer-order',
	getPayOrderUrl:serverBaseUrl+'goods/pay-order',
	getPaySuccessUrl:serverBaseUrl+'goods/pay-success',
	getMyPubUrl:serverBaseUrl+'goods/my-pub',
	getMyAuthViewUrl:serverBaseUrl+'user/get-auth-view',
	getHomeBannerUrl:serverBaseUrl+'site/get-home-banner',
	getHomeTopUrl:serverBaseUrl+'site/get-home-top',
	getEoilTopUrl:serverBaseUrl+'site/get-eoil-top',
	getHomeNewsUrl:serverBaseUrl+'site/get-home-news',
	getRecGoodsUrl:serverBaseUrl+'site/get-rec-goods',
	getMerchantsUrl:serverBaseUrl+'site/get-merchants',
	alipayWapPay:serverBaseUrl+'goods/alipay-wappay',
	withdrawOrderUrl:serverBaseUrl+'goods/withdraw-order',
	confirmOrderUrl:serverBaseUrl+'goods/confirm-order',
	cancelOrderUrl:serverBaseUrl+'goods/cancel-order',
	uploadLocationUrl:serverBaseUrl+'user/upload-location',
	getUserLocUrl:serverBaseUrl+'user/get-user-location',
	updateShareScoreUrl:serverBaseUrl+'user/update-share-score',
	authLoginUrl:serverBaseUrl+'site/auth-login',
	bindMobileUrl:serverBaseUrl+'site/bind-mobile'
}