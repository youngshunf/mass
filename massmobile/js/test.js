var arr=[
		{time:"2016-12-01 04:04:23"},
		{time:"2016-12-01 05:04:23"},
		{time:"2016-12-01 07:04:23"},
		{time:"2016-12-01 07:24:33"},
		{time:"2016-12-01 07:45:13"},
		{time:"2016-12-01 08:13:43"},
		{time:"2016-12-01 08:34:23"},
		{time:"2016-12-01 09:01:53"},
		{time:"2016-12-01 09:15:13"},
		{time:"2016-12-01 09:24:33"},
		{time:"2016-12-01 09:44:33"},
		{time:"2016-12-01 10:04:23"},
		{time:"2016-12-01 10:24:33"},
		{time:"2016-12-01 10:45:13"},
		{time:"2016-12-01 22:43:13"}
	];
	
    var res=[];
    for(var i=0;i<=23;i++){
    	   var value=[];
    	   for(var j in arr){
    	   	 var str=arr[j].time.split(' ')[1].split(':')[0];
    	   	  str=parseInt(str);
    	   	  if(i===str){
    	   	  	 value.push(arr[j]);
    	   	  }
    	   }
    	   res[i]=value;
    }
    console.log(res);