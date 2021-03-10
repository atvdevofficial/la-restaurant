import Vue from 'vue'
import moment from 'moment';

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
  });

  //filter event date and time
  Vue.filter('myDateTime', function(created){
    return moment(created).format("ddd, MMM D, h:mm A")
  });

  Vue.filter('myTime', function(created){
    return moment(created).format("h:mm A")
  });

  Vue.filter('myDate', function(created){
    return moment(created).format("ddd, MMMM D")
  });
