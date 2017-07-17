function getFindIndex(){
	getTop();
	getBestGoods();
	getNewThings();
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
function getTop(){
	mui.ajax({
	type:"post",
	url:config.getEoilTopUrl,
	async:true,
	success:function(rs){
		$('#eiol-item').html(rs);
		vswiper = new Swiper('#top-slider', {
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

function getBestGoods(){
	mui.ajax({
	type:"post",
	url:config.getBestGoodsUrl,
	async:true,
	success:function(rs){
		$('#best-goods').html(rs);
		bswiper = new Swiper('#best-goods', {
			pagination: '.swiper-pagination',
	        paginationClickable: true,
	        spaceBetween: 0,
	        centeredSlides: true,
	        autoplay: 2500,
	        autoplayDisableOnInteraction: false
	    });
	},
	error:function(e){
		
		console.log("获取心动好货失败!"+e.status);
	}
	});
}

function getNewThings(){
	mui.ajax({
	type:"post",
	url:config.getNewThingsUrl,
	async:true,
	success:function(rs){
		$('#new-things').html(rs);
	},
	error:function(e){
		
		console.log("获取新鲜事失败!"+e.status);
	}
	});
	
}

mui.ready(function(){
	getFindIndex();
})