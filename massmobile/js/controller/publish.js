var pubApp = angular.module('eoil', [])

.controller('pubCtrl', function($scope) {
	var initParam = function() {
		$scope.title="发布信息";
		$scope.currentCate={};
		$scope.formData = {
			imgs: [],
			photos:[],
			name: '',
			price: '',
			stock: '',
			unit: '',
			cate: {
				selected:{},
				cateStr:''
			},
			endTime: '',
			mobile: '',
			qq: '',
			address: '',
			desc: '',
			hide_phone:'0',
			hide_name:'0'
		};
		$cateInfo={};
		var userInfo = app.getUserInfo();
		$scope.userInfo = userInfo;
		if(userInfo.mobile) {
			$scope.formData.mobile = userInfo.mobile;
		}
		if(userInfo.qq) {
			$scope.formData.mobile = userInfo.qq;
		}

	}
	initParam();
	function getTemplate(id){
		var data={
			id:id
		};
		$.ajax({
			type: "post",
			url: app.getAuthUrl(config.getTemplateDataUrl),
			data:{
				data:data
			},
			success: function(rs) {
				console.log(rs);
				if(typeof rs == 'string') {
					rs = JSON.parse(rs);
				}
				if(rs.result == 'success') {
					$scope.$apply(function() {
						$scope.templateData = rs.data;
						$scope.formData=rs.data.templateData;
						$scope.currentCate=rs.data.cate ||{};
						$scope.formData.action=$scope.action;
						$scope.formData.imgs=[];
						$scope.formData.price=parseFloat(rs.data.templateData.price);
						$scope.formData.photos=rs.data.photos;
						_.each($scope.formData.photos,function(item){
							item.url=photoUrl+item.path+'thumb/'+item.photo;
						})
//						$scope.formData.cate=rs.data.cate;
						$scope.formData.cate={
							cateStr:rs.data.cate.text,
							selected:[rs.data.cate]
						}
						getCate(rs.data.cate.value);
					})
				}
			},
			error:function(e){
				console.log(e);
			}
		});
	}
	
	function getGoods(id){
		var data={
			id:id
		};
		$.ajax({
			type: "post",
			url: app.getAuthUrl(config.getGoodsDataUrl),
			data:{
				data:data
			},
			success: function(rs) {
				console.log(rs);
				if(typeof rs == 'string') {
					rs = JSON.parse(rs);
				}
				if(rs.result == 'success') {
					$scope.$apply(function() {
						$scope.goodsData = rs.data;
						$scope.formData=rs.data.goodsData;
						$scope.formData.cate={
							cateStr:rs.data.cate.text,
							selected:[rs.data.cate]
						}
						$scope.formData.action=$scope.action;
						$scope.formData.imgs=[];
						$scope.currentCate=rs.data.cate;
						$scope.formData.price=parseFloat(rs.data.goodsData.price);
						$scope.formData.photos=rs.data.photos;
						_.each($scope.formData.photos,function(item){
							item.url=photoUrl+item.path+'thumb/'+item.photo;
						})
//						$scope.formData.cate=rs.data.cate;
						getCate(rs.data.cate.value);
					})
				}
			},
			error:function(e){
				console.log(e.status);
			}
		});
	}
	$scope.removePhoto=function(item){
		_.remove($scope.formData.photos,item);
	}
	$scope.remove=function(index){
     $scope.formData.imgs.splice(index,1);
	}
	mui(document).on('toggle','.phone-switch .mui-switch', function(event) {
					//event.detail.isActive 可直接获取当前状态
					console.log('.phone-switch .mui-switch')
		$scope.$apply(function(){
			$scope.formData.hide_phone= event.detail.isActive ? '1' : '0';
		}) 
	});
	mui(document).on('toggle','.name-switch .mui-switch', function(event) {
					//event.detail.isActive 可直接获取当前状态
					console.log('.name-switch .mui-switch')
		$scope.$apply(function(){
			$scope.formData.hide_name= event.detail.isActive ? '1' : '0';
		}) 
	});
	$scope.getLoc=function(){
    	   plus.geolocation.getCurrentPosition(function(position) {
			var timeflag = position.timestamp; //获取到地理位置信息的时间戳；一个毫秒数；		
			var codns = position.coords; //获取地理坐标信息；
			var lat = codns.latitude; //获取到当前位置的纬度；
			var lng = codns.longitude; //获取到当前位置的经度
			var alt = codns.altitude; //获取到当前位置的海拔信息；
			var accu = codns.accuracy; //地理坐标信息精确度信息；
			var locInfo = {
				timeflag: timeflag,
				lat: lat,
				lng: lng,
				address: position.addresses,
				city: "",
				name: "",
				alt: alt,
				accu: accu
			};
			$scope.$apply(function() {
				$scope.formData.address = locInfo.address;
			})
			console.log(JSON.stringify(locInfo));
			localStorage.setItem('$locInfo', JSON.stringify(locInfo));

		}, function(e) {
			console.log("获取位置信息失败：" + e.message);
			return;
		}, {
			provider: 'baidu'
		});
    }
	mui.plusReady(function() {
		var self=plus.webview.currentWebview();
		$scope.action=self.action;
		$scope.cateid=self.cateid;
		$scope.title=self.cateName;
		var userInfo=app.getUserInfo();
		if(userInfo.score<=0){
			mui.alert('您目前积分不足，不能发布信息，可以通过分享，签到等方式赚取积分!');
			mui.back();
		}else{
			init();
		}
		
		console.log($scope.action);
//		$scope.$apply(function(){
//			$scope.action=action;
//		})
		
		$scope.getLoc();
	})
    var getCate=function(cateid){
    		$.ajax({
			type: "post",
			url: config.getCateUrl,
			dataType: 'json',
			data:{
				cateid:cateid
			},
			success: function(rs) {
				console.log(JSON.stringify(rs));
				if(typeof rs == 'string') {
					rs = JSON.parse(rs);
				}
				if(rs.result == 'success') {
					$scope.$apply(function() {
						$scope.cate = rs.data.cateArr;
						$scope.formData.currentCate=rs.data.currentCate ||{};
						$scope.title=$scope.formData.currentCate.name;
						$scope.currentCate = rs.data.currentCate || {};
						if(angular.isString($scope.currentCate.template_fields) ){
							$scope.currentCate.template_fields=JSON.parse($scope.currentCate.template_fields);
						}
						//initCateData($scope.cate);
						console.log(JSON.stringify($scope.cate));
					})
				}
			},
			error: function(e) {
				console.log(e.status);
			}
		});
    }
    
	var init = function() {
		$.ajax({
			type: "post",
			url: config.getUnitSetUrl,
			dataType: 'json',
			success: function(rs) {
				if(typeof rs == 'string') {
					rs = JSON.parse(rs);
				}
				if(rs.result == 'success') {
					$scope.$apply(function() {
						$scope.unit = rs.data;
						console.log(JSON.stringify($scope.unit));
					})
				}
			}
		});
		var self=plus.webview.currentWebview();
		if($scope.action=='template'){
			var id=self.templateid;
			getTemplate(id);
		}else if($scope.action=='edit'){
			var id=self.goodsid;
			getGoods(id);
		}else{
			getCate($scope.cateid);
		}
		

	}
	
	$scope.goAuth = function() {
		var user = app.getUserInfo();
		if(user.is_submit_data == 1) {
			mui.openWindow({
				url: '../me/my-auth-view.html',
			});
		} else {
			mui.openWindow({
				url: '../me/my-auth.html',
			});
		}
	}
	$scope.submit = function(){
		console.log(JSON.stringify($scope.formData.cate));
		if($scope.formData.imgs.length < 1 && $scope.formData.photos.length < 1) {
			mui.alert('请至少上传一张图片');
			return false;
		}
		if($scope.currentCate.type==0){
			if(!$scope.formData.price) {
					mui.alert('请填写价格');
					return false;
				}
				if(!$scope.formData.stock) {
					mui.alert('请填写库存');
					return false;
				}
		
				if(!$scope.formData.unit) {
					mui.alert('请选择单位');
					return false;
				}
				if(!$scope.formData.endTime) {
					mui.alert('请填写下架时间');
					return false;
				}
		}
		if(!$scope.formData.name) {
			mui.alert('请填写标题');
			return false;
		}
		
//		if(!$scope.formData.cate.cateStr) {
//			mui.alert('请选择产品分类');
//			return false;
//		}
		
		if(!$scope.formData.mobile) {
			mui.alert('请填写联系方式');
			return false;
		}
		if(!$scope.formData.address) {
			mui.alert('请填写地址');
			return false;
		}
		if(!$scope.formData.desc) {
			mui.alert('请填写描述');
			return false;
		}
		$scope.formData.template_fields=$scope.currentCate.template_fields;
		var data = {
			data: angular.toJson($scope.formData, true)
		};
		plus.nativeUI.showWaiting('正在提交,请稍后...');
		console.log(app.getAuthUrl(config.submitGoodsUrl));
		$.ajax({
			type: "post",
			url: app.getAuthUrl(config.submitGoodsUrl),
			data: data,
			success: function(rs) {
				console.log(rs);
				plus.nativeUI.closeWaiting();
				if(typeof rs == 'string') {
					rs = JSON.parse(rs);
				}
				if(rs.result == 'success') {
					initParam();
					mui.alert('您的信息已发布成功!');
					mui.openWindow({
						id: 'goods-detail',
						url: '../goods-detail.html',
						extras: {
							goodsid: rs.data
						}
					});
				}
			},
			error: function(e) {
				plus.nativeUI.closeWaiting();
				console.log(e.status);
				mui.alert('提交失败,请稍候重试!')
			}
		});
	}


	window.addEventListener('show', function() {
		console.log('show');
		init();
	});
	$scope.showCatePicker = function() {
		console.log('catePicker');
		try {
			var catePicker = new mui.PopPicker();
			catePicker.setData($scope.cate);
			catePicker.show(function(items) {
				$scope.$apply(function() {
					console.log(JSON.stringify(items));
					$scope.formData.cate.selected = items;
					$scope.formData.cate.cateStr=items[0].text;
					$scope.currentCate=items[0];
				})
			});
		} catch(e) {
			console.log(e);
		}
	}
	$scope.selectUnit = function() {
		var btnArray = [];
		for(var i in $scope.unit) {
			btnArray.push({
				title: $scope.unit[i].desc
			})
		}
		plus.nativeUI.actionSheet({
			cancel: "取消",
			buttons: btnArray
		}, function(e) {
			var index = e.index;
			$scope.$apply(function() {
				$scope.formData.unit = btnArray[index - 1].title;
			})
		});
	}
	$scope.selectEndTime = function() {
//		var dDate = new Date();
//		dDate.setFullYear(moment().format('YYYY,M,DD'));
//		var minDate = new Date();
//		minDate.setFullYear(moment().format('YYYY,M,DD'));
//		var maxDate = new Date();
//		maxDate.setFullYear(2020, 12, 31);
//		plus.nativeUI.pickDate(function(e) {
//			var d = e.date;
//			$scope.$apply(function() {
//				$scope.formData.endTime = moment(d).format('YYYY-MM-DD hh:mm');
//				console.log($scope.formData.endTime);
//			})
//		}, function(e) {
//			console.log("您没有选择日期");
//		}, {
//			title: "请选择日期",
//			date: dDate,
//			minDate: minDate,
//			maxDate: maxDate
//		});
        var options={
        		value:moment().format('YYYY-MM-DD hh:mm'),
        		beginYear:moment().format('YYYY'),
        		endYear:'2100'
        }
        console.log(options);
		var picker = new mui.DtPicker(options);
		picker.show(function(rs) {
			console.log(rs);
			$scope.$apply(function(){
				$scope.formData.endTime= rs.text;
			})
			picker.dispose();
		});
	}
	$scope.addPhoto = function() {
		var btnArray = [{
			title: "拍照"
		}, {
			title: "相册选择"
		}];
		plus.nativeUI.actionSheet({
			cancel: "取消",
			buttons: btnArray
		}, function(event) {
			var index = event.index;
			switch(index) {
				case 1:
					plus.camera.getCamera().captureImage(function(p) {
						plus.io.resolveLocalFileSystemURL(p, function(entry) {
							var localUrl = entry.toLocalURL();
							appendFile(localUrl);
						}, function(e) {
							console.log("读取拍照文件错误：" + e.message);
						});

					});
					break;
				case 2:
					plus.gallery.pick(function(p) {
						appendFile(p);
					});

					break;

			}
		}, false);

	}

	var appendFile = function(p) {
		console.log(p);
		if(p) {
			plus.nativeUI.showWaiting();
			//压缩图片
			lrz(p, {
					width: 1024
				})
				//处理成功
				.then(function(rst) {
					plus.nativeUI.closeWaiting();
					$scope.$apply(function() {
						$scope.formData.imgs.push(rst.base64);
					});
				})
				// 处理失败
				.catch(function(err) {
					plus.nativeUI.closeWaiting();
					console.log('图片压缩失败!');
				});
		}
	};

});