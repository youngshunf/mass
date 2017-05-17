 //分享链接点击事件
		mui(document).on("tap",'#share', function() {
			var ids = [{
					id: "weixin",
					ex: "WXSceneSession"
				}, {
					id: "weixin",
					ex: "WXSceneTimeline"
				},
//				{
//					id: "sinaweibo"
//				},
//				{
//					id: "tencentweibo"
//				},
				{
					id: "qq"
				}],
				bts = [{
					title: "发送给微信好友"
				}, {
					title: "分享到微信朋友圈"
				}, 
//				{
//					title: "分享到新浪微博"
//				},
//				{
//					title: "分享到腾讯微博"
//				},
				{
					title: "分享到QQ"
				}];
			plus.nativeUI.actionSheet({
				cancel: "取消",
				buttons: bts
			}, function(e) {
				var i = e.index;
				if (i > 0) {
					var s_id = ids[i - 1].id;
					var share = shares[s_id];
					if (share.authenticated) {
						shareMessage(share, ids[i - 1].ex);
					} else {
						share.authorize(function() {
							shareMessage(share, ids[i - 1].ex);
						}, function(e) {
							console.log("认证授权失败：" + e.code + " - " + e.message);
						});
					}
				}
			});
		});
		
		function updateShareScore(){
			mui.ajax({
				url:app.getAuthUrl(config.updateShareScoreUrl),
				type:"post",
				success:function(rs){
					console.log(rs);
				},
				error:function(e){
					console.log(e.status);
				}
			})
		}

		function shareMessage(share, ex) {
				var msg = {
					extra: {
						scene: ex
					}
				};
				if(mui.os.ios){
					msg.href = "https://itunes.apple.com/cn/app/e-you-wang/id1191691825?mt=8";
				}else{
					msg.href="http://android.myapp.com/myapp/detail.htm?apkName=com.yangshunfu.mass";
//					msg.href="http://www.wandoujia.com/apps/com.young.eoil";
				}
				
				msg.title = "大众广告";
				msg.content = "大众广告是永久免费发布信息的平台，免费为大众提供发布招聘求职、房产、汽车服务（新车，二手车、专车、租车、拼车、代驾）、公益（献爱心、留言板、祝福栏）、大众加油、大众新闻、购物（吃喝玩乐、衣食住行、代送代取）、教育培训、婚恋交友、服务上门等信息类、购物类、新闻类、工具类查询信息。";
//				if (~share.id.indexOf('weibo')) {
//					msg.content += "；体验地址：http://suoxinmr.com/";
//				}
				msg.thumbs = ["_www/images/logo.png"];
				share.send(msg, function() {
					console.log("分享到\"" + share.description + "\"成功！ ");
					updateShareScore();
				}, function(e) {
					console.log("分享到\"" + share.description + "\"失败: " + e.code + " - " + e.message);
				});
			}