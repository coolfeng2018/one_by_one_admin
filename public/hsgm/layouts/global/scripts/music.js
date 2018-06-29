/**
提现声音提醒
**/
var Music = function () {
	var m;
	var action = 0;
	var is_new = 0;
	var new_url = '/withdraw/getNewWithdraw';
	const audio = new Audio('/hsgm/layouts/layout/music/WeChat.mp3');
    // Handles quick sidebar toggler
    var handleMusicToggler = function () {
        audio.play();
    };

    var kkk = function () {
        action = 1;
    };

    //停止播放
    var stopCount = function () {
        clearTimeout(m);
    };

    //Ajax
    var ajax = function () {
        $.ajax({
        	async: false,
        	cache: false,
            type : "get",
            url : new_url,	  
        	dataType: 'json',    
            success : function(data) {
            	if(data.code==200){ 
	            	is_new = 1;
	            }else{
	            	is_new = 0;
	            }
            }, 
            error: function(request) {
            	is_new = 0;
            }
        });
    };

    //循环播放
    var playPause = function () {
        clearTimeout(m);
        console.log('actionMusic');
        ajax();
        if(is_new==1){
        	handleMusicToggler();
        	m = setTimeout(function(){ playPause() }, 5000);
        }else{
        	m = setTimeout(function(){ playPause() }, 5000);
        }
    };

    return {
        init: function () {
        	kkk();
            //layout handlers
            if(action==1){
            	playPause();
            }
            
        }
    };

}();

jQuery(document).ready(function() {    
   Music.init(); // init music compose
});