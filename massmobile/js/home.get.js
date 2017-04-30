function getHomeList(){
//	getHomeBanner();
//	getHomeTop();
//	getEoilTop();
	getHomeNews();
	getLoveInfo();
	
}

function getHomeBanner(){
	mui.ajax({
	type:"post",
	url:config.getHomeBannerUrl,
	async:true,
	success:function(rs){
		$('#slider-item').html(rs);
		swiper = new Swiper('#home-slider', {
	        pagination: '.swiper-pagination',
	        paginationClickable: true,
	        spaceBetween: 0,
	        centeredSlides: true,
	        autoplay: 2500,
	        autoplayDisableOnInteraction: false
	    });
	},
	error:function(e){
		
		console.log("获取首页banner失败!"+e.status);
	}
	});
}
function getEoilTop(){
	mui.ajax({
	type:"post",
	url:config.getEoilTopUrl,
	async:true,
	success:function(rs){
		$('#eiol-item').html(rs);
		vswiper1 = new Swiper('#top-slider', {
	        pagination: '.swiper-pagination',
	        paginationClickable: true,
	        spaceBetween: 0,
	        direction: 'vertical',
	        centeredSlides: true,
	        loop:true,
	        autoplay: 2500,
	        autoplayDisableOnInteraction: false
	    });
	},
	error:function(e){
		
		console.log("获取首页banner失败!"+e.status);
	}
	});
}
function getHomeTop(){
	mui.ajax({
	type:"post",
	url:config.getHomeTopUrl,
	async:true,
	success:function(rs){
		$('#news-one').html(rs);
		
	},
	error:function(e){
		console.log("获取行业推荐失败!"+e.status);
	}
	});
}
function getHomeNews(){
	$.ajax({
	type:"post",
	url:config.getHomeNewsUrl,
	async:true,
	success:function(rs){
		$('#news-one').html(rs);
	},
	error:function(e){
		console.log("获取新闻失败!"+e.status);
	}
	});
	
	$.ajax({
	type:"post",
	url:config.getPhotoNewsUrl,
	success:function(rs){
		$('#news-two').html(rs);
		 pswiper = new Swiper('#news-two', {
				paginationClickable: true,
				spaceBetween: 0,
				loop: true,
				autoplayDisableOnInteraction: false
			});
	},
	error:function(e){
		console.log("获取图片新闻失败!"+e.status);
	}
	});
}
function getLoveInfo(){
	$.ajax({
	type:"post",
	url:app.getAuthUrl(config.getLoveInfoUrl),
	success:function(rs){
		 console.log(rs);
		$('#love-info').html(rs);
	},
	error:function(e){
		console.log("获取猜你喜欢失败!"+e.status);
	}
	});
}
